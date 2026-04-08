<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait HandlesFaqs
{
    protected function resolveFaqPayload(Request $request): array
    {
        $hasFaqs = $request->boolean('has_faqs');

        $faqItems = collect($request->input('faq_items', []))
            ->map(function ($item) {
                return [
                    'question' => trim((string) data_get($item, 'question', '')),
                    'answer' => trim((string) data_get($item, 'answer', '')),
                ];
            })
            ->reject(function ($item) {
                return $item['question'] === '' && $item['answer'] === '';
            })
            ->values();

        if (!$hasFaqs) {
            return [
                'has_faqs' => false,
                'faqs' => [],
            ];
        }

        if ($faqItems->isEmpty()) {
            throw ValidationException::withMessages([
                'faq_items' => 'Add at least one FAQ item or turn FAQs off.',
            ]);
        }

        $hasIncompleteItems = $faqItems->contains(function ($item) {
            return $item['question'] === '' || $item['answer'] === '';
        });

        if ($hasIncompleteItems) {
            throw ValidationException::withMessages([
                'faq_items' => 'Each FAQ needs both a question and an answer.',
            ]);
        }

        return [
            'has_faqs' => true,
            'faqs' => $faqItems->all(),
        ];
    }
}
