<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReminderCollection extends ResourceCollection
{
    private $limit;
    private $reminders;

    public function __construct($reminders, $limit) {
        parent::__construct($reminders);

        $this->reminders = $reminders;
        $this->limit = $limit;
    }
    
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reminders' => ReminderResource::collection($this->reminders),
            'limit' => $this->limit
        ];
    }
}
