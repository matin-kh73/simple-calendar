<?php

namespace Tests\Feature\Controllers\API;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function test_index_when_user_is_login_and_admin()
    {
        $user = factory(User::class)->create();

        $user->events()->createMany(factory(Event::class, 5)->make()->toArray());

        $res = $this->actingAs($user, 'api')->json('GET', route('events.index'));
        $res->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'user' => [
                        'id',
                        'email',
                        'name',
                        'isAdmin'
                    ],
                    'title',
                    'description',
                    'start_at',
                    'end_at',
                    'status'
                ]
            ],
            'message',
            'status_code'
        ]);
        $res->assertStatus(200);
    }

    public function test_index_when_user_is_login_and_is_not_admin()
    {
        $user = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $user->events()->createMany(factory(Event::class, 5)->make()->toArray());

        $res = $this->actingAs($user, 'api')->json('GET', route('events.index'));

        $res->assertUnauthorized();
        $res->assertStatus(401);
    }

    public function test_index_user_events()
    {
        $userB = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $userA = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $userA->events()->createMany(factory(Event::class, 5)->make()->toArray());

        $userB->events()->createMany(factory(Event::class, 5)->make()->toArray());


        $res = $this->actingAs($userA, 'api')->json('GET', route('user.events.index'));
        $this->assertEquals($userA->events()->count(), 5);
        $res->assertJsonStructure([
            'data' => [
                'events' => [
                    [
                        'id',
                        'title',
                        'description',
                        'start_at',
                        'end_at',
                        'status'
                    ]
                ],
                'user' => [
                    'id',
                    'email',
                    'name',
                    'isAdmin'
                ],
            ],
            'message',
            'status_code'
        ]);
        $res->assertStatus(200);
    }

    public function test_show_an_event_to_a_valid_user()
    {
        $user = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $user->events()->createMany(factory(Event::class, 5)->make()->toArray());
        $sampleEvent = $user->events()->first();
        $res = $this->actingAs($user, 'api')->json('GET', route('events.show', ['event' => $sampleEvent->id]));

        $res->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'start_at',
                'end_at',
                'status'
            ],
            'message',
            'status_code'
        ]);
        $res->assertStatus(200);
    }

    public function test_store_an_event()
    {
        $user = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $event = [
            'title' => $this->faker->title,
            'description' => $this->faker->title,
            'start_at' => now()->addHour(3)->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay(1)->format('Y-m-d H:i:s')
        ];

        $res = $this->actingAs($user, 'api')->json('POST', route('events.store'), $event);

        $res->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'start_at',
                'end_at',
                'status',
                'created_at'
            ],
            'message',
            'status_code'
        ]);
        $this->assertDatabaseHas('events', [
            'title' => $event['title']
        ]);
        $res->assertStatus(201);
    }

    public function test_update_an_event_by_valid_user()
    {
        $user = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $event = factory(Event::class)->create([
            'user_id' => $user->id
        ]);

        $newEvent = [
            'title' => $this->faker->title,
            'description' => $this->faker->title,
            'start_at' => now()->addHour(3)->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay(1)->format('Y-m-d H:i:s')
        ];

        $res = $this->actingAs($user, 'api')->json('PUT', route('events.update', ['event' => $event->id]), $newEvent);

        $res->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'start_at',
                'end_at',
                'status',
                'created_at'
            ],
            'message',
            'status_code'
        ]);
        $this->assertDatabaseHas('events', [
            'title' => $newEvent['title']
        ]);
        $res->assertStatus(200);
    }

    public function test_destroy_an_event_by_valid_user()
    {
        $user = factory(User::class)->create([
            'isAdmin' => false
        ]);

        $event = factory(Event::class)->create([
            'user_id' => $user->id
        ]);

        $res = $this->actingAs($user, 'api')->json('DELETE', route('events.destroy', ['event' => $event->id]));

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'deleted_at' => now()
        ]);
        $res->assertJsonStructure([
            'message',
            'status_code'
        ]);
        $res->assertStatus(200);
    }
}
