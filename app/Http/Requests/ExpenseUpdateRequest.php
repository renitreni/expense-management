<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Silber\Bouncer\Bouncer;

class ExpenseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Bouncer $bouncer)
    {
        return $bouncer->can('expense-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'expense_category_id'   => 'required',
            'amount'                => 'required|numeric',
            'entry_date'            => 'required|date',
        ];
    }
}
