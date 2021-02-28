@extends('master')
@section('content')
    <div class="container">

        <div class="tab-content" style="padding:10px;">
            {{--            <div class="tab-pane active" id="add_account">--}}
            <a href="/admin/add"><i class="fa fa-plus"></i> Add User Account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/list"><i class="fa fa-edit"></i> User Account List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/account_search"><i class="fa fa-search"></i> User Account Search</a>

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
            <h3 class="card-title">User Account Search</h3>
                <div class="border-t border-gray-300 my-1 p-2">
                <h4>Account Level :</h4>
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <select class="form-control" name="search_user_level" required id="search_user_level" onchange="clean_select_data()">
                        <option value="99">---請選擇會員等級---</option>
                        <option value="0">初級會員 (0) search</option>
                        <option value="1">進階會員 (1) search</option>
                        <option value="2">高級會員 (2) search</option>
                    </select>
{{--                    <input type="text" id="description" name="description">--}}
                    以下要呈現資料下拉選單的AJAX資料 (符合該會員等級的名字)<br>
                    @foreach($users_ajax as $key => $user_ajax)
{{--                    <input type="text" id="description0" name="description[{{$key}}]"><br>--}}
                    @endforeach
                    <br><br>
                    <select class="form-control"  name="user_ajax_result" id="user_ajax_result" disabled></select>
                    <br><br>
                    User-Email: <input type="text" id="user_ajax_email" name="user_ajax_email">
{{--                    <textarea id="user_ajax_result_textarea" name="user_ajax_result_textarea" cols="50" rows="5"></textarea>--}}
                        <br>
                </div>
                <br><br>
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
                                    <select class="form-control" name="origin_update_user_level" required>
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
