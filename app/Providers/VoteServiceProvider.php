<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use App\Requests\VoteRequest;
use App\Voter;
use App\Edition;
use App\Ballot;
use App\Question;
use App\Option;

class VoteServiceProvider extends ServiceProvider
{

    private $edition_id;
    private $voter;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $edition = new Edition;
        $this->edition_id = $edition->current()->id;

        Validator::extend('on_census', function($attribute, $value) {
            $this->voter = $this->setVoter($value);
            return ($this->voter) ? TRUE : FALSE;
        });

        Validator::extend('has_not_voted', function() {
            if(!$this->voter) return TRUE;
            return ($this->voter->ballot_cast == 0) ? TRUE : FALSE;
        });

        Validator::extend('ip_limit', function() {
            $max = config('participa.max_per_ip');
            $IPs = Voter::where('ip_address', '=', $this->app->request->ip())->count();
            return ($IPs < $max) ? TRUE : FALSE;
        });

        Validator::extend('check_phone_format', function($attribute, $value) {
            //Maybe add more rules here?
            if(!is_numeric($value)) return FALSE;
            return TRUE;
        });

        Validator::extend('check_phone_duplicity', function($attribute, $value) {
            $phone_registered = Voter::where('SMS_phone', '=', $value)->where('SMS_verified', '=', 1)->where('edition_id', '=', $this->edition_id)->count();
            return ($phone_registered == 0) ? TRUE : FALSE;
        });

        Validator::extend('ballot_validity', function($attribute, $questions) {
            foreach($questions as $question_key => $question){
                $check_question = Question::where('id', '=', $question['id'])->first();
                if(!$check_question) return FALSE;

                if(count($question['options']) > $check_question->max_options) return FALSE;

                foreach($question['options'] as $option_key => $option){
                    $check_option = Option::where('id', '=', $option['id'])->where('question_id', '=', $question['id'])->first();
                    if(!$check_option) return FALSE;
                }
            }
            return TRUE;
        });

        Validator::extend('check_sms_code', function($attribute, $value) {
            $voter_token = $this->voter->SMS_token;
            // $provided_token = hash('sha512', $value . $this->voter->SID);
            $provided_token = $value;
            return ($voter_token == $provided_token);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    private function setVoter($SID)
    {
        return $this->voter = Voter::find_by_SID($SID, $this->edition_id);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
