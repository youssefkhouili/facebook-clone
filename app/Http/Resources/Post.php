<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'  => [
                'type'      => 'posts',
                'post_id'   => $this->id,
                'attributes' => [
                    'posted_by' => new User($this->user),
                    'body'  => $this->body,
                    'published_at'    => $this->formatted_published_date
                ]
            ],
            'links' => [
                'self'  => url('/posts/' . $this->id)
            ]
        ];
    }
}
