<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    /**
     * Get the edition that the log belongs to.
     */
    public function edition()
    {
        return $this->belongsTo('App\Edition');
    }

    /**
     * Log an action taken by an IP
     *
     * @return boolean
     */
    public static function logAction($action, $editionId = null)
    {
        $editionId = ($editionId) ? $editionId : Edition::current()->id;
        $limit = new Self;

        $limit->edition_id = $editionId;
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
    public static function exceeded($action, $limit, $editionId = null)
    {
        $editionId = ($editionId) ? $editionId : Edition::current()->id;
        $count = Self::where('ip', '=', Self::ip())->where('action', '=', $action)->where('edition_id', $editionId)->count();

        return $count >= $limit;
    }

    /**
     * Lists IPs over the limit ordered by the date they exceeded it
     *
     * @return boolean
     */
    public function createReport()
    {
        
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
