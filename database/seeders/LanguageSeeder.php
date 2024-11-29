<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            ['name' => 'ss', 'code' => 'ss'],

            // Diğer dilleri buraya ekleyin
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}