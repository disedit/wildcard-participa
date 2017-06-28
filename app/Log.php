<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function log_action($request, $action)
    {
        $this->ip = $request->ip();
        $this->action = $action;
        $this->user_agent = $request->header('User-Agent');

        return $this->save();
    }

    public function limit_exceeded($request, $action, $limit)
    {
        $count = Self::where('ip', '=', $request->ip())->where('action', '=', $action)->count();

        return $count > $limit;
    }
}
