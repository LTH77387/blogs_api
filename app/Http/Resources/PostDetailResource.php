<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'title'=>$this->title,
            'description'=>$this->description,
            'category_name'=>optional($this->category)->category_name ?? 'Unknown Category',
            'user_name'=>optional($this->user)->name ?? 'Unknown User',
            'created_at'=>Carbon::parse($this->created_at)->format('m-d-Y'),
            'created_at_readable'=> Carbon::parse($this->created_at)->diffForHumans(),
            'image_path'=>optional($this->image)->file_name ? asset('storage/media/' . $this->image->file_name) : null,
        ];
    }
}
