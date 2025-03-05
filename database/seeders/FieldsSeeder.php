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
        
        Field::truncate();
        $fields = [
            [
                'title' => 'Company',
                'type' => 'string'
            ],
            [
                'title' => 'Country',
                'type' => 'string'
            ],
            [
                'title' => 'City',
                'type' => 'string'
            ],
            [
                'title' => 'State',
                'type' => 'string'
            ],
            [
                'title' => 'Zip',
                'type' => 'string'
            ],
            [
                'title' => 'Birthday',
                'type' => 'date'
            ],
            [
                'title' => 'Industry',
                'type' => 'string'
            ],
            [
                'title' => 'Job Title',
                'type' => 'string'
            ],
            [
                'title' => 'Address',
                'type' => 'string'
            ],
            [
                'title' => 'Website',
                'type' => 'link'
            ]
        ];

        foreach ($fields as $field) {
            Field::firstOrCreate($field);
        }
    }
}
