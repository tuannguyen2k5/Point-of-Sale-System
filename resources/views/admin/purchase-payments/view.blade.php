@extends('admin.layouts.app')
@section('title','View Purchase Payment')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Purchase Payment #{{$purchase_payment->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Purchase Payment</li>
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
                                <div><strong>Warehouse</strong></div>
                                <div>{{$purchase_payment->warehouse}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Supplier</strong></div>
                                <div>{{$purchase_payment->supplier}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Price</strong></div>
                                <div>{{$purchase_payment->price}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Payment Type</strong></div>
                                <div>{{$purchase_payment->type}}</div>
                            </div>
                            <div class="form-group">
                                <div><strong>Complete</strong></div>
                                <div>{{$purchase_payment->payment_status}}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div><strong>Validate Photo</strong></div>
                                <div>
                                    @if($purchase_payment->validate_photo)
                                    <img class="img-thumbnail" width="400px"
                                        src="{{asset($purchase_payment->validate_photo)}}"
                                        alt="{{$purchase_payment->id}}">
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
            <a href="{{route('admin.purchase-payments.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.purchase-payments.edit', $purchase_payment->id)}}" class="btn btn-primary">Edit This
                Purchase Payment</a>
            <a href="{{route('admin.purchases.view', $purchase_payment->purchase_id)}}" class="btn btn-success">View
                Purchase</a>
        </div>
    </div>
</section>
<!-- /.content -->
@stop