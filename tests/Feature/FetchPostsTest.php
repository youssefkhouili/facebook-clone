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
        $posts = factory(Post::class, 4)->create();

        $response = $this->get('/api/posts');
        $response->assertStatus(200);

        $response->assertJson([
            'data'  => [
                [
                    'data'  => [
                        'type'          => 'posts',
                        'post_id'       => $posts->first()->id,
                        'attributes'    => [
                            'body'  => $posts->first()->body
                        ]
                    ],
                ],
                [
                    'data'  => [
                        'type'          => 'posts',
                        'post_id'       => $posts->find(2)->id,
                        'attributes'    => [
                            'body'  => $posts->find(2)->body
                        ]
                    ],
                ],
                [
                    'data'  => [
                        'type'          => 'posts',
                        'post_id'       => $posts->find(3)->id,
                        'attributes'    => [
                            'body'  => $posts->find(3)->body
                        ]
                    ],
                ],
                [
                    'data'  => [
                        'type'          => 'posts',
                        'post_id'       => $posts->find(4)->id,
                        'attributes'    => [
                            'body'  => $posts->find(4)->body
                        ]
                    ],
                ],
            ],
            'links' => [
                'self'  => url('/api/posts')
            ]
        ]);
    }
}
