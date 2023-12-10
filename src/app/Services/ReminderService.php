<?php

namespace App\Services;

use Auth;
use Str;
use Carbon\Carbon;
use App\Http\Resources\ReminderCollection;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;

class ReminderService
{
    public static function getReminderList($limit = 10)
    {
        $user = Auth::user();
        $reminders = Reminder::where('user_id', $user->id)
            ->limit($limit)
            ->orderBy('remind_at', 'asc')
            ->get();
        
        return new ReminderCollection($reminders, $limit);
    }

    public static function createReminder($payload)
    {
        $reminder = Reminder::create($payload);
        
        return new ReminderResource($reminder);
    }

}