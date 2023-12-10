<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Services\ReminderService;
use App\Http\Requests\ReminderListRequest;
use App\Http\Requests\ReminderCreateRequest;
use App\Http\Requests\ReminderUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReminderController extends Controller
{
    public function index(ReminderListRequest $request)
    {
        $reminders = ReminderService::getReminderList($request->limit);

        return Response::success($reminders);
    }

    public function store(ReminderCreateRequest $request)
    {
        $reminder = ReminderService::createReminder($request->all());

        return Response::success($reminder);
    }

    public function detail($id)
    {
        $reminder = ReminderService::detailReminder($id);

        return Response::success($reminder);
    }

    public function update(ReminderUpdateRequest $request)
    {
        $payload = $request->only('title', 'description', 'remind_at', 'event_at');
        $reminder = ReminderService::updateReminder($payload, $request->id);

        return Response::success($reminder);
    }
}
