@extends('layouts.user')

@section('content')
<div class="content pl-32 pr-8 mt-4" id="content-full">
    <div class="row">
        <div class="col-md-12">
            <div class="card chart-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="chart-header">Total Shipments</h5>
                            <h2 class="chart-title">Performance</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                    <input type="radio" name="options" checked="">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Accounts</span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="1">
                                    <input type="radio" name="options" checked="">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Purchases</span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="1">
                                    <input type="radio" name="options" checked="">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card chart-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="chart-header">Total Shipments</h5>
                            <h2 class="chart-title">Performance</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card chart-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="chart-header">Total Shipments</h5>
                            <h2 class="chart-title">Performance</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card chart-container">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="chart-header">Total Shipments</h5>
                            <h2 class="chart-title">Performance</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>	

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5>Tables</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>ID</td>
                                <td>Body</td>
                                <td>Actions</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>
                                    <p class="title">Sample Data</p>
                                    <p class="text-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </td>
                                <td class="float-right">
                                    <a href="">
                                        <i class="fas fa-2x fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection