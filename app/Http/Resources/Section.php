<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Section extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'NameA' => $this->name_section,
            'NameE' => $this->slug,
            'section_image' => $getfile = "data:" . $this->photo_type . ";base64," . base64_encode($this->section_image),
            'created_at' => $this->created_at->format('D/M/Y'),
            'updated_at' => $this->updated_at->format('D/M/Y'),
        ];
    }
}
