<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Plant extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id"=>$this->id,
            "name"=>$this->name,
            "imgpath"=>$this->imgpath,
            "description"=>$this->description,
            "watering"=>$this->watering,
            "temperature"=>$this->temperature,
            "light_requirement"=>$this->light_requirement,
            "humidity"=>$this->humidity,
            "heat_demand"=>$this->heat_demand,
            
        ];
    }
}
