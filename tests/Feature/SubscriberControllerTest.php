<?php

namespace Tests\Feature\Api;

use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_subscribers()
    {
        Subscriber::factory()->count(5)->create();

        $response = $this->getJson('/api/subscribers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'total',
            'per_page',
        ]);
        $this->assertEquals(5, $response->json('total'));
    }

    public function test_can_create_subscriber()
    {
        $subscriberData = [
            'email' => 'andrei.preda.dev@gmail.com',
            'name' => 'Test User',
            'state' => 'active',
        ];

        $response = $this->postJson('/api/subscribers', $subscriberData);

        $response->assertStatus(201);
        $response->assertJsonFragment($subscriberData);
        $this->assertDatabaseHas('subscribers', $subscriberData);
    }

    public function test_can_create_subscriber_with_fields()
    {
        $field1 = Field::factory()->create(['type' => 'string']);
        $field2 = Field::factory()->create(['type' => 'link']);

        $subscriberData = [
            'email' => 'andrei.preda.dev@gmail.com',
            'name' => 'Test User',
            'state' => 'active',
            'fields' => [
                $field1->id => ['value' => 'Test Value'],
                $field2->id => ['value' => 'https://mailerlite.com'],
            ],
        ];

        $response = $this->postJson('/api/subscribers', $subscriberData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('subscribers', [
            'email' => 'andrei.preda.dev@gmail.com',
            'name' => 'Test User',
        ]);
        $this->assertDatabaseHas('field_subscriber', [
            'subscriber_id' => $response->json('id'),
            'field_id' => $field1->id,
            'value' => 'Test Value',
        ]);
        $this->assertDatabaseHas('field_subscriber', [
            'subscriber_id' => $response->json('id'),
            'field_id' => $field2->id,
            'value' => 'https://mailerlite.com',
        ]);
    }

    public function test_cannot_create_subscriber_with_duplicate_email()
    {
        Subscriber::factory()->create([
            'email' => 'andrei.preda.dev@gmail.com'
        ]);

        $subscriberData = [
            'email' => 'andrei.preda.dev@gmail.com',
            'name' => 'Another User',
            'state' => 'active',
        ];

        $response = $this->postJson('/api/subscribers', $subscriberData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_cannot_create_subscriber_with_invalid_state()
    {
        $subscriberData = [
            'email' => 'andrei.preda.dev@gmail.com',
            'name' => 'Test User',
            'state' => 'invalid-state',
        ];

        $response = $this->postJson('/api/subscribers', $subscriberData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('state');
    }
    
    public function test_can_get_specific_subscriber()
    {
        $subscriber = Subscriber::factory()->create();
        $field = Field::factory()->create();
        $subscriber->fields()->attach($field->id, ['value' => 'Test Value']);

        $response = $this->getJson("/api/subscribers/{$subscriber->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'email',
            'name',
            'state',
            'fields' => [
                '*' => [
                    'id',
                    'title',
                    'type',
                    'pivot' => [
                        'value'
                    ]
                ]
            ]
        ]);
    }

    public function test_can_update_subscriber()
    {
        $subscriber = Subscriber::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'state' => 'unsubscribed',
        ];

        $response = $this->putJson("/api/subscribers/{$subscriber->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updateData);
        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriber->id,
            'name' => 'Updated Name',
            'state' => 'unsubscribed',
        ]);
    }

    public function test_can_update_subscriber_with_fields()
    {
        $subscriber = Subscriber::factory()->create();
        $field1 = Field::factory()->create();
        $field2 = Field::factory()->create();
        
        $subscriber->fields()->attach($field1->id, ['value' => 'Old Value']);

        $updateData = [
            'name' => 'Updated Name',
            'fields' => [
                $field1->id => ['value' => 'Updated Value'],
                $field2->id => ['value' => 'New Field Value'],
            ],
        ];

        $response = $this->putJson("/api/subscribers/{$subscriber->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('field_subscriber', [
            'subscriber_id' => $subscriber->id,
            'field_id' => $field1->id,
            'value' => 'Updated Value',
        ]);
        $this->assertDatabaseHas('field_subscriber', [
            'subscriber_id' => $subscriber->id,
            'field_id' => $field2->id,
            'value' => 'New Field Value',
        ]);
    }
    
    public function test_can_remove_subscriber_fields()
    {
        $subscriber = Subscriber::factory()->create();
        $field1 = Field::factory()->create();
        $field2 = Field::factory()->create();
        
        $subscriber->fields()->attach([
            $field1->id => ['value' => 'Value 1'],
            $field2->id => ['value' => 'Value 2']
        ]);

        $updateData = [
            'fields' => [
                $field1->id => ['value' => 'Updated Value'],
            ],
        ];

        $response = $this->putJson("/api/subscribers/{$subscriber->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('field_subscriber', [
            'subscriber_id' => $subscriber->id,
            'field_id' => $field1->id,
        ]);
        $this->assertDatabaseMissing('field_subscriber', [
            'subscriber_id' => $subscriber->id,
            'field_id' => $field2->id,
        ]);
    }

    public function test_can_delete_subscriber()
    {
        $subscriber = Subscriber::factory()->create();
        $field = Field::factory()->create();
        $subscriber->fields()->attach($field->id, ['value' => 'Test Value']);

        $response = $this->deleteJson("/api/subscribers/{$subscriber->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('subscribers', ['id' => $subscriber->id]);
        $this->assertDatabaseMissing('field_subscriber', [
            'subscriber_id' => $subscriber->id,
        ]);
    }
}
