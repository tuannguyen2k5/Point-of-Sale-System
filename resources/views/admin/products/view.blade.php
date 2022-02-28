@extends('admin.layouts.app')
@section('title','View Product:' . $product->name)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$product->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$product->name}}</li>
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
                    <form>
                        <div class="form-group">
                            <div><strong>Name</strong></div>
                            <div>{{$product->name}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Price</strong></div>
                            <div>{{$product->price}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Quantity</strong></div>
                            <div>{{$product->quantity}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Brand</strong></div>
                            <div>{{$product->brand->name}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Expired date</strong></div>
                            <div>{{$product->expired_date}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Unit</strong></div>
                            <div>{{$product->unit->name}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Barcode</strong></div>

                            {!! DNS1D::getBarcodeHTML($product->barcode, "C128",1.4,22) !!}

                        </div>
                        <div class="form-group">
                            <div><strong>Type</strong></div>
                            <div>{{$product->type}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Category</strong></div>
                            <div>{{$product->category->name}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Created by</strong></div>
                            <div>{{$product->created_by}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Photo</strong></div>
                            <div>
                                @if($product->photo)
                                <img class="img-thumbnail" width="120px" src="{{asset($product->photo)}}"
                                    alt="{{$product->name}}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div><strong>Description</strong></div>
                            <div>{{$product->description}}</div>
                        </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.products.index')}}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop