<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchPostsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_user_can_fetch_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $posts = factory(Post::class, 2)->create([
            'user_id'   => $user->id
        ]);

        $response = $this->get('/api/posts');
        $response->assertStatus(200);

        $response->assertJson([
            'data'  => [
                [
                    'data'  => [
                        'type'          => 'posts',
                        'post_id'       => $posts->last()->id,
                        'attributes'    => [
                            'body'  => $posts->last()->body,
                            'post_img'   => $posts->last()->post_img,
                            'published_at'  => $posts->last()->formatted_published_date
                        ]
                    ],
                ],
                [
                    'data'  => [
                        'type'          => 'posts',
                        'post_id'       => $posts->first()->id,
                        'attributes'    => [
                            'body'  => $posts->first()->body,
                            'post_img'   => $posts->first()->post_img,
                            'published_at'  => $posts->first()->formatted_published_date
                        ]
                    ],
                ],
            ],
            'links' => [
                'self'  => url('/api/posts')
            ]
        ]);
    }
    /** @test */
    public function a_user_can_fetch_only_his_posts()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $post = factory(Post::class)->create();

        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertExactJson([
                'data'  => [],
                'links' => [
                    'self'  => url('api/posts')
                ]
            ]);
    }
}
