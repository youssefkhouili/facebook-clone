<?php

namespace Tests\Feature;

use App\User;
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
}
