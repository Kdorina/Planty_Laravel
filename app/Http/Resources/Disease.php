<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Disease extends JsonResource
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
            "name"=>$this->name,
            "imgpath"=>$this->imgpath,
            "type_id"=>$this->type_id,
            "description"=>$this->description,
            "solution"=>$this->solution
        ];
    }
}
