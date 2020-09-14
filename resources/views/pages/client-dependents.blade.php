@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
    
    <div class="card">
		<div class="card-header">
			<h3 class="h3">Insurance</h3>
		</div>
		<div class="card-body">
            <a href="{{route('client.create.dependents',$id)}}"><button class="btn btn-primary float-right">Create Dependents</button></a>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td>
                            <p class="title">Package</p>
                        </td>
                        <td>
                            <p class="title">Amount</p>
                        </td>
                        <td>
                            <p class="title">Status</p>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>500</td>
                        <td>Active</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection