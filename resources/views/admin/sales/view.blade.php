@extends('admin.layouts.app')
@section('title','View Sale')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Sale #{{$sale->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Sale</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div><strong>Customer</strong></div>
                                <div>{{$customer->name}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Total Price</strong></div>
                                <div>{{$sale->price}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div><strong>Order Date</strong></div>
                                <div>{{$sale->order_date}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Shipping Fee</strong></div>
                                <div>{{$sale->shipping_fee}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label><b>List of product</b></label>
                        <table id="dynamic-product-list" class="w-100 table table-bordered">
                            <tr>
                                <th style="width: 50%">Product</th>
                                <th style="width: 25%">Quantity</th>
                            </tr>
                            @foreach ($product_list as $item)
                            <tr>
                                <td>
                                    @foreach($products as $product)
                                    @if ($product->id == $item->product_id) {{$product->name}} @endif
                                    @endforeach
                                </td>
                                <td>{{$item->quantity}}</td>
                            </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                @if ($sale->payment_id)
                                <a href="{{route('admin.sale-payments.view', $sale->payment_id)}}"
                                    class="btn btn-success">Follow Sale Payment</a>
                                @else
                                <form method="post" action="{{route('admin.sale-payments.create.store')}}"
                                    class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="sale_id" id="sale_id" value="{{$sale->id}}">
                                    <input type="submit" class="btn btn-primary" value="Create Sale Payment">
                                </form>
                                @endif

                                @if ($sale->delivery_id)
                                <a href="{{route('admin.deliveries.view', $sale->delivery_id)}}"
                                    class="btn btn-success">Follow
                                    Delivery</a>
                                @else
                                <form method="post" action="{{route('admin.deliveries.create.store')}}"
                                    class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="sale_id" id="sale_id" value="{{$sale->id}}">
                                    <input type="submit" class="btn btn-primary" value="Create Delivery">
                                </form>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div><strong>Note</strong></div>
                            <div>{{$sale->note}}</div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{route('admin.sales.index')}}" class="btn btn-secondary">Back</a>
                <a href="{{route('admin.sales.edit', $sale->id)}}" class="btn btn-primary">Edit Sale</a>
            </div>
        </div>
</section>
<!-- /.content -->
@stop