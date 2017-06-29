<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Edition;
use Tymon\JWTAuth\Facades\JWTAuth;

class VoteRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $edition = new Edition;
        $now = time();
        return (strtotime($edition->current()->end_date) > $now);
    }

    /**
     * Modify input data before validation
     *
     * @return array
     */
    public function all() {
        $attributes = parent::all();

        if(isset($attributes['SID'])) $attributes['SID'] = $this->cleanSID($attributes['SID']);
        if(isset($attributes['phone'])) $attributes['phone'] = $this->cleanPhone($attributes['phone']);

        return $attributes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $is_requestSMS = $this->is('api/request_sms');
        $is_castBallot = $this->is('api/cast_ballot');

        //If in booth mode ignore some rules;
        $payload = JWTAuth::getPayload(JWTAuth::getToken())->toArray();

        $booth_mode = (isset($payload['booth_mode'])) ? $payload['booth_mode'] : false;

        $ip_limit = (!$booth_mode) ? '|ip_limit' : '';
        $phone_required = (!$booth_mode) ? 'required|check_phone_format|check_phone_duplicity' : '';
        $sms_required = (!$booth_mode) ? 'required|check_sms_code' : '';

        // Rules
        $rules = [
            'SID' => 'required|on_census|has_not_voted' . $ip_limit,
            'ballot' => 'ballot_validity',
        ];

        // if SMS code is required!!
        if($is_requestSMS || $is_castBallot) $rules['phone'] = $phone_required;
        if($is_castBallot) $rules['SMS_code'] = $sms_required;

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request. !!!!!
     *
     * @return array
     */
    public function cleanPhone($value){

        $value = filter_var($value, FILTER_SANITIZE_STRING);
        $value = str_replace(" ","",$value);
        $value = str_replace(".","",$value);
        $value = str_replace("-","",$value);
        $value = str_replace("+","00",$value);

        if(substr($value,0,2) == '00'){
           $value = substr($value,2);
        } elseif(substr($value,0,2) != '34'){
           $value = "34" . $value;
        }

        return $value;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function cleanSID($value){

        $value = filter_var($value, FILTER_SANITIZE_STRING);
        $value = str_replace(" ","",$value);
        $value = str_replace("-","",$value);
        $value = str_replace(".","",$value);
        $value = strtoupper($value);

        return $value;

    }

}
