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

        $countryCode = (isset($attributes['countryCode'])) ? $attributes['countryCode'] : null;

        if(isset($attributes['SID'])) $attributes['SID'] = $this->cleanSID($attributes['SID']);
        if(isset($attributes['phone'])) $attributes['phone'] = $this->cleanPhone($countryCode, $attributes['phone']);

        $this->replace($attributes);

        return $attributes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $isRequestSMS = $this->is('api/request_sms');
        $isCastBallot = $this->is('api/cast_ballot');

        //If in booth mode ignore some rules;
        $payload = JWTAuth::getPayload(JWTAuth::getToken())->toArray();

        $boothMode = (isset($payload['booth_mode'])) ? $payload['booth_mode'] : false;

        $ipLimit = (!$boothMode) ? '|ip_limit' : '';
        $phoneRequired = (!$boothMode) ? 'required|check_phone_format|check_phone_duplicity' : '';
        $countryRequired = (!$boothMode) ? 'required|numeric' : '';
        $smsRequired = (!$boothMode) ? 'required|check_sms_code' : '';

        // Rules
        $rules = [
            'SID' => 'required|on_census|has_not_voted' . $ipLimit,
            'ballot' => 'ballot_validity',
        ];

        // if SMS code is required!!
        if($isRequestSMS || $isCastBallot) {
            $rules['phone'] = $phoneRequired;
            $rules['country_code'] = $countryRequired;
        }

        if($isCastBallot) $rules['SMS_code'] = $smsRequired;

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request. !!!!!
     *
     * @return array
     */
    public function cleanPhone($countryCode, $phone)
    {
        $countryCode = filter_var($countryCode, FILTER_SANITIZE_STRING);
        $phone = filter_var($phone, FILTER_SANITIZE_STRING);

        $countryCode = ($countryCode) ? $countryCode : '34';
        $phone = $countryCode . '.' . $phone;

        // Improve this with regex?
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);

        return $phone;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function cleanSID($value)
    {
        $value = filter_var($value, FILTER_SANITIZE_STRING);

        // Improve this with regex?
        $value = str_replace(" ","",$value);
        $value = str_replace("-","",$value);
        $value = str_replace(".","",$value);

        $value = strtoupper($value);

        return $value;
    }

}
