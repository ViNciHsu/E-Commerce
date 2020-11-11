@extends('master')
@section('content')


    <div class="container">
{{--        <h2>adminEdit.blade.php</h2>--}}
{{--        <ul class="nav nav-tabs">--}}
{{--            <li><a href="#add_account" data-toggle="tab">Add User Account</a></li>--}}
{{--            <li><a href="#update_account" data-toggle="tab">User Account modification</a></li>--}}
{{--            <li><a href="#download" data-toggle="tab">download</a></li>--}}
{{--            <li><a href="#config" data-toggle="tab">config</a></li>--}}
{{--        </ul>--}}
        <div class="tab-content" style="padding:10px;">
{{--            <div class="tab-pane active" id="add_account">--}}
                <a href="/admin"><i class="fa fa-plus"></i> Add User Account</a>&nbsp;&nbsp;&nbsp;
                <a href="/admin/list"><i class="fa fa-edit"></i> User Account List</a>
{{--                <div class="custom-product">--}}
{{--                    <div class="container">--}}
{{--                        <div class="row">--}}
{{--                            <div class="trending-wrapper">--}}
{{--                                <h3 class="card-title">Add User Account</h3>--}}
{{--                                @if($errors->any())--}}
{{--                                    <div class="alert alert-danger">--}}
{{--                                        @foreach($errors->all() as $error)--}}
{{--                                            <strong>Warning!</strong>&nbsp;{{ $error }}--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                @elseif(session('status'))--}}
{{--                                    <div class="alert alert-success">--}}
{{--                                        <strong>{{ session('status') }}</strong>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                                <form role="form" class="panel-body" action="/admin" method="post">--}}
{{--                                    @csrf--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="input-group mb-3">--}}
{{--                                            <div class="input-group-prepend">--}}
{{--                                                <span class="input-group-text"><i class="fa fa-users"></i></span>--}}
{{--                                            </div>--}}
{{--                                            <input type="text" class="form-control" placeholder="Name" title="名字" name="name">--}}
{{--                                        </div>--}}

{{--                                        <div class="input-group mb-3">--}}
{{--                                            <div class="input-group-prepend">--}}
{{--                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>--}}
{{--                                            </div>--}}
{{--                                            <input type="email" class="form-control" placeholder="Email" title="Email" name="email">--}}
{{--                                        </div>--}}

{{--                                        <div class="input-group mb-4">--}}
{{--                                            <div class="input-group-prepend">--}}
{{--                                                <span class="input-group-text"><i class="fa fa-eye"></i></span>--}}
{{--                                            </div>--}}
{{--                                            <input type="text" class="form-control" placeholder="Password" title="密碼" name="password">--}}
{{--                                        </div>--}}
{{--                                        <br>--}}
{{--                                        <div class="input-group">--}}
{{--                                            <div class="row">--}}
{{--                                                --}}{{--                                                <div class="col-md-6">--}}
{{--                                                --}}{{--                                                    <input type="reset" value="Clear" class="btn btn-danger" style="width: 100%">--}}
{{--                                                --}}{{--                                                </div>--}}
{{--                                                <div class="col-md-6">--}}
{{--                                                    <input type="submit" value="Add" class="btn btn-primary" style="width: 100%">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="tab-pane" id="update_account">
                <h3 class="card-title">Edit User Account</h3>
{{--                @foreach($users as $user)--}}
                    <div class="border-t border-gray-300 my-1 p-2">
                        <table id="account_table" class="table table-bordered table-striped">
                            <tr>
                                <th width="15%">Name</th>
                                <th width="30%">email</th>
                                <th width="8%">Edit</th>
{{--                                <th width="8%">Delete</th>--}}
                            </tr>
                            <tr>
                                <form action="/admin/edit/{{ $user->id }}" method="post">
                                    @csrf
                                    <td>
                                        <input type="text" name="update_name" value="{{ $user->name }}">
                                    </td>
                                    <td>
                                        <input type="text" name="update_email" value="{{ $user->email }}">
                                    </td>
                                    <td>
    {{--                                        @method('patch')--}}
                                            <button type="submit" class="btn btn-primary">Edit</button>

                                    </td>
                                </form>
{{--                                <td>--}}
{{--                                    <form action="/admin/{{ $user->id }}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        @method('delete')--}}
{{--                                        <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
                            </tr>
                        </table>
                    </div>
{{--                @endforeach--}}
{{--                {{ $users->links() }}--}}
            </div>
{{--            <div class="tab-pane" id="download">--}}
{{--                <p>download</p>--}}
{{--            </div>--}}
{{--            <div class="tab-pane" id="config">--}}
{{--                <p>config</p>--}}
{{--            </div>--}}
        </div>

@endsection
