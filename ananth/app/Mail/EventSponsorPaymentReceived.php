<?php

namespace App\Mail;

use App\Models\EventSponsorPayment;
use App\Support\EventSponsorInvoicePdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventSponsorPaymentReceived extends Mailable
{
    use Queueable, SerializesModels;

    public EventSponsorPayment $payment;

    public function __construct(EventSponsorPayment $payment)
    {
        $this->payment = $payment->loadMissing(['event', 'package']);
    }

    public function build()
    {
        return $this->subject('Your LogiSphere sponsorship payment is confirmed')
            ->attachData(EventSponsorInvoicePdf::make($this->payment), EventSponsorInvoicePdf::filename($this->payment), [
                'mime' => 'application/pdf',
            ])
            ->view('emails.events.sponsor-payment-received');
    }
}
