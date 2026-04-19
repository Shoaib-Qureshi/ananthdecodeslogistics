<?php

namespace App\Support;

use App\Models\ContributorPlan;
use Illuminate\Support\Facades\Schema;
use Throwable;

final class ContributorPlans
{
    public const FREE = 'free';
    public const STARTER = 'starter_contributor';
    public const GROWTH = 'growth_contributor';
    public const AUTHORITY = 'authority_contributor';

    private static ?array $resolvedPlans = null;

    public static function defaults(): array
    {
        return [
            self::FREE => [
                'code' => self::FREE,
                'public' => false,
                'name' => 'Complimentary Contributor',
                'admin_name' => 'Complimentary / Internal',
                'price' => 0,
                'currency' => 'USD',
                'price_label' => 'Complimentary',
                'duration_months' => null,
                'duration_label' => 'Internal access',
                'max_posts' => null,
                'post_limit_label' => 'Unlimited submissions',
                'homepage_feature' => false,
                'summary' => 'Internal-only contributor access for manual admin setup.',
                'highlights' => [
                    'Not shown on the public signup form',
                    'Unlimited submissions',
                    'No automatic homepage featuring',
                ],
                'checkout_name' => 'Complimentary Contributor Access',
                'checkout_description' => 'Internal-only complimentary contributor access.',
                'success_label' => 'Complimentary Contributor',
                'success_note' => 'Your contributor account is active with complimentary internal access.',
                'renew_cta' => 'Upgrade Plan',
            ],
            self::STARTER => [
                'code' => self::STARTER,
                'public' => true,
                'name' => 'Starter Contributor',
                'admin_name' => 'Starter Contributor',
                'price' => 0,
                'currency' => 'USD',
                'price_label' => '$0',
                'duration_months' => 3,
                'duration_label' => '3 months',
                'max_posts' => 3,
                'post_limit_label' => 'Up to 3 articles',
                'homepage_feature' => false,
                'summary' => 'A low-friction entry tier for testing your voice with The Expert Desk.',
                'highlights' => [
                    'Author profile with bio and credentials',
                    'Co-branded LinkedIn and X promotion',
                    'Reach a focused logistics audience',
                ],
                'checkout_name' => 'Starter Contributor Access',
                'checkout_description' => 'Three-month Expert Desk access with up to 3 article submissions.',
                'success_label' => 'Starter Contributor - $0',
                'success_note' => 'Your Starter Contributor access is active for 3 months and includes up to 3 article submissions.',
                'renew_cta' => 'Renew or Upgrade',
            ],
            self::GROWTH => [
                'code' => self::GROWTH,
                'public' => true,
                'name' => 'Growth Contributor',
                'admin_name' => 'Growth Contributor',
                'price' => 50,
                'currency' => 'USD',
                'price_label' => '$50',
                'duration_months' => 6,
                'duration_label' => '6 months',
                'max_posts' => 8,
                'post_limit_label' => 'Up to 8 articles',
                'homepage_feature' => false,
                'summary' => 'A credibility-building plan for professionals who want stronger reach over a longer runway.',
                'highlights' => [
                    'Faster editorial turnaround',
                    'Newsletter feature eligibility',
                    'Branding support from the editorial team',
                ],
                'checkout_name' => 'Growth Contributor Access',
                'checkout_description' => 'Six-month Expert Desk access with up to 8 article submissions.',
                'success_label' => 'Growth Contributor - $50',
                'success_note' => 'Your Growth Contributor access is active for 6 months and includes up to 8 article submissions. Extended promotional benefits are coordinated manually by the editorial team.',
                'renew_cta' => 'Renew or Upgrade',
            ],
            self::AUTHORITY => [
                'code' => self::AUTHORITY,
                'public' => true,
                'name' => 'Authority Contributor',
                'admin_name' => 'Authority Contributor',
                'price' => 80,
                'currency' => 'USD',
                'price_label' => '$80',
                'duration_months' => 12,
                'duration_label' => '12 months',
                'max_posts' => null,
                'post_limit_label' => 'Unlimited submissions',
                'homepage_feature' => true,
                'summary' => 'A premium thought-leadership tier for experts who want year-long presence and feature eligibility.',
                'highlights' => [
                    'Unlimited fair-use article submissions',
                    'Homepage featured placement eligibility',
                    'Spotlight and report collaboration opportunities',
                ],
                'checkout_name' => 'Authority Contributor Access',
                'checkout_description' => 'Twelve-month Expert Desk access with unlimited fair-use submissions and homepage featured eligibility.',
                'success_label' => 'Authority Contributor - $80',
                'success_note' => 'Your Authority Contributor access is active for 12 months, supports unlimited fair-use submissions, and makes approved posts eligible for homepage featured placement.',
                'renew_cta' => 'Renew Authority Access',
            ],
        ];
    }

