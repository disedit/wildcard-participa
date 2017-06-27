<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Edition;

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
        if(isset($attributes['SMS_code'])) $attributes['SMS_code'] = trim($attributes['SMS_code']);

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
        $booth_mode = false;

        $rules = [
            'SID' => 'required|on_census|has_not_voted|ip_limit',
            'ballot' => 'ballot_validity',
        ];

        // if SMS code is required!!
        if($is_requestSMS || $is_castBallot) $rules['phone'] = 'required|check_phone_format|check_phone_duplicity';
        if($is_castBallot) $rules['SMS_code'] = 'required|check_sms_code';

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
        } elseif(substr($value,0,2) == '34'){
            $value = substr($value,2);
        } else {
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
