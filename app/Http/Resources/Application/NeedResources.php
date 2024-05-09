<?php

namespace App\Http\Resources\Application;

use Illuminate\Http\Resources\Json\JsonResource;

class NeedResources extends JsonResource
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
            'id' =>$this->id,
            'type'=>$this->type,
            // 'name'=>$this->name,
            'image' => $getfile = "data:" . $this->photo_type . ";base64," . base64_encode($this->image),
            // 'voice' => $getfile = "data:" . $this->voice_type . ";base64," . base64_encode($this->voice),

        ];
    }
}
