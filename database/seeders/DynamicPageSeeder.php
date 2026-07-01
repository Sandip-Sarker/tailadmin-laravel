<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DynamicPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dynamic_pages')->insert([
            [
                'page_title' => 'Privacy & Policy',
                'page_slug' => 'privacy-policy',
                'page_content' => 'This is the Privacy & Policy content. Update the content here as needed.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_title' => 'Terms & Conditions',
                'page_slug' => 'terms-and-conditions',
                'page_content' => 'This is the Terms & Conditions content. Update the content here as needed.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
