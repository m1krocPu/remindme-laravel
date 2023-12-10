<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Services\ReminderService;
use App\Http\Requests\ReminderListRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReminderController extends Controller
{
    public function index(ReminderListRequest $request)
    {
        $reminders = ReminderService::getReminderList($request->limit);

        return Response::success($reminders);
    }
}
