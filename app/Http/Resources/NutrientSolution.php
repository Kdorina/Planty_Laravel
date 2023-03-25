<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NutrientSolution extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "id"=>$this->id,
            "addNutrient"=>$this->addNutrient,
            "user_id"=>$this->user_id
        ];
    }
}
