@extends('master')
@section('content')
    <div class="container">

        <div class="tab-content" style="padding:10px;">
            {{--            <div class="tab-pane active" id="add_account">--}}
            <a href="/admin/add"><i class="fa fa-plus"></i> Add User Account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/list"><i class="fa fa-edit"></i> User Account List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/account_search"><i class="fa fa-search"></i> User Account Search</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/admin/add_mutil_account"><i class="fa fa-user-plus"></i> Add  Mutilple User Account</a>

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
                <br><br>
                <h3 class="card-title">Add Mutilple User Account</h3>
                <form role="form" class="panel-body" action="/admin/add_mutil_account" method="POST">
                    @csrf
                    <div class="border-t border-gray-300 my-1 p-2">
                        <table id="tbl" class="table table-bordered table-striped">
                            <tbody id="tbody">
                            <tr>
                                <th width="8%">No</th>
                                <th width="8%">Name</th>
                                <th width="12%">E-mail</th>
                                <th width="10%">Add Row</th>
                                <th width="10%">Delete Row</th>
                            </tr>

                            <tr class="tdSet">
                                <td class="tdSet">第0個<input type="hidden" class="form-control" placeholder="test" title="id" name="admin_mutil_id" value="0"></td>
                                <td class="tdSet" ><input type="text" id="name_row_0" name="name_row[]"></td>
                                <td class="tdSet" ><input type="text" id="email_row_0" name="email_row[]"></td>
                                <td><input type="button" id="btn_add_row_0" value="新增一行-原始" onclick="addRow(this);" ></td>
                                <td><input type="button" id="btn_del_row_0" value="刪除一行-原始" onclick="delRow(this)"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>



                    <br>
                    <div class="input-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="submit" value="Add Multiple User" class="btn btn-info">
                            </div>
                            <div class="col-md-6">
                                {{--                                                    <input type="reset" value="Clear" class="btn btn-danger" style="width: 100%">--}}
                            </div>
                        </div>
                    </div>
                </form>
                <!-- 行,列增加/刪除 -->
                {{--                    <div>--}}
                {{--                        <input type="button" value="新增一行" onclick="addRow()"/>--}}
                {{--                        <input type="button" value="刪除一行" onclick="delRow()"/>--}}
                {{--                        <input type="button" value="新增一列" onclick="addCol()"/>--}}
                {{--                        <input type="button" value="刪除一列" onclick="delCol()"/>--}}
                {{--                    </div>--}}

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
