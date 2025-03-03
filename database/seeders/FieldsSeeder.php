<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'title' => 'company',
                'type' => 'string'
            ],
            [
                'title' => 'country',
                'type' => 'string'
            ],
            [
                'title' => 'city',
                'type' => 'string'
            ],
            [
                'title' => 'state',
                'type' => 'string'
            ],
            [
                'title' => 'zip',
                'type' => 'string'
            ],
            [
                'title' => 'birthday',
                'type' => 'date'
            ],
            [
                'title' => 'industry',
                'type' => 'string'
            ],
            [
                'title' => 'job_title',
                'type' => 'string'
            ],
            [
                'title' => 'address',
                'type' => 'string'
            ],
            [
                'title' => 'website',
                'type' => 'string'
            ],
            [
                'title' => 'subscribed',
                'type' => 'boolean'
            ],
            [
                'title' => 'newsletter',
                'type' => 'boolean'
            ],
        ];

        foreach ($fields as $field) {
            Field::firstOrCreate($field);
        }
    }
}
