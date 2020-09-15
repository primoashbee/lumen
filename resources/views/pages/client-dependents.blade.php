@extends('layouts.user')
@section('content')
<div class="content content pl-32 pr-8 mt-4" id="content-full">
    
    <div class="card">
		<div class="card-header">
			<h3 class="h3">Insurance</h3>
		</div>
		<div class="card-body">
            <a href="{{route('client.create.dependents',$client->id)}}"><button class="btn btn-primary float-right">Create Dependents</button></a>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <td>
                            <p class="title">Application Number</p>
                        </td>
                        <td>
                            <p class="title">Unit of Plan</p>
                        </td>
                        <td>
                            <p class="title">Dependents</p>
                        </td>
                        <td>
                            <p class="title">Amount</p>
                        </td>
                        <td>
                            <p class="title">Status</p>
                        </td>
                        <td>
                            <p class="title">Action</p>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->dependents as $dependent)
                        <tr>
                            <td>{{$dependent->application_number}}</td>
                            <td>{{$dependent->unit_of_plan}}</td>
                            <td>{{($dependent->numberOfDependents())}}</td>
                            <td>xxx</td>
                            <td>Amount</td>
                            <td>
                                @if($dependent->active)
                                    <span class="badge badge-pill badge-success">Active</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>Amount</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection