@extends('admin.layouts.app')
@section('title','View Purchase')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$purchase->title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Purchase</li>
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
                        <div><strong>Warehouse</strong></div>
                        <div>{{$purchase->warehouse}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Supplier</strong></div>
                        <div>{{$supplier->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Product</strong></div>
                        <div>{{$product->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Quantity</strong></div>
                        <div>{{$purchase->quantity}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Price</strong></div>
                        <div>{{$purchase->price}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Purchased Date</strong></div>
                        <div>{{$purchase->purchased_date}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Note</strong></div>
                        <div>{{$purchase->note}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if ($purchase->payment_id)
                            <a href="{{route('admin.purchase-payments.view', $purchase->payment_id)}}"
                                class="btn btn-success">Follow Purchase
                                Payment</a>
                            @else
                            <form method="post" action="{{route('admin.purchase-payments.create.store')}}"
                                class="d-inline-block">
                                @csrf
                                <input type="hidden" name="purchase_id" id="purchase_id" value="{{$purchase->id}}">
                                <input type="submit" class="btn btn-primary" value="Create Purchase Payment">
                            </form>
                            @endif
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
            <a href="{{route('admin.purchases.index')}}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop