@extends('admin.layouts.app')
@section('title','View Return Sale')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Return Sale #{{$return_sale->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Return Sale</li>
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
                    <div class="form-group">
                        <div><strong>Sale ID</strong></div>
                        <div>{{$return_sale->sale_id}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Customer</strong></div>
                        <div>{{$customer->name}}</div>
                    </div>
                    <div class="form-group">
                        <label><b>List of old product</b></label>
                        <table id="dynamic-product-list" class="w-100 table table-bordered">
                            <tr>
                                <th style="width: 75%">Product</th>
                                <th style="width: 25%">Quantity</th>
                            </tr>
                            @foreach ($old_product_list as $item)
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
                    </div>
                    <div class="form-group">
                        <label><b>List of new product</b></label>
                        <table id="dynamic-product-list" class="w-100 table table-bordered">
                            <tr>
                                <th style="width: 75%">Product</th>
                                <th style="width: 25%">Quantity</th>
                            </tr>
                            @foreach ($new_product_list as $item)
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
                    </div>
                    <div class="form-group">
                        <div><strong>Note</strong></div>
                        <div>{{$return_sale->note}}</div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.return-sales.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.return-sales.edit', $return_sale->id)}}" class="btn btn-primary">Edit Return
                Sale</a>
        </div>
    </div>
</section>
<!-- /.content -->
@stop