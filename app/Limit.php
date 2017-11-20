<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{

    /**
     * Log an action taken by an IP
     *
     * @return boolean
     */
    public static function logAction($action)
    {
        $limit = new Self;

        $limit->ip = Self::ip();
        $limit->action = $action;
        $limit->user_agent = Self::userAgent();

        return $limit->save();
    }

    /**
     * Check if an IP has exceeded an action's limit
     *
     * @return boolean
     */
    public static function exceeded($action, $limit)
    {
        $count = Self::where('ip', '=', Self::ip())->where('action', '=', $action)->count();

        return $count >= $limit;
    }

    /**
     * Returns the user IP, accounting for Cloudflare
     *
     * @return string
     */
    public static function ip()
    {
        return (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : \Request::ip();
    }

    /**
     * Returns the User Agent
     *
     * @return string
     */
    public static function userAgent() {
        return \Request::header('User-Agent');
    }
}
