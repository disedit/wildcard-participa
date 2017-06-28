<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LimitsLog extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'limits_log';

    /**
     * Log action
     *
     * @return boolean
     */
    public function log_action($action)
    {
        $this->ip = $this->app->request->ip();
        $this->action = $action;
        $this->user_agent = $this->app->request->header('User-Agent');

        return $this->save();
    }

    /**
     * Check if an IP has exceeded an action's limit
     *
     * @return boolean
     */
    public function limit_exceeded($action, $limit)
    {
        $count = Self::where('ip', '=', $this->app->request->ip())->where('action', '=', $action)->count();

        return $count > $limit;
    }
}
