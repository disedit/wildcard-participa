<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
<<<<<<< HEAD
    public function log_action($request, $action)
    {
        $this->ip = $request->ip();
        $this->action = $action;
        $this->user_agent = $request->header('User-Agent');
=======
    public function log_action($action)
    {
        $this->ip = 'IP';
        $this->action = $action;
        $this->user_agent = 'UA';
>>>>>>> 707b55fd947afb3ce0b6663f4605e83e9246e8b4

        return $this->save();
    }

<<<<<<< HEAD
    public function limit_exceeded($request, $action, $limit)
    {
        $count = Self::where('ip', '=', $request->ip())->where('action', '=', $action)->count();
=======
    public function limit_exceeded($action, $limit)
    {
        $count = Self::where('ip', '=', $thisIP)->where('action', '=', $action)->count();
>>>>>>> 707b55fd947afb3ce0b6663f4605e83e9246e8b4

        return $count > $limit;
    }
}
