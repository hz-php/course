<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'street' => 'required',
            'district' => 'required',
            'city' => 'required',
            'floor' => 'required',
            'how_many_rooms' => 'required',
            'total_area' => 'required',
            'ceiling_height' => 'required',
            'how_many_flors' => 'required',
            'how_many_flors_house' => 'required',
            'year_of_construction' => 'required',
            'type' => 'required',
            'type_ob_transaction' => 'required',
            'type_of_house' => 'required',
            'condition' => 'required',
            'description' => 'required',
            'seller_id' => 'required',
        ];
    }
}
