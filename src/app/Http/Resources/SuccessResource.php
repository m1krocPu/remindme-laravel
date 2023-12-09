<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ok' => true,
            $this->mergeWhen(!empty($this->resource), function() {
                return [
                    'data' => $this->resource
                ];
            })
        ];
    }
}
