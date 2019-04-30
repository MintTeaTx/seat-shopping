<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/29/2019
 * Time: 8:41 PM
 */

namespace Fordav3\Seat\Shopping\Validation;


use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return ['key' =>'required|string', 'value' => 'required|string'];
    }
}