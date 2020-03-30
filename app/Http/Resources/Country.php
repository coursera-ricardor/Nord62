<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Country extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * Returns additional information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
     public function with($request) {
         // @todo: RRE - Construct columns from the Table info
         $answer = [
            'version' => '1.0',
            'columns' => array([ 'data' => 'id', 'name' => 'id'],[ 'data' => 'name', 'name' => 'name']),
        ];

         return $answer;
     }

}
