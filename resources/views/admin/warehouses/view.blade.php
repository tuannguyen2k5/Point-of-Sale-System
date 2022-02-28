@extends('admin.layouts.app')
@section('title','View WareHouse:'.$warehouse->name)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$warehouse->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$warehouse->name}}</li>
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
                        <div><strong>Name</strong></div>
                        <div>{{$warehouse->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Address</strong></div>
                        <div>{{$warehouse->address}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Description</strong></div>
                        <div>{{$warehouse->description}}</div>
                    </div>
                    <div class="form-group">
                        <label><b>List of product</b></label>
                        <table id="dynamic-product-list" class="w-100 table table-bordered">
                            <tr>
                                <th style="width: 75%">Product</th>
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
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.warehouses.index')}}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop