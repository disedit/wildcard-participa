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

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Validator::extend('on_census', function($attribute, $value, $params) {
            return Voter::findBySID($value, $params[0]);
        });

        Validator::extend('has_not_voted', function($attribute, $value, $params) {
            $voter = Voter::findBySID($value, $params[0]);
            if(!$voter) return true;
            return ($voter->ballot_cast === 0);
        });

        Validator::extend('phone_not_used', function($attribute, $value, $params) {
            $used = Voter::where('SMS_phone', $value)
                         ->where('SMS_verified', 1)
                         ->where('edition_id', $params[0])->count();

            return !$used;
        });

        Validator::extend('ballot_validity', function($attribute, $questions, $params) {
            foreach($questions as $questionKey => $question) {
                $checkQuestion = Question::where('id', $question['id'])->where('edition_id', $params[0])->first();
                if(!$checkQuestion) return false;

                if(count($question['options']) > $checkQuestion->max_options
                || count($question['options']) < $checkQuestion->min_options) return false;

                foreach($question['options'] as $optionKey => $option) {
                    $checkOption = Option::where('id', '=', $option['id'])->where('question_id', '=', $question['id'])->first();
                    if(!$checkOption) return false;
                }
            }

            return true;
        });

        Validator::extend('sms_code', function($attribute, $value, $params) {
            $voter = Voter::findBySID($params[0], $params[1]);
            $voterToken = $voter->SMS_token;
            $providedToken = $value;
            return ($voterToken == $providedToken);
        });
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
