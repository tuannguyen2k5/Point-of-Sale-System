@extends('admin.layouts.app')
@section('title','View Quotation:')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Quotation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Quotation</li>
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
                            <div><strong>Product ID</strong></div>
                            <div>{{$quotation->product_id}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Price</strong></div>
                            <div>{{$quotation->price}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Discount</strong></div>
                            <div>{{$quotation->discount}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Month</strong></div>
                            <div>{{$quotation->month}}</div>
                        </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.quotations.index')}}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop