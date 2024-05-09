<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Activity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'NameA' => $this->NameA,
            'NameE' => $this->NameE,
            'section_id' => $this->section_id,
            'level_activity' => $this->level_activity,
            'activity_image' => $getfile = "data:" . $this->photo_type . ";base64," . base64_encode($this->activity_image),
            'created_at' => $this->created_at->format('D/M/Y'),
            'updated_at' => $this->updated_at->format('D/M/Y'),
        ];
    }
}
