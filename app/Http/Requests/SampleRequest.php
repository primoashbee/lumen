<?php

namespace App\Http\Requests;

use App\Rules\OfficeID;
use App\Rules\TransactionType;
use App\Rules\PaymentMethodList;
use App\Rules\PreventFutureDate;
use Illuminate\Foundation\Http\FormRequest;

class SampleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'office_id' =>['required', new OfficeID()],
                'repayment_date'=>['required','date', new PreventFutureDate()],
                'payment_method'=>['required', new PaymentMethodList()],
                'type'=>['required', new TransactionType()],
                
                'accounts.*.deposit_id'=> ['required','exists:deposit_accounts,id'],
                'accounts.*.amount'=> ['required','exists:deposit_accounts,id'],
        ];
    }

    public function messages(){
        
    }
}
