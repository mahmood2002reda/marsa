<?php

namespace App\Traits;

use Stichoza\GoogleTranslate\GoogleTranslate;

trait TranslationTrait
{
    /**
     * Translate content from one language to another using Google Translate.
     *
     * @param array $data The data to be translated.
     * @param string $sourceLocale The source language code.
     * @param string $targetLocale The target language code.
     * @return array The translated data.
     */
    public function translateContent($translationData, $fromLocale, $toLocale)
    {
        // استخدم Google Translate لترجمة المحتوى
        $tr = new GoogleTranslate($toLocale); // Target language
    
        // ترجم كل الحقول من اللغة الأصلية إلى اللغة الهدف
        $translatedContent = [
            'tour_duration' => $tr->translate($translationData['tour_duration']),
            'must_know' => $tr->translate($translationData['must_know']),
            'location' => $tr->translate($translationData['location']),
            'type' => $tr->translate($translationData['type']),
            'governorate' => $tr->translate($translationData['governorate']),
            'name' => $tr->translate($translationData['name']),
            'description' => $tr->translate($translationData['description']),
            'services' => $tr->translate($translationData['services']),
        ];
    
        return $translatedContent;
    }

    public function saveTranslations($tour, $locale, $translationData)
    {
        $tour->translateOrNew($locale)->tour_duration = $translationData['tour_duration'];
        $tour->translateOrNew($locale)->must_know = $translationData['must_know'];
        $tour->translateOrNew($locale)->location = $translationData['location'];
        $tour->translateOrNew($locale)->type = $translationData['type'];
        $tour->translateOrNew($locale)->governorate = $translationData['governorate'];
        $tour->translateOrNew($locale)->name = $translationData['name'];
        $tour->translateOrNew($locale)->description = $translationData['description'];
        $tour->translateOrNew($locale)->services = $translationData['services'];
    }
}
