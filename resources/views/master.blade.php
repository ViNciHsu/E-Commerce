<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">--}}
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Commerce Project</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="assets/https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- console 會報錯，因為也要放 jQuery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="sweetalert2.all.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <!-- use-font-awesome-icons-in-laravel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
{{--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
    </script>
    <script type="text/javascript">
        // var uri = window.location.href.split(/\?|#/)[0];
        // // var uri = window.location.pathname;
        // alert(uri);
        // // Returns http://example.com/something
        //
        // var hash = window.location.hash;
        // alert(hash);
        // Returns #hash
        function clean_select_data(){
            // 清除下拉選單顯示的<input>資料
            for (i = 0; i < 10; i++) {
                $("input[name='description["+i+"]']").val('');
                // $("input[name='description[]']").remove();
            }
        }

        // 新增一列
        function addCol(){
            $col = $("<td class='tdSet'><input type='text' /></td>");
            $("#tbody tr").append($col);
        }

        // 刪除一列
        function delCol(){
            alert($("#tbody tr").eq(0).find("td").length);
            if(  $("#tbody tr").eq(0).find("td").length <= 2 ){
                return;
            }
            alert($("#tbody tr").length);
            $("#tbody tr td:last-child").remove();
        }

        // 新增一行
        var i = 0;
        function addRow(obj){
            i ++;
            R = tbl.insertRow()
            C = R.insertCell()
            C.innerHTML = "第"+i+"個"
            // C = R.insertCell()
            C.innerHTML += "<input type='hidden' id='admin_mutil_id-"+i+"' name='admin_mutil_id-"+i+"' value='"+i+"'>"
            C = R.insertCell()
            C.innerHTML = "<input type='text' id='name_row_"+i+"' name='name_row[]'>"
            // C.innerHTML = "<input type='text' id='name_row_"+i+"' name='name_row_"+i+"'>"
            C = R.insertCell()
            C.innerHTML = "<input type='text' id='email_row_"+i+"' name='email_row[]'>"
            // C.innerHTML = "<input type='text' id='email_row_"+i+"' name='email_row_"+i+"'>"
            C = R.insertCell()
            C.innerHTML = "<input type='button' id='btn_add_row_"+i+"' value='新增一行' onclick='addRow(this)'>"
            C = R.insertCell()
            C.innerHTML = "<input type='button' id='btn_del_row_"+i+"' value='刪除一行' onclick='delRow(this)'>"
            console.log(obj.parentElement.parentElement.rowIndex);
            $('#add_row_0').attr('id','add_row_'+i);
            $('#del_row_0').attr('id','del_row_'+i);
            $('#btn_add_row_0').attr('id','btn_add_row_'+i);
            $('#btn_del_row_0').attr('id','btn_del_row_'+i);
        }

        // 刪除一行
        function delRow(obj){
            if($("#tbody tr").length <= 1){
                return;
            }
            // alert(obj.parentElement.parentElement.rowIndex);
            // obj如果是<td>,parentElement就是<tr>,
            // parentElement.parentElement就是<table>
            // 所以整串就是table.rowIndex,得到在<table>的哪一行
            tbl.deleteRow(obj.parentElement.parentElement.rowIndex);
        }



        $(document).ready(function (){
            $('#update_user_level').select2();
            $('#origin_update_user_level').select2();
            $('#search_user_level').select2();
            $('#user_ajax_result').select2();
            $('#address_county').select2();
            $('#address_city').select2();
            $('#update_address_county').select2();
            $('#update_address_city').select2();


            $('#search_user_level').on("select2:select",function (e){
                var obj_data = $(this).val();
                // alert(obj_data);
                if(obj_data != 99){
                $.ajax({
                   type:'GET',
                   url:'{{ url('admin/account_search') }}/'+ obj_data,
                    success: function (data) {
                        var ln = data.length;
                        var show_str = "<option value='noData'>---請選擇會員名字---</option>";
                        // alert(data.length + '筆資料');
                        for (i = 0; i < ln; i++) {
                            // $("input[name='description["+i+"]']").val(data[i].name);
                            show_str += "<option value="+data[i].name +">"+ data[i].name +"</option>";
                            // textarea
                            // if(show_str != '') show_str += '\r\n';
                            // show_str += data[i].name;
                        }
                        // textarea
                        // $('#textarea0').val(show_str);
                        // 第二階下拉選單
                        $("#user_ajax_result").empty();
                        $("#user_ajax_result").append(show_str);
                        $("#user_ajax_result").attr("disabled",false);
                        $("#user_ajax_email").val('');
                       // alert('成功');
                    },
                    error: function (xhr, status, error){
                       console.log(xhr);
                    }
                });
                }else{
                    $("#user_ajax_email").val('');
                    $("#user_ajax_result").empty();
                    $("#user_ajax_result").attr("disabled",true);
                }
            });

            // 第二層下拉選單
            $('#user_ajax_result').on("select2:select",function (e){
                var obj_data2 = $(this).val();
                // alert(obj_data);
                if(obj_data2 != 'noData') {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('admin/account_search') }}/second/' + obj_data2,
                        success: function (data) {
                            var ln = data.length;
                            // var show_str = "<option value=''>-----</option>";
                            // alert(data.length + '筆資料');
                            for (i = 0; i < ln; i++) {
                                // show_str += "<option value="+data[i].user_level +">"+ data[i].user_level +"</option>";
console.log(data[i]);
                                $("#user_ajax_id").val(data[i].id);
                                $("#user_ajax_name").val(data[i].name);
                                $("#user_ajax_email").val(data[i].email);
                                $("#user_ajax_level").val(data[i].user_level);
                                $("#user_ajax_county").val(data[i].address_county);
                                $("#user_ajax_city").val(data[i].address_city);
                                $("#user_ajax_zip").val(data[i].address_zip);
                                $("#user_ajax_street").val(data[i].address_street);
                                // textarea
                                // if(show_str != '') show_str += '\r\n';
                                // show_str += data[i].email;
                            }
                            // textarea
                            // $('#user_ajax_result_textarea').val(show_str);
                            // 第二階下拉選單
                            // $("#user_ajax_result").empty();
                            // $("#user_ajax_user_level").append(show_str);
                            // alert('成功');
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                        }
                    });
                }else{
                    $("#user_ajax_email").val('');
                    // alert('請選擇會員名字');
                }
            });

            // 根據全台縣市連動帶出第二層鄉鎮市區下拉選單
            $('#address_county').on("select2:select",function (e){

                var obj_data_county = $(this).val();
                    $.ajax({
                        type: 'GET',
                        url: '{{ url('admin/add') }}/' + obj_data_county,
                        success: function (data) {
                            var show_str = "<option value=''>-----</option>";
                            // alert(data.length + '筆資料');
                            for (var i = 0; i < data.length; i++) {
                                // alert(data[i].address_zip);
                                show_str += "<option value=" + data[i].city + ">" + data[i].city + "</option>";
                            }
                            $("#address_city").empty();
                            $("#address_zip").val('');
                            $("#address_city").append(show_str);
                        },
                        error: function (xhr, status, error) {
                            alert('縣市失敗');
                            console.log(xhr);
                        }
                    });
            });

            // 根據所選鄉鎮市區撈郵遞區號
            $('#address_city').on("select2:select",function (e){

                var obj_data_city = $(this).val(); // city value
                var obj_data_county = $('#address_county').val();
                // alert(obj_data_county);
                // alert(obj_data_city);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('admin/add') }}/' + obj_data_county + '/' + obj_data_city,
                    success: function (data) {
                        // alert(data.length + '筆鄉鎮市區資料');
                        // for (var i = 0; i < data.length; i++) {
                        //     alert(data[0].address_zip);
                        // }
                        $("#address_zip").val(data[0].address_zip);
                    },
                    error: function (xhr, status, error) {
                        alert('鄉鎮市區失敗');
                        console.log(xhr);
                    }
                });
            });

            // 編輯頁所用 根據全台縣市連動帶出第二層鄉鎮市區下拉選單
            $('#update_address_county').on("select2:select",function (e){

                var obj_data_county = $(this).val();
                var update_id = $('#update_id').val();
                // alert(update_id);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('admin/edit') }}/' + update_id + '/' + obj_data_county,
                    success: function (data) {
                        var show_str = "<option value=''>-----</option>";
                        // alert(data.length + '筆資料');
                        for (var i = 0; i < data.length; i++) {
                            // alert(data[i].address_zip);
                            show_str += "<option value=" + data[i].city + ">" + data[i].city + "</option>";
                        }
                        $("#update_address_city").empty();
                        $("#update_address_zip").val('');
                        $("#update_address_city").append(show_str);
                    },
                    error: function (xhr, status, error) {
                        // alert('編輯頁縣市失敗');
                        console.log(xhr);
                    }
                });
            });

            // 編輯頁:根據所選鄉鎮市區撈郵遞區號
            $('#update_address_city').on("select2:select",function (e){

                var obj_data_county = $('#update_address_county').val();
                var obj_data_city = $(this).val();
                var update_id = $('#update_id').val();
                // alert(obj_data_county);
                // alert(obj_data_city);
                $.ajax({
                    type: 'GET',
                    url: '{{ url('admin/edit') }}/' + update_id + '/' + obj_data_county + '/' + obj_data_city,
                    success: function (data) {
                        // alert(data.length + '筆鄉鎮市區資料');
                        // for (var i = 0; i < data.length; i++) {
                        //     alert(data[0].address_zip);
                        // }
                        $("#update_address_zip").val(data[0].address_zip);
                    },
                    error: function (xhr, status, error) {
                        alert('鄉鎮市區失敗');
                        console.log(xhr);
                    }
                });
            });
        });

    </script>
</head>
<body>
    {{View::make('header')}}
    @yield('content')
    {{View::make('footer')}}
</body>
<style>
    .custom-login{
        height: 500px;
        padding-top: 100px;
    }
    /*輪播圖片,使每張大小不同的圖片高度一致*/
    img.slider-img{
        height: 400px !important;
    }
    /*讓footer能夠離產品資訊有點距離*/
    .custom-product{
        height: 600px;
    }
    .slider-text{
        background-color: #35443585 !important;
    }
    .trending-image{
        height: 100px;
    }
    .trending-item{
        float: left;
        width: 20%;
    }
    .trending-wrapper{
        margin: 30px;
    }
    .detail-img{
        height: 200px;
    }
    .search-box{
        width: 350px !important;
    }
    .cart-list-devider{
        border-bottom: 1px solid #ccc;
        margin-bottom: 20px;
        padding-bottom: 20px;
    }
    img{
        max-width:100%; /*不使用width:100% 是因避免圖片解析度不好，隨父元素被放大時會糊掉*/
        height:auto;
    }
    .page{
        margin: 5% 5% 2% 5%;

    }
</style>
</html>
