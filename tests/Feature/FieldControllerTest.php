<?php

namespace Tests\Feature\Api;

use App\Models\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_fields()
    {
        Field::factory()->count(3)->create();

        $response = $this->getJson('/api/fields');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_get_paginated_fields()
    {
        Field::factory()->count(15)->create();

        $response = $this->getJson('/api/fields?per_page=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'total',
            'per_page',
        ]);
        $this->assertEquals(10, count($response->json('data')));
    }

    public function test_can_create_field()
    {
        $fieldData = [
            'title' => 'Test Field',
            'type' => 'string',
        ];

        $response = $this->postJson('/api/fields', $fieldData);

        $response->assertStatus(201);
        $response->assertJsonFragment($fieldData);
        $this->assertDatabaseHas('fields', $fieldData);
    }

    public function test_cannot_create_field_with_duplicate_title()
    {
        Field::factory()->state([
            'title' => 'Test Field',
            'type' => 'string',
        ])->create();

        $fieldData = [
            'title' => 'Test Field',
            'type' => 'number',
        ];

        $response = $this->postJson('/api/fields', $fieldData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    public function test_cannot_create_field_with_invalid_type()
    {
        $fieldData = [
            'title' => 'Test Field',
            'type' => 'invalid_type',
        ];

        $response = $this->postJson('/api/fields', $fieldData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('type');
    }

    public function test_can_update_field()
    {
        $field = Field::factory()->state([
            'title' => 'Original Title',
            'type' => 'string'
        ])->create();

        $updateData = [
            'title' => 'Updated Title',
            'type' => 'number',
        ];

        $response = $this->putJson("/api/fields/{$field->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
        $this->assertDatabaseHas('fields', $updateData);
    }

    public function test_can_get_specific_field()
    {
        $field = Field::factory()->create();

        $response = $this->getJson("/api/fields/{$field->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $field->id,
            'title' => $field->title,
            'type' => $field->type,
        ]);
    }

    public function test_can_delete_field()
    {
        $field = Field::factory()->create();

        $response = $this->deleteJson("/api/fields/{$field->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('fields', ['id' => $field->id]);
    }
}
