<?php
use App\Http\Controllers\ProductController;
$cartItem = false;
if(ProductController::cartItem()>0)
{
    $cartItem = true;
}
?>
@extends('master')
@section('content')
    <div class="custom-product">
        <div class="col-sm-10">
            <div>
                <!-- 購物車未結之商品查詢 -->
                <form action="/cartlist" class="navbar-form navbar-left">
                    <div class="form-group">
                        <input name="cartlist_query" type="text" class="form-control search-box" placeholder="Cartlist Search" value="{{ old('cartlist_query' , Session::get('cartlist_query') ) }}">
                    </div>
                    <div class="form-group">
                        {{--                    <input type="text" name="query" value="{{ old(Session::get('query') , Session::get('query') ) }}" >--}}
                    </div>
                    <button type="submit" class="btn btn-outline-default"><i class="fa fa-search"></i> Cartlist&nbsp;Search</button>
                </form>
            </div>

            <br><br>

            <div class="trending-wrapper">
                <h4>Cartlist for Products</h4>
                @if($cartItem == true)
{{--                    <a class="btn btn-success" href="ordernow">Order Now</a>--}}
                @endif
                <br><br>

{{--                @foreach($products as $item)--}}
{{--                    <div class="row searched-item cart-list-devider">--}}
{{--                        <div class="col-sm-3">--}}
{{--                            <a href="detail/{{ $item->id }}">--}}
{{--                                <img class="trending-image" src="{{ $item->gallery }}">--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <h2>{{ $item->name }}</h2>--}}
{{--                            <h5>{{ $item->description }}</h5>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-3">--}}
{{--                            <a href="/removecart/{{ $item->cart_id }}" class="btn btn-danger">Remove to Cart</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}

                    @foreach($cartlist_search as $item)
                        <div class="row searched-item cart-list-devider">
                            <div class="col-sm-3">
                                <a href="detail/{{ $item->id }}">
                                    <img class="trending-image" src="{{ $item->gallery }}">
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <h2>{{ $item->name }}</h2>
                                <h5>{{ $item->description }}</h5>
                            </div>
                            <div class="col-sm-3">
                                <a href="/removecart/{{ $item->cart_id }}" class="btn btn-danger">Remove to Cart</a>
                            </div>
                        </div>
                    @endforeach
{{--                @endif--}}

                @if($cartItem == true)
{{--                    <a class="btn btn-success" href="ordernow">Order Now</a>--}}
                @endif
                <br><br>
            </div>
        </div>
    </div>
@endsection
