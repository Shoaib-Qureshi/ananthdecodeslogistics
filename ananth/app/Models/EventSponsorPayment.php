<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSponsorPayment extends Model
{
    protected $fillable = [
        'event_id', 'sponsor_package_id', 'company', 'contact_name', 'email', 'phone',
        'billing_address', 'gst_number', 'currency', 'base_amount', 'tax_amount',
        'total_amount', 'tax_percentage', 'tax_label', 'status', 'razorpay_order_id',
        'razorpay_payment_id', 'razorpay_signature', 'paid_at',
    ];

    protected $casts = [
        'base_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function package()
    {
        return $this->belongsTo(EventSponsorPackage::class, 'sponsor_package_id');
    }
}
