<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function log_action($action)
    {
        $this->ip = 'IP';
        $this->action = $action;
        $this->user_agent = 'UA';

        return $this->save();
    }

    public function limit_exceeded($action, $limit)
    {
        $count = Self::where('ip', '=', $thisIP)->where('action', '=', $action)->count();

        return $count > $limit;
    }
}