    public static function all(): array
    {
        if (static::$resolvedPlans !== null) {
            return static::$resolvedPlans;
        }

        $plans = static::defaults();

        try {
            if (!Schema::hasTable('contributor_plans')) {
                return static::$resolvedPlans = $plans;
            }

            $storedPlans = ContributorPlan::query()->get()->keyBy('code');

            if ($storedPlans->isEmpty()) {
                return static::$resolvedPlans = $plans;
            }

            foreach ($plans as $code => $defaultPlan) {
                $storedPlan = $storedPlans->get($code);

                if (!$storedPlan) {
                    continue;
                }

                $plans[$code] = static::mergePlan($defaultPlan, $storedPlan->toSupportArray());
            }
        } catch (Throwable $exception) {
            return static::$resolvedPlans = $plans;
        }

        return static::$resolvedPlans = $plans;
    }

    public static function clearCache(): void
    {
        static::$resolvedPlans = null;
    }

    public static function publicPlans(): array
    {
        return array_filter(static::all(), static function (array $plan) {
            return $plan['public'] === true;
        });
    }

    public static function adminSelectablePlans(): array
    {
        return static::all();
    }

    public static function publicPlanCodes(): array
    {
        return array_keys(static::publicPlans());
    }

    public static function adminSelectableCodes(): array
    {
        return array_keys(static::adminSelectablePlans());
    }

    public static function legacyMap(): array
    {
        return [
            'paid_standard' => self::STARTER,
            'paid_featured' => self::GROWTH,
        ];
    }

    public static function normalize(?string $code, ?string $fallback = self::FREE): ?string
    {
        if ($code === null || $code === '') {
            return $fallback;
        }

        if (isset(static::legacyMap()[$code])) {
            return static::legacyMap()[$code];
        }

        return array_key_exists($code, static::all()) ? $code : $fallback;
    }

    public static function get(?string $code, ?string $fallback = self::FREE): array
    {
        $normalized = static::normalize($code, $fallback) ?? self::FREE;

        return static::all()[$normalized];
    }

    public static function label(?string $code, bool $admin = false): string
    {
        $plan = static::get($code);

        return $admin ? $plan['admin_name'] : $plan['name'];
    }

    public static function price(?string $code): int
    {
        return (int) static::get($code)['price'];
    }

    public static function isComplimentary(?string $code): bool
    {
        return static::price($code) <= 0;
    }

    public static function currency(?string $code): string
    {
        return (string) static::get($code)['currency'];
    }

    public static function priceLabel(?string $code): string
    {
        return (string) static::get($code)['price_label'];
    }

    public static function checkoutName(?string $code): string
    {
        return (string) static::get($code)['checkout_name'];
    }

    public static function checkoutDescription(?string $code): string
    {
        return (string) static::get($code)['checkout_description'];
    }

    public static function successLabel(?string $code): string
    {
        return (string) static::get($code)['success_label'];
    }

    public static function successNote(?string $code): string
    {
        return (string) static::get($code)['success_note'];
    }

    public static function renewCta(?string $code): string
    {
        return (string) static::get($code)['renew_cta'];
    }

    public static function hasHomepageFeature(?string $code): bool
    {
        return (bool) static::get($code)['homepage_feature'];
    }

    private static function mergePlan(array $defaultPlan, array $storedPlan): array
    {
        if (array_key_exists('highlights', $storedPlan) && is_array($storedPlan['highlights'])) {
            $storedPlan['highlights'] = array_values(array_filter(
                array_map(static fn ($item) => trim((string) $item), $storedPlan['highlights']),
                static fn (string $item): bool => $item !== ''
            ));
        }

        return array_replace(
            $defaultPlan,
            array_filter($storedPlan, static fn ($value) => $value !== null)
        );
    }
}
