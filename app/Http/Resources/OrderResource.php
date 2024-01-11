<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'name' => $this->first_name. ' '.$this->last_name,
            'email' => $this->email,
            //'total' => $this->admin_revenue,
            'order_items' => OrderItemResouce::collection($this->whenLoaded('orderItems'))
        ];
    }
}