<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class FieldSubscribersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = Subscriber::all();
        $fields = Field::all();

        if ($subscribers->isEmpty() || $fields->isEmpty()) {
            return;
        }

        $subscribers->each(function ($subscriber) use ($fields) {
            $fields->random(rand(3, 6))->each(function ($field) use ($subscriber) {
                $subscriber->fields()->attach($field, [
                    'value' => match ($field->type) {
                        'date' => now()->subDays(rand(1, 365))->toDateString(),
                        'number' => rand(1, 100),
                        'boolean' => rand(0, 1) ? 'true' : 'false',
                        default => fake()->sentence(3),
                    }
                ]);
            });
        });
    }
}
