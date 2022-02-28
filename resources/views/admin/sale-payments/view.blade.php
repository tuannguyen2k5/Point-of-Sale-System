@extends('admin.layouts.app')
@section('title','View Sale Payment')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Sale Payment #{{$sale_payment->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Sale Payment</li>
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
                                <div>{{$sale_payment->customer}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Price</strong></div>
                                <div>{{$sale_payment->price}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Payment Type</strong></div>
                                <div>{{$sale_payment->type}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Complete</strong></div>
                                <div>{{$sale_payment->payment_status}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div><strong>Validate Photo</strong></div>
                                <div>
                                    @if($sale_payment->validate_photo)
                                    <img class="img-thumbnail" width="400px"
                                        src="{{asset($sale_payment->validate_photo)}}" alt="{{$sale_payment->id}}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.sale-payments.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.sale-payments.edit', $sale_payment->id)}}" class="btn btn-primary">Edit This Sale
                Payment</a>
            <a href="{{route('admin.sales.view', $sale_payment->sale_id)}}" class="btn btn-success">View Sale</a>
        </div>
    </div>
</section>
<!-- /.content -->
@stop