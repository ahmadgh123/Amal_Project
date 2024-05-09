<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class N_Course extends JsonResource
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
            'name_image' => $this->name_image,
            'activity_id' => $this->activity_id,
            'n_image' => $getfile = "data:" . $this->photo_type . ";base64," . base64_encode($this->n_image),
            'voice' => $getfile = "data:" . $this->voice_type . ";base64," . base64_encode($this->voice),
            'created_at' => $this->created_at->format('D/M/Y'),
            'updated_at' => $this->updated_at->format('D/M/Y'),
        ];
    }
}
