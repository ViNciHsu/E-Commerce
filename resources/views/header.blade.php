<?php
use App\Http\Controllers\ProductController;
$total = 0;
if(Session::has('user'))
{
    $total = ProductController::cartItem();
}

//$session_user_email = UserController::admin();
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">E-Comm</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                <li class=""><a href="/myorders">Orders</a></li>
            </ul>
            <form action="/search" class="navbar-form navbar-left">
                <div class="form-group">
                    <input name="query" type="text" class="form-control search-box" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-outline-default"><i class="fa fa-search"></i>&nbsp;Search</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                @if(Session::has('user'))
                    <li><a href="/cartlist"><i class="fa fa-shopping-cart">&nbsp;</i>Cart({{ $total }})</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user">&nbsp;</i>{{ Session::get('user')['name'] }}
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Session::get('user')['email'] == "admin@gmail.com")
                                <li><a href="/admin/list"><i class="fa fa-sign-out"></i>Admin Panel</a></li>
                            @endif
                            <li><a href="/logout"><i class="fa fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="/login"><i class="fa fa-sign-in"></i>Login</a></li>
                    <li><a href="/register">Register</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
