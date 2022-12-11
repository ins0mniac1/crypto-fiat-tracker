<?php

namespace App\Http\Resources\API\Guest;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeIndexResource extends JsonResource
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
            'driver' => $this->getDriverAliases($this->driver),
            'pair' => $this->pair,
            'last_price' => $this->last_price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

    private function getDriverAliases($driver): bool|string
    {
        $driverAsArray = explode('\\', $driver);
        return end($driverAsArray);
    }
}
