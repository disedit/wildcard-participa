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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $this->sanitize();

        //If in booth mode ignore some rules;
        $booth_mode = false;

        $rules = [
            'SID' => 'required|on_census|has_not_voted|ip_limit',
            'options' => 'ballot_validity',
        ];

        // if SMS code is required!!
        if($this->is('/api/request_sms')) $rules['phone'] = 'required|required|check_phone_format|check_phone_duplicity';
        if($this->is('/api/cast_ballot')) $rules['SMS_code'] = 'required|check_SMS_code';

        return $rules;
    }


    public function sanitize()
    {
        $input = $this->all();

        $input['SID'] = $this->cleanSID($input['SID']);
        if($this->is('/api/request_sms')) $input['phone'] = $this->cleanPhone($input['phone']);

        $this->replace($input);
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
