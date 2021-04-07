<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Silber\Bouncer\Bouncer;

class ExpenseCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Bouncer $bouncer)
    {
        return $bouncer->can('expense-cat-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'description' => 'required',
        ];
    }
}
