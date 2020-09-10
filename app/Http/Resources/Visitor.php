<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Visitor extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'temp' => $this->temp,
            'gender' => $this->gender,
            'age' => $this->age,
            'address' => $this->address,
            'purpose' => $this->purpose,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'answers' => Answer::collection($this->whenLoaded('answers')),
        ];
    }
}
