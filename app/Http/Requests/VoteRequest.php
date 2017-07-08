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
        return true;
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
        $edition_id = $this->get('edition_id');
        $SID = $this->get('SID');
        $isRequestSMS = $this->is('api/request_sms');
        $isCastBallot = $this->is('api/cast_ballot');

        // General rules
        $rules['SID'] = [
            'required',
            'on_census:' . $edition_id,
            'has_not_voted:' . $edition_id
        ];

        $rules['ballot'] = 'ballot_validity:' . $edition_id;

        // Conditional rules. if Booth Mode is set, ignore these extra checks
        $inPerson = $this->has('in_person');
        $phoneRequired = (!$inPerson) ? 'required|numeric|phone_not_used:' . $edition_id : '';
        $countryRequired = (!$inPerson) ? 'required|numeric' : '';

        $smsRequiredRules = [
            'required',
            'sms_code:' . $SID . ',' . $edition_id
        ];
        $smsRequired = (!$inPerson) ? $smsRequiredRules : '';

        // SMS verification rules
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
