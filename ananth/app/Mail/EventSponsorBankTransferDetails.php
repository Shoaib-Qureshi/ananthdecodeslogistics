<?php

namespace App\Mail;

use App\Models\EventSponsorPayment;
use App\Support\EventSponsorInvoicePdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventSponsorBankTransferDetails extends Mailable
{
    use Queueable, SerializesModels;

    public EventSponsorPayment $payment;

    public function __construct(EventSponsorPayment $payment)
    {
        $this->payment = $payment->loadMissing(['event', 'package']);
    }

    public function build()
    {
        return $this->subject('Complete your LogiSphere sponsorship via bank transfer')
            ->view('emails.events.sponsor-bank-transfer', [
                'payment'   => $this->payment,
                'bank'      => config('services.bank_transfer', []),
                'reference' => EventSponsorInvoicePdf::invoiceNumber($this->payment),
            ]);
    }
}
