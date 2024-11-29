<?php

if (!function_exists('trans_dynamic')) {
    function trans_dynamic($key)
    {
        $languageCode = session('applocale', config('app.locale'));
        $translation = \App\Models\Translation::whereHas('language', function ($query) use ($languageCode) {
            $query->where('code', $languageCode);
        })->where('key', $key)->first();

        return $translation ? $translation->value : $key;
    }
}