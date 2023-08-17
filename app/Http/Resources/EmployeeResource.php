<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name' => $this->name,
            'position' => $this->position,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'salary' => $this->salary,
            'photo' => $this->photo,
            'created_at' => $this->created_at,
        ];
    }
}
