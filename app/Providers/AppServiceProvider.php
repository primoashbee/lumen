<?php

namespace App\Providers;

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
            // $customMessage = json_encode(array(
            //     'id'=>$account_id, 
            //     'msg'=> "Mininum deposit for " .$type['product_id']. ' is '. env('CURRENCY_SIGN').' '.($type['minimum_deposit_per_transaction'])
            // ));
            // $customMessage = json_encode(array(
                // 'id'=>$account_id, 
            $customMessage = "Mininum deposit for " .$type['product_id']. ' is '. env('CURRENCY_SIGN').' '.($type['minimum_deposit_per_transaction']);
            // ));
            

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
    }
}
