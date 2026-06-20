<?php

namespace App\Support;

use App\Models\EventSponsorPayment;

class EventSponsorInvoicePdf
{
    private const COMPANY_GSTIN = '29ABFCA6103M1ZI';

    public static function invoiceNumber(EventSponsorPayment $payment): string
    {
        $date = optional($payment->paid_at ?: $payment->created_at)->format('Ymd') ?: now()->format('Ymd');
        return 'LS-' . $date . '-' . str_pad((string) $payment->id, 5, '0', STR_PAD_LEFT);
    }

    public static function filename(EventSponsorPayment $payment): string
    {
        return 'logisphere-invoice-' . self::invoiceNumber($payment) . '.pdf';
    }

    public static function make(EventSponsorPayment $payment): string
    {
        $payment->loadMissing(['event', 'package']);

        $invoiceNo = self::invoiceNumber($payment);
        $invoiceDate = optional($payment->paid_at ?: $payment->created_at)->format('d M Y') ?: now()->format('d M Y');
        $paymentRef = $payment->transfer_reference ?: 'Bank Transfer';
        $currency = $payment->currency ?: 'INR';
        $eventTitle = $payment->event?->publicTitle() ?: 'LogiSphere';
        $eventDate = $payment->event?->formattedDate() ?: 'To be announced';
        $packageName = trim(($payment->package?->name ?: 'Sponsorship') . ' Package');

        $items = [
            ['Sponsorship Package', $packageName, $currency . ' ' . number_format((float) $payment->base_amount, 2)],
            [$payment->tax_label ?: 'GST', 'GSTIN: ' . self::COMPANY_GSTIN, $currency . ' ' . number_format((float) $payment->tax_amount, 2)],
        ];

        $draw = [];
        self::rect($draw, 0, 0, 595, 842, [248, 251, 255]);
        self::rect($draw, 0, 742, 595, 100, [7, 17, 31]);
        self::rect($draw, 0, 738, 595, 4, [37, 98, 233]);
        self::rect($draw, 52, 684, 491, 72, [255, 255, 255]);
        self::strokeRect($draw, 52, 684, 491, 72, [216, 227, 240]);

        self::text($draw, 'ANANTH DECODES LOGISTICS', 52, 796, 10, [147, 197, 253], true);
        self::text($draw, 'LogiSphere Sponsorship Invoice', 52, 772, 21, [255, 255, 255], true);
        self::text($draw, 'GSTIN: ' . self::COMPANY_GSTIN, 52, 752, 10, [203, 213, 225], true);
        self::text($draw, 'System generated invoice for sponsorship payment confirmation.', 52, 736, 9, [203, 213, 225]);

        self::text($draw, 'INVOICE NO', 68, 728, 8, [100, 116, 139], true);
        self::text($draw, $invoiceNo, 68, 710, 12, [15, 23, 42], true);
        self::text($draw, 'DATE', 250, 728, 8, [100, 116, 139], true);
        self::text($draw, $invoiceDate, 250, 710, 12, [15, 23, 42], true);
        self::text($draw, 'PAYMENT REF', 380, 728, 8, [100, 116, 139], true);
        self::text($draw, self::short($paymentRef, 22), 380, 710, 12, [15, 23, 42], true);

        self::sectionTitle($draw, 'BILL TO', 52, 650);
        self::card($draw, 52, 518, 238, 114);
        self::text($draw, self::short($payment->company, 32), 68, 606, 13, [15, 23, 42], true);
        self::text($draw, 'Contact: ' . self::short($payment->contact_name, 30), 68, 584, 9, [71, 85, 105]);
        self::text($draw, 'Email: ' . self::short($payment->email, 34), 68, 568, 9, [71, 85, 105]);
        self::text($draw, 'Phone: ' . ($payment->phone ?: 'Not provided'), 68, 552, 9, [71, 85, 105]);
        self::text($draw, 'GSTIN: ' . self::short($payment->gst_number ?: 'Not provided', 34), 68, 536, 9, [71, 85, 105]);
        self::text($draw, 'Address: ' . self::short($payment->billing_address ?: 'Not provided', 42), 68, 520, 9, [71, 85, 105]);

        self::sectionTitle($draw, 'EVENT', 320, 650);
        self::card($draw, 320, 518, 223, 114);
        self::text($draw, self::short($eventTitle, 28), 336, 606, 13, [15, 23, 42], true);
        self::text($draw, 'Event Date: ' . $eventDate, 336, 584, 9, [71, 85, 105]);
        self::text($draw, 'Location: ' . self::short($payment->event?->location ?: 'Bengaluru', 30), 336, 568, 9, [71, 85, 105]);
        self::text($draw, 'Package: ' . self::short($packageName, 30), 336, 552, 9, [71, 85, 105]);

        self::rect($draw, 52, 466, 491, 34, [15, 23, 42]);
        self::text($draw, 'TYPE', 70, 478, 9, [191, 219, 254], true);
        self::text($draw, 'DESCRIPTION', 190, 478, 9, [191, 219, 254], true);
        self::text($draw, 'AMOUNT', 446, 478, 9, [191, 219, 254], true);

        $y = 432;
        foreach ($items as $index => [$type, $description, $amount]) {
            self::rect($draw, 52, $y - 4, 491, 34, $index % 2 === 0 ? [255, 255, 255] : [241, 245, 249]);
            self::line($draw, 52, $y - 4, 543, $y - 4, [226, 232, 240]);
            self::text($draw, $type, 70, $y + 8, 9, [51, 65, 85], true);
            self::text($draw, self::short($description, 42), 190, $y + 8, 9, [71, 85, 105]);
            self::text($draw, $amount, 430, $y + 8, 9, [15, 23, 42], true);
            $y -= 34;
        }

        self::rect($draw, 332, 298, 211, 58, [239, 246, 255]);
        self::strokeRect($draw, 332, 298, 211, 58, [191, 219, 254]);
        self::text($draw, 'TOTAL PAID', 350, 332, 9, [37, 99, 235], true);
        self::text($draw, $currency . ' ' . number_format((float) $payment->total_amount, 2), 350, 310, 18, [15, 23, 42], true);

        self::rect($draw, 52, 242, 491, 34, [255, 255, 255]);
        self::strokeRect($draw, 52, 242, 491, 34, [216, 227, 240]);
        self::text($draw, 'NOTE', 68, 263, 8, [37, 99, 235], true);
        self::text($draw, 'Supplier GSTIN: ' . self::COMPANY_GSTIN . '. Buyer GSTIN shown above when provided.', 112, 263, 8, [71, 85, 105]);

        self::line($draw, 52, 200, 543, 200, [216, 227, 240]);
        self::text($draw, 'Thank you for partnering with LogiSphere.', 52, 176, 12, [15, 23, 42], true);
        self::text($draw, 'This invoice was generated automatically by Ananth Decodes Logistics.', 52, 158, 9, [100, 116, 139]);
        self::text($draw, 'www.ananthdecodeslogistics.com', 52, 142, 9, [37, 99, 235], true);

        return self::pdfFromContent(implode('', $draw));
    }

