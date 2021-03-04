<?php

namespace App\Http\Controllers;

use App\LoanAccount;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DownloadController extends Controller
{
    
    public function dst($loan_account_id){
        $loan_account = LoanAccount::find($loan_account_id);
        $file = public_path('templates/DSTv1.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet =$spreadsheet->getSheet(0);
        $cw = clone $sheet;
        
        $type = $loan_account->type;
        $feePayments  = $loan_account->feePayments->sortBy('fee_id');

        $ctr = 1;
        $cw->setTitle('#'.$ctr.' '.$loan_account->client->full_name);
        $dst = $spreadsheet->addSheet($cw);
        $dst->getCell('C18')->setValueExplicit($loan_account->amount,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->setCellValue('D8',$type->code);
        $dst->getCell('D9')->setValueExplicit($loan_account->amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        
        $dst->getCell('D10')->setValueExplicit($loan_account->installments->first()->amortization, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getCell('D11')->setValueExplicit($type->interest_rate,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getStyle('D11')->getNumberFormat()->setFormatCode('0.00'); 
        $dst->getCell('D12')->setValueExplicit($type->interest_rate / 4,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getStyle('D12')->getNumberFormat()->setFormatCode('0.00'); 
        if ($type->code == "MPL") {
            $dst->getCell('D13')->setValueExplicit($feePayments->where('fee_id', 6)->first()->fee->percentage, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        }
        $dst->setCellValue('D14',$loan_account->number_of_installments);
        
        $dst->setCellValue('F19','=ROUND((H11*D13),2)');
        $dst->setCellValue('G19','=C18-F19');
        
        
        $dst->getCell('H9')->setValueExplicit($loan_account->interest, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->setCellValue('H10',$loan_account->number_of_months);
        $dst->getCell('H11')->setValueExplicit($loan_account->amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->setCellValue('H12',$loan_account->client->loanCycle());

        // $dst->setCellValue('H19',$loan_account->number_of_months);

        $dst->getCell('I19')->setValueExplicit($loan_account->total_loan_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

        $dst->getCell('J19')->setValueExplicit($loan_account->interest, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

        $row = 20;
        $amortizartion_schedule_row = 5;


        $dst->getCell('AC4')->setValueExplicit($loan_account->amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getCell('AD4')->setValueExplicit($loan_account->interest, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getCell('AE4')->setValueExplicit($loan_account->total_loan_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getCell('AF4')->setValueExplicit($loan_account->total_loan_amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

        foreach($loan_account->installments as $item){
            $dst->setCellValue('C'.$row , $item->date->toDateString());
            $dst->getCell('D'.$row)->setValueExplicit($item->original_principal, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('E'.$row)->setValueExplicit($item->original_interest, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('G'.$row)->setValueExplicit(($item->amortization) * (-1), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('H'.$row)->setValueExplicit($item->principal_balance, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('I'.$row)->setValueExplicit(round($item->principal_balance + $item->interest_balance,2), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('I'.$row)->setValueExplicit($item->interest_balance, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            
            

            $dst->setCellValue('AB'.$amortizartion_schedule_row, $item->date->toDateString());
            $dst->getCell('AC'.$amortizartion_schedule_row)->setValueExplicit($item->original_principal, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('AD'.$amortizartion_schedule_row)->setValueExplicit($item->original_interest, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('AE'.$amortizartion_schedule_row)->setValueExplicit($item->amortization, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('AF'.$amortizartion_schedule_row)->setValueExplicit($item->principal_balance, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

            $amortizartion_schedule_row++;
            $row++;
        }

        $dst->setCellValue('Q5',$loan_account->client->full_name);
        $dst->setCellValue('Q6',$loan_account->client->address());
        $dst->setCellValue('Y7','=D9');
        


        
        $str = "(  ) Weekly               (  ) Semi-monthly          (  ) Monthly ";
        $str2 = "(  ) Quarterly           (  ) Semi-Annual            (  ) Annually";
        if($type->installment_method == 'weeks'){
            $str = "(X) Weekly               (  ) Semi-monthly          (  ) Monthly ";
        }
        $dst->setCellValue('M10',$str);
        $dst->setCellValue('M11',$str2);

        if($type->code == "MPL"){
            $dst->setCellValue('N14', $feePayments->where('fee_id', 6)->first()->fee->name);
            $dst->getCell('Y14')->setValueExplicit($feePayments->where('fee_id', 6)->first()->amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
            $dst->getCell('Y16')->setValueExplicit($feePayments->where('fee_id', 6)->first()->amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        }

        $row = 19;
        
        $non_finance_charges = $loan_account->nonFinanceCharges();
        $non_finance_charges->map(function($fee) use (&$row, &$dst){
            $dst->setCellValue('N'.$row,$fee->fee->name);
            $dst->getCell('Y'.$row)->setValueExplicit($fee->amount, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);

            $row++;
        });
        
        $dst->setCellValue('Y24','=SUM(Y19:Y23)');
        $dst->setCellValue('Y26','=Y16+Y24');
        $dst->setCellValue('Y28','=Y7-Y26');
        $dst->setCellValue('Y30','=D13');
        $dst->setCellValue('Y32','=H80');
        $dst->setCellValue('Y38','=I19');

        $dst->setCellValue('R36',$loan_account->installments->first()->date->format('F d, Y'));
        $dst->getCell('Y36')->setValueExplicit($loan_account->installments->first()->amortization, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getCell('O39')->setValueExplicit($loan_account->number_of_installments, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $dst->getCell('O40')->setValueExplicit($loan_account->installments->first()->amortization, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        

        $dst->setCellValue('D69','=SUM(D19:D67)');
        $dst->setCellValue('E69','=SUM(E19:E67)');
        $dst->setCellValue('F69','=SUM(F19:F67)');
        $dst->setCellValue('H76','=(1+G69)^52-1');
        $dst->setCellValue('H80','=((1+G69)^(52/12)-1)');



        $spreadsheet->removeSheetByIndex(0);
        $spreadsheet->setActiveSheetIndex(0);
        
        $writer = new Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        $newFile = public_path('templates/test.xlsx');
        $writer->save($newFile);
        $filename = 'DST - '.$loan_account->client->full_name . '.xlsx';
        $headers = ['Content-Type'=> 'application/pdf','Content-Disposition'=> 'attachment;','filename'=>$filename];
        return response()->download($newFile,$filename,$headers)->deleteFileAfterSend(true);
    }
}
