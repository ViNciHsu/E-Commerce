@extends('master')
@section('content')
    <div class="custom-product">
        <div class="col-sm-10">
            <div class="trending-wrapper">
                <h2>My Orders</h2>
                <div class="d-flex justify-content-end mb-4 cart-list-devider">
                    <a class="btn btn-danger" href="{{ URL::to('myorders/export_to_pdf') }}">Export to PDF</a>
                    &nbsp;&nbsp;&nbsp;
                    <a class="btn btn-success" href="{{ URL::to('myorders/export_to_excel') }}">Export to Excel</a>

{{--                    <a class="btn btn-info" href="{{ URL::to('myorders/test_page') }}">test_page to Excel</a>--}}
                </div>
                <br>
                @foreach($orders as $item)
                    <div class="row searched-item cart-list-devider">
                        <div class="col-sm-3">
                            <a href="detail/{{ $item->id }}">
                                <img class="trending-image img-rounded img-responsive" src="{{ $item->gallery }}" alt="" width="120" height="50" >
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <div class="">
                                <p>Product Name：{{ $item->name }}</p>
                                <p>Order Number：{{ $item->order_number }}</p>
                                <p>Product Price：$ {{ $item->price }}</p>
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
@endsection
