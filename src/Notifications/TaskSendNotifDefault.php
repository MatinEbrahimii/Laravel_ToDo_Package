<?php

namespace MatinEbrahimii\ToDo\Notifications;

use Illuminate\Support\Facades\Notification;


class TaskSendNotifDefault
{
    public function send($user, $task)
    {
        Notification::send($user, new TaskChangeStatusNotifLaravel($task));
    }
}
