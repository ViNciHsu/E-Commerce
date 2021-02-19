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

        $(document).ready(function (){
            $('#update_user_level').select2();
            $('#origin_update_user_level').select2();
            $('#search_user_level').select2();

            $('#search_user_level').on("select2:select",function (e){
                var obj_data = $(this).val();
                // alert(obj_data);
                $.ajax({
                   type:'GET',
                   url:'{{ url('admin/account_search') }}/'+ obj_data,
                    success: function (data) {
                        var ln = data.length;
                        alert(data.length + '筆資料');
                        for (i = 0; i < ln; i++) {
                            $("input[name='description["+i+"]']").val(data[i].name);
                            $("input[name='description["+(i+1)+"]']").append( '<input type="text" id="description0" name="description['+(i+1)+']">').val(data[(i+1)].name);
                        }
                       // alert('成功');
                    },
                    error: function (xhr, status, error){
                       console.log(xhr);
                    }
                });
            });
        });

{{--        $(document).on('change', '#search_user_level', function(e){--}}
{{--        // $("#search_user_level").click(function(e){--}}
{{--            e.preventDefault();--}}
{{--            var search_user_level = $('#search_user_level :selected').val();//注意:selected前面有個空格！--}}
{{--            alert('search_user_level: '+ search_user_level);--}}
{{--            $.ajax({--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                },--}}
{{--                url: "{{ url('admin/account_search') }}",--}}
{{--                url: "{{ url('/admin/account_search_ajax') }}",--}}
{{--                method: "GET",--}}
{{--                dataType: "json",--}}
{{--                data: {--}}
{{--                    --}}{{--_token: '<?php echo csrf_token()?>',--}}
{{--                    // search_query傳到Controller--}}
{{--                    search_user_level: search_user_level--}}
{{--                },--}}
{{--                success: function (data) {--}}
{{--                    console.log(data.status);--}}
{{--                    alert($tmp);--}}
{{--                },--}}
{{--                error: function (xhr, type) {--}}
{{--                    alert('Ajax error!');--}}
{{--                    // alert(xhr,type);--}}
{{--                }--}}
{{--            })//end ajax--}}
{{--            });--}}
        // }
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
