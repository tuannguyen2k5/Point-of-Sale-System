@extends('admin.layouts.app')
@section('title','View Transfer')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Transfer #{{$transfer->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Transfer</li>
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
                    <h3 class="card-title">Transfer #{{$transfer->id}}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div><strong>Source Warehouse</strong></div>
                        <div>{{$source_warehouse->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Destination Warehouse</strong></div>
                        <div>{{$dest_warehouse->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Product</strong></div>
                        <div>{{$product->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Quantity</strong></div>
                        <div>{{$transfer->quantity}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Note</strong></div>
                        <div>{{$transfer->note}}</div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.transfers.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.transfers.edit', $transfer->id)}}" class="btn btn-primary">Edit Transfer</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop