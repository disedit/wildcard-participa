<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{

    /**
     * Log action
     *
     * @return boolean
     */
    public static function logAction($request, $action)
    {
        $this->ip = $request->ip();
        $this->action = $action;
        $this->user_agent = $request->header('User-Agent');

        return $this->save();
    }

    /**
     * Check if an IP has exceeded an action's limit
     *
     * @return boolean
     */
    public static function exceeded($request, $action, $limit)
    {
        $count = Self::where('ip', '=', $request->ip())->where('action', '=', $action)->count();

        return $count > $limit;
    }
}
