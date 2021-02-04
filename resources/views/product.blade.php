@extends('master')
@section('content')
    <div class="custom-product">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($products as $key => $item)
                    <li data-target="#myCarousel" data-slide-to="{{ $item->id -1 }}" class="{{ $item->id == $loop->index ?'active':''}}">
                    </li>
                @endforeach

{{--                                <li data-target="#myCarousel" data-slide-to="1"></li>--}}
{{--                                <li data-target="#myCarousel" data-slide-to="2"></li>--}}
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @foreach($products as $key => $item)
                    <div class="item {{ ($key) % 4 == 0 ?'active':''}}">
                        <a href="detail/{{ $item->id }}">
                            <img class="slider-img" src="{{ $item->gallery }}">
                            <div class="carousel-caption slider-text">
                                <h3>{{ $item->name }}</h3>
                                <p>{{ $item->description }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="container">
            <div class="row">
                <div class="trending-wrapper">
                    <h3>Trending Products</h3>
                    @foreach($products as $item)
                        <div class="trending-item col-12 col-md-6 col-lg-4">
                            <a href="detail/{{ $item->id }}">
                                <img class="trending-image img-rounded img-responsive" src="{{ $item->gallery }}" alt="" width="120" height="50">
                                <div class="col-sm-6 col-md-3">
                                    <h3>{{ $item->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
{{--    {{ $products->links() }}--}}
    <div class="container">
{{--        <div class="row">--}}
            <div class="page">
                {{ $products->links() }}
            </div>
{{--        </div>--}}
    </div>
@endsection
