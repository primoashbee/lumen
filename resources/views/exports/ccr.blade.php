<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{-- <link rel="stylesheet" href="{{'/css/bootstrap.css'}}"> --}}
<link rel="stylesheet" href="{{public_path('/css/bootstrap.css')}}">
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma-rtl.min.css"> --}}
</head>
<style>
    /* /* body { 
        font-family: DejaVu Sans, sans-serif; 
        font-size: 1em !important;
        
    } */
    .table thead tr>td {
        font-size: 0.8em !important;
        font-weight: 900 !important;
        white-space:nowrap !important;

    }
    .table tbody>tr>td{
        font-size: 0.6em !important;
        font-weight: normal !important;
        white-space:nowrap !important;

    } */
</style>

<body>
    <table class="table">
        <thead>
            <tr>
                <td>#</td>
                <td>Client ID</td>
                <td>Name</td>
                <td>Loan</td>
                <td>Interest</td>
                <td>Principal</td>
                <td>Payment</td>
                @if($summary->has_deposit)
                    @foreach ($summary->deposit_list as $item)
                        <td>{{$item->type->product_id}} - Balance</td>
                        <td>{{$item->type->product_id}}</td>
                    @endforeach
                @endif
            </tr>
        </thead>

        <tbody>
            <?php $ctr = 1; ?>
            @foreach ($summary->data as $value)
            <tr>
                <td> {{$ctr}} </td>
                <td>{{$value->client_id}}</td>
                <td>{{$value->client->full_name}}</td>
                <td>{{$value->product->code}}</td>
                <td>{{$value->repayment_info->_interest}}</td>
                <td>{{$value->repayment_info->_principal}}</td>
                <td>{{$value->repayment_info->_amount_due}}</td>
                @if($summary->has_deposit)
                    @foreach ($value->client->deposits as $deposit)
                        <td>{{$deposit->balance_formatted}}</td>
                        <td><input type="text" class="form-control" /></td>
                    @endforeach
                @endif
            </tr>
            <?php $ctr++;?>
            @endforeach
        <tbody>
    </table>
</body>
</html>