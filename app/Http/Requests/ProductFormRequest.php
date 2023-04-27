<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductFormRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [];
        $id  = $this->get('id');


        $rules = [
            'item_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'image' => 'required',
        ];

        if ($request->method() == 'PUT') {
            $rules['image'] = 'sometimes';
        }

        return $rules;
    }
}
