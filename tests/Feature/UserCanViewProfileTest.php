<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCanViewProfileTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    /** @test */
    public function a_user_can_view_his_profile()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->get('api/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data'  => [
                'type'  => 'users',
                'user_id'   => $user->id,
                'attributes' => [
                    'name'  => $user->name
                ]
            ],
            'links' => [
                'self'  => url('/users/' . $user->id)
            ]
        ]);
    }

    /** @test */
    public function a_user_can_fetch_posts_for_a_profile()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create([
            'user_id'   => $user->id
        ]);

        $response = $this->get('/api/users/' . $user->id . '/posts');

        $response->assertStatus(200);
        $response->assertJson([
            'data'  => [
                [
                    'data'  => [
                        'type'      => 'posts',
                        'post_id'   => $post->id,
                        'attributes' => [
                            'body'  => $post->body,
                            'post_img'  => $post->post_img,
                            'published_at'    => $post->formatted_published_date,
                            'posted_by' => [
                                'data'  => [
                                    'attributes' => [
                                        'name'  => $user->name
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'links' => [
                        'self'  => url('/posts/' . $post->id)
                    ]
                ]
            ]
        ]);
    }
}
