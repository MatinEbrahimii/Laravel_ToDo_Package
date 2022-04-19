<?php

namespace MatinEbrahimii\ToDo\Http\Responses;

class HtmlResponses
{
    public function success()
    {
        return View('success');
    }

    public function send($key, $value)
    {
        return View('success', [$key, $value]);
    }

    public function notFound()
    {
        return View('notFound');
    }
}
