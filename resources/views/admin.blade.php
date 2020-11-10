@extends('master')
@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li><a href="#account" data-toggle="tab">Add User Account</a></li>
            <li><a href="#board" data-toggle="tab">留言板</a></li>
            <li><a href="#download" data-toggle="tab">下載區</a></li>
            <li><a href="#config" data-toggle="tab">設定</a></li>
        </ul>
        <div class="tab-content" style="padding:10px;">
            <div class="tab-pane active" id="account">
                <p>Add User Account</p>
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
                                <form role="form" class="panel-body" action="/admin" method="post">
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
                                        <br>
                                        <div class="input-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="reset" value="Clear" class="btn btn-danger" style="width: 100%">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="submit" value="Add" class="btn btn-primary" style="width: 100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="board">
                <p>這是留言板</p>
            </div>
            <div class="tab-pane" id="download">
                <p>這是下載區</p>
            </div>
            <div class="tab-pane" id="config">
                <p>這是設定</p>
            </div>
        </div>
    </div>

@endsection
