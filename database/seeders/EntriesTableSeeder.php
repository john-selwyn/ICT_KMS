<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EntriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Networks', 'Hardware', 'Printer', 'Router', 'Software'];

        for ($i = 0; $i < 10; $i++) {
            DB::table('approve_entries')->insert([
                'title' => 'Dummy Title - ' . ($i + 1),
                'description' => 'This is a description for dummy entry - ' . ($i + 1),
                'category_id' => array_rand($categories), // Assuming category_id is an integer
                'attachments' => 'dummy_attachment_' . ($i + 1) . '.jpg', // Example file names
                'youtube_url' => 'https://youtube.com/watch?v=' . Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

