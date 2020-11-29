<?php

namespace Tests\Feature;

use App\Friend;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FriendsTest extends TestCase
{
    use RefreshDatabase;
    /** @test*/
    public function a_user_can_send_friend_request()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $friendUser = factory(User::class)->create();

        $response = $this->post('/api/friend-request', [
            'friend_id' => $friendUser->id
        ])->assertStatus(200);

        $friendRequest = \App\Friend::first();

        $this->assertNotNull($friendRequest);

        $this->assertEquals($friendUser->id, $friendRequest->friend_id);
        $this->assertEquals($user->id, $friendRequest->user_id);

        $response->assertJson([
            'data' => [
                'type'  => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes'    => [
                    'confirmed_at'  => null
                ],
            ],
            'links' => [
                'self'  => url('/users/' . $friendUser->id)
            ]
        ]);
    }

    /** @test */
    public function only_valid_users_can_be_friend_requested()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/friend-request', [
            'friend_id' => 100 // Id doesn't exists
        ])->assertStatus(404);

        $friendRequest = \App\Friend::first();

        $this->assertNull($friendRequest);
        $response->assertJson([
            'errors'    => [
                'code'  => '404',
                'title' => 'user Not Found',
                'detail' => 'Unable to locate the user with the given informations'
            ]
        ]);
    }
    /** @test */
    public function friend_request_can_be_accepted()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $friendUser = factory(User::class)->create();

        $this->post('/api/friend-request', [
            'friend_id' => $friendUser->id
        ])->assertStatus(200);

        $response = $this->actingAs($friendUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id'   => $user->id,
                'status'    => 1
            ])->assertStatus(200);

        $friendRequest = \App\Friend::first();
        $this->assertNotNull($friendRequest->confirmed_at);
        $this->assertEquals(now(), $friendRequest->confirmed_at);
        $this->assertEquals(1, $friendRequest->status);

        $response->assertJson([
            'data' => [
                'type'  => 'friend-request',
                'friend_request_id' => $friendRequest->id,
                'attributes'    => [
                    'confirmed_at'  => $friendRequest->formatted_date
                ],
            ],
            'links' => [
                'self'  => url('/users/' . $friendUser->id)
            ]
        ]);
    }
    /** @test */
    public function only_valid_friend_requests_can_be_accepted()
    {
        $friendUser = factory(User::class)->create();

        $response = $this->actingAs($friendUser, 'api')
            ->post('/api/friend-request-response', [
                'user_id'   => 123,
                'status'    => 1
            ])
            ->assertStatus(404);

        $this->assertNull(Friend::first());

        $response->assertJson([
            'errors'    => [
                'code'  => '404',
                'title' => 'Friend Request Not Found',
                'detail' => 'Unable to locate the Friend Request with the given informations'
            ]
        ]);
    }
}
