<!doctype html>
<html lang="en">
<head>
    {{--    <meta charset="UTF-8">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Commerce Project</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="assets/https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- console 會報錯，因為也要放 jQuery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="sweetalert2.all.min.js"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <!-- use-font-awesome-icons-in-laravel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css"/>
    <script>
        // var uri = window.location.href.split(/\?|#/)[0];
        // // var uri = window.location.pathname;
        // alert(uri);
        // // Returns http://example.com/something
        //
        // var hash = window.location.hash;
        // alert(hash);
        // Returns #hash
    </script>
</head>
<body>
{{--<nav class="navbar navbar-default">--}}
{{--    <div class="container-fluid">--}}
{{--        <!-- Brand and toggle get grouped for better mobile display -->--}}
{{--        <div class="navbar-header">--}}
{{--            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">--}}
{{--                <span class="sr-only">Toggle navigation</span>--}}
{{--                <span class="icon-bar"></span>--}}
{{--                <span class="icon-bar"></span>--}}
{{--                <span class="icon-bar"></span>--}}
{{--            </button>--}}
{{--            <a class="navbar-brand" href="/">E-Comm</a>--}}
{{--        </div>--}}

{{--        <!-- Collect the nav links, forms, and other content for toggling -->--}}
{{--        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">--}}
{{--            <ul class="nav navbar-nav">--}}
{{--                <li class="active"><a href="/">Home</a></li>--}}
{{--                <li class=""><a href="/myorders">Orders</a></li>--}}
{{--            </ul>--}}
{{--            <form action="/search" class="navbar-form navbar-left">--}}
{{--                <div class="form-group">--}}
{{--                    <input name="query" type="text" class="form-control search-box" placeholder="Search" value="">--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}

{{--                </div>--}}
{{--                <button type="submit" class="btn btn-outline-default"><i class="fa fa-search"></i>&nbsp;Search</button>--}}
{{--            </form>--}}
{{--            <ul class="nav navbar-nav navbar-right">--}}
{{--                <li><a href="/cartlist"><i class="fa fa-shopping-cart">&nbsp;</i>Cart(0)</a></li>--}}
{{--                <li class="dropdown">--}}
{{--                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user">&nbsp;</i>Admin--}}
{{--                        <span class="caret"></span></a>--}}
{{--                    <ul class="dropdown-menu">--}}
{{--                        <li><a href="/admin/list"><i class="fa fa-sign-out"></i>Admin Panel</a></li>--}}
{{--                        <li><a href="/logout"><i class="fa fa-sign-out"></i>Logout</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div><!-- /.navbar-collapse -->--}}
{{--    </div><!-- /.container-fluid -->--}}
{{--</nav>--}}

<div class="custom-product">
    <div class="col-sm-10">
        <div class="trending-wrapper">
            {{--            <h2>My Orders</h2>--}}
            {{--            <div class="d-flex justify-content-end mb-4">--}}
            {{--                <a class="btn btn-primary" href="http://127.0.0.1:8000/myorders/export_to_pdf">Export to PDF</a>--}}
            {{--            </div>--}}
            {{--            <br>--}}
{{--            <img src="{{ $str }}" alt="">--}}
            @foreach($orders as $item)
                <div class="row searched-item cart-list-devider">
                    <div class="col-sm-3">
                        <a href="detail/{{ $item->id }}">
                            <img class="trending-image img-rounded img-responsive" src="{{ $item->gallery }}" alt=""
                                 width="120" height="80">
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="">
                            {{-- 目前發現只有<p>搭配msyh才能顯示中文 --}}
                            <p>Product Name：{{ $item->name }}</p>
                            <p>Order Number：{{ $item->order_number }}</p>
                            <p>Delivery Status：{{ $item->status }}</p>
                            <p>Address：{{ $item->address }}</p>
                            <p>Payment Status：{{ $item->payment_status }}</p>
                            <p>Payment Method：{{ $item->payment_method }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
{{--<div style="clear: both" class="panel panel-default">--}}
{{--    <div class="panel-body">--}}
{{--        Panel content--}}
{{--    </div>--}}
{{--    <div class="panel-footer">Panel footer</div>--}}
{{--</div>--}}
</body>
<style>
    /*@font-face {*/
    /*    font-family: 'msyh';*/
    /*    font-style: normal;*/
    /*    font-weight: normal;*/
    /*    src: url('storage/fonts/msyh.ttf') format('truetype');*/
    /*}*/

    body {
        font-family: msyh, DejaVu Sans, sans-serif;
    }

    .custom-login {
        height: 500px;
        padding-top: 100px;
    }

    /*輪播圖片,使每張大小不同的圖片高度一致*/
    img.slider-img {
        height: 400px !important;
    }

    /*讓footer能夠離產品資訊有點距離*/
    .custom-product {
        height: 600px;
    }

    .slider-text {
        background-color: #35443585 !important;
    }

    .trending-image {
        height: 100px;
    }

    .trending-item {
        float: left;
        width: 20%;
    }

    .trending-wrapper {
        margin: 30px;
    }

    .detail-img {
        height: 200px;
    }

    .search-box {
        width: 350px !important;
    }

    .cart-list-devider {
        border-bottom: 1px solid #ccc;
        margin-bottom: 20px;
        padding-bottom: 20px;
    }

    img {
        max-width: 100%; /*不使用width:100% 是因避免圖片解析度不好，隨父元素被放大時會糊掉*/
        height: auto;
    }
</style>
</html>
