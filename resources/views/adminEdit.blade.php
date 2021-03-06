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
            <a href="/admin/add"><i class="fa fa-plus"></i> Add User Account</a>&nbsp;&nbsp;&nbsp;
            <a href="/admin/account_search"><i class="fa fa-search"></i> User Account Search</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/add_mutil_account"><i class="fa fa-user-plus"></i> Add  Mutilple User Account</a>
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
                        <th width="1%">ID</th>
                        <th width="8%">Name</th>
                        <th width="10%">E-mail</th>
                        <th width="15%">User Level</th>
                        <th width="15%">Address County</th>
                        <th width="15%">Address City</th>
                        <th width="5%">Address Zip</th>
                        <th width="10%">Authority</th>
                        <th width="8%">Edit</th>
                        {{--                                <th width="8%">Delete</th>--}}
                    </tr>
                    <tr>
                        <form action="/admin/edit/{{ $user->id }}" method="post">
                            @csrf
                            <td>
                                <input type="text" name="update_id" value="{{ $user->id }}" disabled id="update_id" size="1">
                            </td>
                            <td>
                                <input type="text" name="update_name" value="{{ $user->name }}" size="7">
                            </td>
                            <td>
                                <input type="text" name="update_email" value="{{ $user->email }}">
                            </td>
                            <td>

                                <select class="form-control" name="update_user_level" required id="update_user_level">
                                    <option value="0" {{ $user->user_level == 0 ? 'selected' : '' }}>初級會員 (0)</option>
                                    <option value="1" {{ $user->user_level == 1 ? 'selected' : '' }}>進階會員 (1)</option>
                                    <option value="2" {{ $user->user_level == 2 ? 'selected' : '' }}>高級會員 (2)</option>
                                </select>
                            </td>

                            <td>
                                <select class="form-control" name="update_address_county" required id="update_address_county">
                                    <option value="">-----</option>
                                    @foreach($address_countys as $key => $address)
                                        <option value="{{ $address->county }}" {{ $user->address_county == $address->county ? 'selected' : '' }}>{{ $address->county }}</option>
                                    @endforeach

                                </select>
                            </td>

                            <td>
                                <select class="form-control" name="update_address_city" required id="update_address_city">
                                    <option value="">-----</option>
{{--                                    @foreach($address_all as $key => $address)--}}
{{--                                        @if($user->address_county == $address->county)--}}
{{--                                        <option value="{{ $address->city }}" {{ $user->address_city == $address->city ? 'selected' : '' }}>{{ $address->city }}</option>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
                                    @foreach($address_citys as $key => $address_city)
                                        <option value="{{ $address_city->city }}" {{ $user->address_city == $address_city->city ? "selected" : "" }}>{{ $address_city->city }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" class="form-control" name="update_address_zip" id="update_address_zip" value="{{ $user->address_zip }}" size="2" readonly>
                            </td>

                            <td>
{{--                                <input type="hidden" name="user_id" value="{{ $user->id }}">--}}
{{--                                <input type="checkbox"--}}
{{--                                       id="authority_add_id"--}}
{{--                                       name="authority_add_id">--}}
{{--                                <label for="authority_add_id">新增</label><br/>--}}
{{--                                <input type="checkbox"--}}
{{--                                       id="authority_edit_id"--}}
{{--                                       name="authority_edit_id">--}}
{{--                                <label for="authority_edit_id">編輯</label><br/>--}}
{{--                                <input type="checkbox"--}}
{{--                                       id="authority_delete_id"--}}
{{--                                       name="authority_delete_id">--}}
{{--                                <label for="authority_delete_id">刪除</label>--}}

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
                            </td>
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
