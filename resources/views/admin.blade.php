@extends('master')
@section('content')
    <div class="container">
{{--        <h2>admin.blade.php</h2>--}}

        {{--        <ul class="nav nav-tabs">--}}
{{--            <li><a href="#add_account" data-toggle="tab">Add User Account</a></li>--}}
{{--            <li><a href="#update_account" data-toggle="tab">User Account modification</a></li>--}}
{{--            <li><a href="#download" data-toggle="tab">download</a></li>--}}
{{--            <li><a href="#config" data-toggle="tab">config</a></li>--}}
{{--        </ul>--}}
        <div class="tab-content" style="padding:10px;">
{{--            <div class="tab-pane active" id="add_account">--}}
            <a href="/admin/add"><i class="fa fa-plus"></i> Add User Account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/list"><i class="fa fa-edit"></i> User Account List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/account_search"><i class="fa fa-search"></i> User Account Search</a>
                <div class="custom-product">
                    <div class="container">
                        <div class="row">
                            <div class="trending-wrapper">
                                <h3 class="card-title">Add User Account</h3>
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                            <strong>Warning!</strong>&nbsp;{{ $error }}
                                        @endforeach
                                    </div>
                                @elseif(session('status'))
                                    <div class="alert alert-success">
                                        <strong>{{ session('status') }}</strong>
                                    </div>
                                @endif
                                <form role="form" class="panel-body" action="/admin/add" method="post">
                                    @csrf
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-users"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Name" title="名字" name="name">
                                        </div>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Email" title="Email" name="email">
                                        </div>

                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Password" title="密碼" name="password">
                                        </div>

                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
{{--                                            <input type="text" class="form-control" placeholder="Address County" title="縣市" name="address_county" id="address_county">--}}
                                            全台縣市
                                            <select class="form-control" name="address_county" id="address_county">
                                                <option value="">-----</option>
                                                @foreach($address_countys as $key => $address_county)
                                                <option value="{{ $address_county->county }}">{{ $address_county->county }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
{{--                                            <input type="text" class="form-control" placeholder="Address City" title="鄉鎮市區" name="address_city">--}}
                                            鄉鎮市區
                                            <select class="form-control" name="address_city" id="address_city">
                                                <option value="">-----</option>
                                            </select>
                                        </div>

                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            郵遞區號
                                            <input type="text" class="form-control" placeholder="Zip" title="郵遞區號" name="address_zip" id="address_zip" readonly>
                                        </div>

                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Address Street" title="街道" name="address_street" size="50">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="submit" value="Add User" class="btn btn-primary">
                                                </div>
                                                <div class="col-md-6">
{{--                                                    <input type="reset" value="Clear" class="btn btn-danger" style="width: 100%">--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
{{--            </div>--}}

{{--            <div class="tab-pane" id="download">--}}
{{--                <p>download</p>--}}
{{--            </div>--}}
{{--            <div class="tab-pane" id="config">--}}
{{--                <p>config</p>--}}
{{--            </div>--}}
        </div>
    </div>

@endsection
