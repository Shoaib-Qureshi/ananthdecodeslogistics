<?php

namespace App\Models;

use App\Support\ContributorPlans;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_role',
        'status',
        'contributor_plan',
        'payment_status',
        'stripe_customer_id',
        'activated_at',
        'designation',
        'intro',
        'profile_pic',
        'username',
        'reason_for_joining',
        'rejection_reason',
    ];

    public function verifyUser()
    {
        return $this->hasOne('App\Models\VerifyUser');
    }

    public function contributorPosts()
    {
        return $this->hasMany(ContributorPost::class, 'user_id');
    }

    public function contributorPayments()
    {
        return $this->hasMany(ContributorPayment::class);
    }

    public function isAdmin()
    {
        return $this->user_role === 'admin';
    }

    public function isGuest()
    {
        return $this->user_role === 'guest';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function hasFeaturedContributorPlan()
    {
        return ContributorPlans::hasHomepageFeature($this->contributor_plan);
    }

    public function contributorPlanCode(?string $fallback = ContributorPlans::FREE): ?string
    {
        return ContributorPlans::normalize($this->contributor_plan, $fallback);
    }

    public function contributorPlanDetails(): array
    {
        return ContributorPlans::get($this->contributor_plan);
    }

    public function contributorPlanLabel(bool $admin = false): string
    {
        return ContributorPlans::label($this->contributor_plan, $admin);
    }

    public function contributorPlanEndsAt()
    {
        $plan = $this->contributorPlanDetails();
        $months = $plan['duration_months'] ?? null;

        if (!$months || !$this->activated_at) {
            return null;
        }

        return $this->activated_at->copy()->addMonthsNoOverflow($months);
    }

    public function contributorPlanExpired(): bool
    {
        $endsAt = $this->contributorPlanEndsAt();

        return $endsAt ? now()->greaterThan($endsAt) : false;
    }

    public function contributorPostLimit(): ?int
    {
        $limit = $this->contributorPlanDetails()['max_posts'] ?? null;

        return $limit === null ? null : (int) $limit;
    }

    public function remainingContributorPostSlots(?int $currentCount = null): ?int
    {
        $limit = $this->contributorPostLimit();

        if ($limit === null) {
            return null;
        }

        $count = $currentCount ?? $this->contributorPosts()->count();

        return max($limit - $count, 0);
    }

    public function hasReachedContributorPostLimit(?int $currentCount = null): bool
    {
        $remaining = $this->remainingContributorPostSlots($currentCount);

        return $remaining !== null && $remaining <= 0;
    }

    public function canSubmitContributorPosts(?int $currentCount = null): bool
    {
        return !$this->contributorPlanExpired() && !$this->hasReachedContributorPostLimit($currentCount);
    }

    public function contributorSubmissionRestrictionMessage(?int $currentCount = null): ?string
    {
        if ($this->contributorPlanExpired()) {
            return sprintf(
                'Your %s access has expired. Renew or upgrade your plan to submit new articles.',
                $this->contributorPlanLabel()
            );
        }

        if ($this->hasReachedContributorPostLimit($currentCount)) {
            return sprintf(
                'You have reached the article limit for your %s plan. Renew or upgrade to keep submitting.',
                $this->contributorPlanLabel()
            );
        }

        return null;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'activated_at' => 'datetime',
    ];
}
