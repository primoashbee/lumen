<?php

namespace App\Http\Controllers;

use App\LoanAccountDisbursement;
use App\LoanAccountRepayment;
use Illuminate\Http\Request;

use App\Rules\TransactionType;
use App\Rules\ValidTransactionID;
use Exception;
use Illuminate\Support\Facades\Validator;

class RevertController extends Controller
{
    public function revert(Request $request){
        $user_id = auth()->user()->id;
        $request->request->add(['user_id'=>$user_id]);
        $this->validator($request->all())->validate();
        $type = $this->checkPaymentType($request->transaction_id);
        if ($type =='repayment') {
            \DB::beginTransaction();

            try {
                $transaction = LoanAccountRepayment::where('transaction_id', $request->transaction_id)->first();
                $res = $transaction->revert($user_id);
                
                \DB::commit();

                if ($res) {
                    $transaction->loanAccount->updateAccount();
                    // $transaction->loanAccount->updateStatus();
                    return response()->json(['msg'=>'Transaction reverted succesfully!'], 200);
                } else {
                    return response()->json(['msg'=>'Cannot revert transaction. Revert latest transaction first'], 422);
                }
            } catch (Exception $e) {
                return response()->json(['msg'=>$e->getMessage()], 500);
            }
        }
        if($type=='pretermination'){
            \DB::beginTransaction();
            try{
                $transaction = LoanAccountRepayment::where('transaction_id', $request->transaction_id)->first();
                $res = $transaction->revertPretermination($user_id);

                \DB::commit();
                if ($res) {
                    // $transaction->loanAccount->updateAccount();
                    $transaction->loanAccount->updateStatus();
                    return response()->json(['msg'=>'Transaction reverted succesfully!'], 200);
                } else {
                    return response()->json(['msg'=>'Cannot revert transaction. Revert latest transaction first'], 422);
                }
            } catch (Execption $e){
                return response()->json(['msg'=>$e->getMessage()], 500);
            }
        }
        if($type=='disbursement'){
            \DB::beginTransaction();
            try{
                $transaction = LoanAccountDisbursement::where('transaction_id',$request->transaction_id)->first();
                $account  = $transaction->loanAccount;
                if($account->canRevertDisbursement($request->transaction_id)){
                    if($account->revertDisbursement($request->transaction_id,auth()->user()->id)){
                        \DB::commit();
                        return response()->json(['msg','Account revert disbursement successful'],200);
                    }
                    return response()->json(['msg','Something went wrong'],422);
                }
                return response()->json(['msg'=>'Cannot revert disbursement. Revert transaction before disbursement first'],422);
                
            }catch(Exception $e){
                return response()->json(['msg'=>$e->getMessage()], 500);
            }
        }
    }

    public function validator(array $data){
        return Validator::make($data,[
            // 'type'=>['required',new TransactionType],
            'user_id'=>['required','exists:users,id'],
            'transaction_id'=>['required', new ValidTransactionID],
            'loan_account_id'=>['required','exists:loan_accounts,id']
        ]);
    }


    public function checkPaymentType($transaction_id){
        //check if repayment
        $repayment = LoanAccountRepayment::where('transaction_id',$transaction_id);
        if($repayment->count() > 0){
            return $repayment->first()->for_pretermination ? 'pretermination' : 'repayment';
        }
        $disbursement = LoanAccountDisbursement::where('transaction_id',$transaction_id);
        if($disbursement->count() > 0){
            return 'disbursement';
        }
        
    }
}
