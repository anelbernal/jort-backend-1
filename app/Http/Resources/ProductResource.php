<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => $this->id,
            'seller_id' => $this->seller_id,
            'title' => $this->title,
            'short_desc' => $this->short_desc,
            'long_desc' => $this->long_desc,
            'category' => $this->category,
            'pre_timer' => $this->pre_timer,
            'current_timer' => $this->current_timer,
            'current_bid' => $this->current_bid,
            'increment' => $this->increment,
            'new_bid' => $this->new_bid,
            'bid_level' => $this->bid_level,
            'stripeid' => $this->stripeid,
            'sold_timer' => $this->sold_timer,
            'del_timer' => $this->del_timer,
            'bids' => BidResource::collection($this->bids),
            'medias' => MediaResource::collection($this->medias),
            // 'winners' => WinnerResource::collection($this->winners),
            // 'payment_intents' => PaymentIntentResource::collection($this->payment_intents)
        ];
    }
}
