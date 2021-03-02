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

                    <div class="border-t border-gray-300 my-1 p-2">
                        <table id="account_table" class="table table-bordered table-striped">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="8%">Name</th>
                        <th width="10%">E-mail</th>
                        <th width="10%">Address County</th>
                        <th width="10%">Address City</th>
                        <th width="10%">Address Zip</th>
                        <th width="10%">Address Street</th>
                    </tr>

                        <tr>
                            <td>
                                <input type="text" id="user_ajax_id" name="user_ajax_id" readonly size="2">
                            </td>
                            <td>
                                <input type="text" id="user_ajax_name" name="user_ajax_name" readonly size="10">
                            </td>
                            <td>
                                <input type="text" id="user_ajax_email" name="user_ajax_email" readonly size="10">
                            </td>
                            <td>
                                <input type="text" id="user_ajax_county" name="user_ajax_county" readonly size="4">
                            </td>
                            <td>
                                <input type="text" id="user_ajax_city" name="user_ajax_city" readonly size="4">
                            </td>
                            <td>
                                <input type="text" id="user_ajax_zip" name="user_ajax_zip" readonly size="2">
                            </td>
                            <td>
                                <input type="text" id="user_ajax_street" name="user_ajax_street" readonly size="15">
                            </td>
                        </tr>
                        </table>
                    </div>
{{--                    User-Email: <input type="text" id="user_ajax_email" name="user_ajax_email">--}}
{{--                    <textarea id="user_ajax_result_textarea" name="user_ajax_result_textarea" cols="50" rows="5"></textarea>--}}
                        <br>
                </div>
                <br><br><br><br><br><br>

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