    private static function card(array &$draw, int $x, int $y, int $w, int $h): void
    {
        self::rect($draw, $x, $y, $w, $h, [255, 255, 255]);
        self::strokeRect($draw, $x, $y, $w, $h, [216, 227, 240]);
    }

    private static function sectionTitle(array &$draw, string $text, int $x, int $y): void
    {
        self::text($draw, $text, $x, $y, 9, [37, 99, 235], true);
        self::line($draw, $x, $y - 8, $x + 64, $y - 8, [37, 99, 235]);
    }

    private static function rect(array &$draw, int $x, int $y, int $w, int $h, array $rgb): void
    {
        $draw[] = self::rgb($rgb) . " rg\n" . "$x $y $w $h re f\n";
    }

    private static function strokeRect(array &$draw, int $x, int $y, int $w, int $h, array $rgb): void
    {
        $draw[] = self::rgb($rgb) . " RG\n0.8 w\n" . "$x $y $w $h re S\n";
    }

    private static function line(array &$draw, int $x1, int $y1, int $x2, int $y2, array $rgb): void
    {
        $draw[] = self::rgb($rgb) . " RG\n0.8 w\n$x1 $y1 m $x2 $y2 l S\n";
    }

    private static function text(array &$draw, ?string $text, int $x, int $y, int $size, array $rgb, bool $bold = false): void
    {
        $font = $bold ? 'F2' : 'F1';
        $draw[] = "BT\n" . self::rgb($rgb) . " rg\n/$font $size Tf\n$x $y Td\n(" . self::escape($text) . ") Tj\nET\n";
    }

    private static function pdfFromContent(string $content): string
    {
        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R /F2 6 0 R >> >> /Contents 5 0 R >>\nendobj\n",
            "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
            "5 0 obj\n<< /Length " . strlen($content) . " >>\nstream\n" . $content . "endstream\nendobj\n",
            "6 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }
        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xref . "\n%%EOF";

        return $pdf;
    }

    private static function rgb(array $rgb): string
    {
        return number_format($rgb[0] / 255, 4, '.', '') . ' ' .
            number_format($rgb[1] / 255, 4, '.', '') . ' ' .
            number_format($rgb[2] / 255, 4, '.', '');
    }

    private static function short(?string $text, int $limit): string
    {
        $text = trim(preg_replace('/\s+/', ' ', (string) $text));
        return strlen($text) > $limit ? substr($text, 0, $limit - 3) . '...' : $text;
    }

    private static function escape(?string $text): string
    {
        $text = preg_replace('/[^\x20-\x7E]/', ' ', (string) $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return str_replace(['\\', '(', ')'], ['\\\\', '\(', '\)'], trim($text));
    }
}
