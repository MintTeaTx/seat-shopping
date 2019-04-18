<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/5/2019
 * Time: 10:22 PM
 */

namespace Fordav3\Seat\Shopping\Validation;


use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return ['details' =>'required|string'];
    }


}