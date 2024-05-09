<?php

namespace App\Http\Resources\Application;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return  [
            // 'id' =>$this->id,
            'name'=>$this->name,
            'email'=>$this->email,
            'created_at' => $this->created_at->format('D:d/M/Y'),
            // 'updated_at' => $this->updated_at->format('D/M/Y'),
        ];
    }
}
