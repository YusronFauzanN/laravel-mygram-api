<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use function GuzzleHttp\Promise\each;
use function PHPSTORM_META\map;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'poster_image_url' => $this->poster_image_url,
            'title' => $this->title,
            'caption' => $this->caption,
            'user' => $this->whenLoaded('user'),
            'comment' => $this->whenLoaded('comments', function(){
                return collect($this->comments)->each(function($comment){
                    return $comment->user;
                });
            })
        ];
    }
}
