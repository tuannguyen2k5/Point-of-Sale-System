@extends('admin.layouts.app')
@section('title','View Delivery')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Delivery #{{$delivery->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Delivery</li>
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
                            <div><strong>Customer</strong></div>
                            <div>{{$delivery->customer}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Address</strong></div>
                            <div>{{$delivery->address}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Received Money</strong></div>
                            <div>{{$delivery->received_money}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Status</strong></div>
                            <div>{{$delivery->status}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Note</strong></div>
                            <div>{{$delivery->note}}</div>
                        </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.deliveries.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.deliveries.edit', $delivery->id)}}" class="btn btn-primary">Edit This Delivery</a>
            <a href="{{route('admin.sales.view', $delivery->sale_id)}}" class="btn btn-success">View Sale</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop