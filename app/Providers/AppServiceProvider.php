<?php

namespace App\Providers;

use Carbon\Carbon;
use App\LoanAccount;
use App\Observers\LoanAccountObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $error = ':custom_message.';        
        Validator::extendDependent('cbu_deposit', function ($attribute, $value, $parameters, $validator){
            // The $parameters passed from the validator below is ['*.provider'], when we imply that this
            // custom rule is dependent the validator tends to replace the asterisks with the current
            // indices as per the original attribute we're validating, so *.provider will be replaced
            // with 0.provider, now we can use array_get() to get the value of the other field.
            
                // So this custom rule validates that the attribute value contains the value of the other given
                // attribute.
            //  echo $error;
            $arr = explode('.', $attribute);
            
            $account = $validator->getData()[$arr[0]][$arr[1]];
            
            
            $type = $account['type'];
            $account_id = $account['id'];

            $customMessage = 
                "Mininum deposit for " .$type['product_id']. ' is '. env('CURRENCY_SIGN').' '.($type['minimum_deposit_per_transaction']);

            
            

            $validator->addReplacer('cbu_deposit', 
                function($message, $attribute, $rule, $parameters) use ($customMessage) {
                    return \str_replace(':custom_message', $customMessage, $message);
                }
            );
            // var_dump($attribute);
            // $account_id = $account['id'];
            // $attribute =$account_id;
            // $attributes = array('account.{$key}.amount'=>$attribute);

            // $validator->setAttributes($attributes);
            // $validator->addReplacer('cbu_deposit', 
            //     function($message, $attribute, $rule, $parameters) use ($account_id) {
            //         return \str_replace(':attribute', $account_id, $attribute);
            //     }
            // );

            if($value < $type['minimum_deposit_per_transaction']){
                return false;
            }
                return true;
            //  return str_contains($value, 
            //          array_get($validator->getData(), $parameters[0])
            //  );
            },$error);
        Validator::extendDependent('cbu_withdraw', function ($attribute, $value, $parameters, $validator){
            // The $parameters passed from the validator below is ['*.provider'], when we imply that this
            // custom rule is dependent the validator tends to replace the asterisks with the current
            // indices as per the original attribute we're validating, so *.provider will be replaced
            // with 0.provider, now we can use array_get() to get the value of the other field.
            
                // So this custom rule validates that the attribute value contains the value of the other given
                // attribute.
            //  echo $error;
            $arr = explode('.', $attribute);
            
            $account = $validator->getData()[$arr[0]][$arr[1]];
            
            
            $type = $account['type'];
            
            
            $customMessage = "The withdrawal amount is higher than the actual balance (".$account['balance'].")";

                "Mininum deposit for " .$type['product_id']. ' is '. env('CURRENCY_SIGN').' '.($type['minimum_deposit_per_transaction']);

            $validator->addReplacer('cbu_withdraw', 
                function($message, $attribute, $rule, $parameters) use ($customMessage) {
                    return \str_replace(':custom_message', $customMessage, $message);
                }
            );
            // var_dump($attribute);
            // $account_id = $account['id'];
            // $attribute =$account_id;
            // $attributes = array('account.{$key}.amount'=>$attribute);

            // $validator->setAttributes($attributes);
            // $validator->addReplacer('cbu_deposit', 
            //     function($message, $attribute, $rule, $parameters) use ($account_id) {
            //         return \str_replace(':attribute', $account_id, $attribute);
            //     }
            // );
            
            if($value > $account['raw_balance']){
                return false;
            }
                return true;
            //  return str_contains($value, 
            //          array_get($validator->getData(), $parameters[0])
            //  );
            },$error);
        Validator::extendDependent('cbu_post_interest', function ($attribute, $value, $parameters, $validator){
           
            $arr = explode('.', $attribute);
            
            $account = $validator->getData()[$arr[0]][$arr[1]];
            
            
            $type = $account['type'];
            
            
            $customMessage = "Cannot post interest on accounts with the accrued Interest is 0";

                

            $validator->addReplacer('cbu_withdraw', 
                function($message, $attribute, $rule, $parameters) use ($customMessage) {
                    return \str_replace(':custom_message', $customMessage, $message);
                }
            );
    
            if($account['accrued_interst'] ==0){
                return false;
            }
                return true;
            },$error);

        Validator::extendDependent('maximum_loan_repayment',function ($attribute, $value, $parameters, $validator){


            $values = $validator->getData();

            $acc = LoanAccount::find($values['loan_account_id']);
            $maximum_payment = $acc->maximumPayment();
            $payment = round($value,2);
            
            $customMessage = "Maximum repayment amount is only: " . $maximum_payment->formatted_amount;
            $validator->addReplacer('maximum_loan_repayment', 
                function($message, $attribute, $rule, $parameters) use ($customMessage) {
                    return \str_replace(':custom_message', $customMessage, $message);
                }
            );
    
            if($payment > $maximum_payment->amount){
                return false;
            }
            return true;
            
        },$error);
        Validator::extendDependent('prevent_previous_repayment_date',function ($attribute, $value, $parameters, $validator){


            $values = $validator->getData();

            $acc = LoanAccount::find($values['loan_account_id']);
            if($acc->latestRepayment()==null){
                return true;
            }
            $latest_payment = $acc->latestRepayment()->repayment_date;
            
            $repayment_date = Carbon::parse($value);
            
            $customMessage = "Cannot make repayment before " . $latest_payment->format('F d, Y');
            $validator->addReplacer('prevent_previous_repayment_date', 
                function($message, $attribute, $rule, $parameters) use ($customMessage) {
                    return \str_replace(':custom_message', $customMessage, $message);
                }
            );
            
            if($repayment_date->gte($latest_payment)){
                return true;
            }
                return false;
            
        },$error);
     
    }
}
