<?php

namespace MatinEbrahimii\ToDo\Notifications;

class FakeNotificationSender
{
    public function send($user, $task)
    {
        return 'test';
    }
}
