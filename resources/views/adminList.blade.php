@extends('master')
@section('content')
    <div class="container">
{{--        <h2>adminList.blade.php</h2>--}}

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
            @if(session('status'))
                <div class="alert alert-success">
                    <strong>{{ session('status') }}</strong>
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    <strong>{{ session('error') }}</strong>
                </div>
            @endif
            <h3 class="card-title">User Account List</h3>
            @foreach($users as $user)
                <div class="border-t border-gray-300 my-1 p-2">
                    <table id="account_table" class="table table-bordered table-striped">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Name</th>
                            <th width="30%">E-mail</th>
                            <th width="15%">User Level</th>
                            <th width="8%">Edit</th>
                            <th width="8%">Delete</th>
                            <th width="8%">原頁修改</th>
                        </tr>

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->user_level == 0)
                                    初級會員 (0)
                                @elseif($user->user_level == 1)
                                    進階會員 (1)
                                @elseif($user->user_level == 2)
                                    高級會員 (2)
                                @endif
                            </td>
                            <td>
                                <a href="/admin/edit/{{ $user->id }}" type="submit" class="btn btn-warning">Edit</a>
                            </td>
                            <td>
                                <form action="/admin/{{ $user->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            <td>
                                <form action="/admin/{{ $user->id }}" method="post">
                                    @csrf
{{--                                    @method('get')--}}
                                    <input type="text" value="{{ $user->name }}" name="origin_update_name">
                                    <input type="text" value="{{ $user->email }}" name="origin_update_email">
                                    <select class="form-control" name="origin_update_user_level" required id="origin_update_user_level">
                                        <option value="0" {{ $user->user_level == 0 ? 'selected' : '' }}>初級會員 (0)</option>
                                        <option value="1" {{ $user->user_level == 1 ? 'selected' : '' }}>進階會員 (1)</option>
                                        <option value="2" {{ $user->user_level == 2 ? 'selected' : '' }}>高級會員 (2)</option>
                                    </select>
                                    <br>
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <input type="checkbox"
                                           id="authority_add_id"
                                           name="authority_add_id"
                                           @if($user->add == 1) checked @endif>
                                    <label for="authority_add_id">新增</label><br/>
                                    <input type="checkbox"
                                           id="authority_edit_id"
                                           name="authority_edit_id"
                                           @if($user->edit == 1) checked @endif>
                                    <label for="authority_edit_id">編輯</label><br/>
                                    <input type="checkbox"
                                           id="authority_delete_id"
                                           name="authority_delete_id"
                                           @if($user->delete == 1) checked @endif>
                                    <label for="authority_delete_id">刪除</label>
                                    <br>
                                    <button type="submit" class="btn btn-info">原頁修改</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach
            {{--                {{ $users->links() }}--}}
        </div>
{{--        <div class="tab-pane" id="download">--}}
{{--            <p>download</p>--}}
{{--        </div>--}}
{{--        <div class="tab-pane" id="config">--}}
{{--            <p>config</p>--}}
{{--        </div>--}}
    </div>

@endsection
