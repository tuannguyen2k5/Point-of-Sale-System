@extends('admin.layouts.app')
@section('title','Edit Purchase')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Purchase</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Purchase</li>
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
                    <h3 class="card-title">Purchase #{{$purchase->id}}</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.purchases.edit.update',$purchase->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>Warehouse</label>
                            <input type="hidden" name="old_warehouse_id" value="{{$purchase->warehouse_id}}">
                            <select id="warehouse" name="warehouse_id" class="form-control select2">
                                @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}" @if ($warehouse->id == $purchase->warehouse_id)
                                    selected
                                    @endif>{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <select id="supplier" name="supplier_id" class="form-control select2">
                                @foreach($suppliers as $supplier)
                                <option value="{{$supplier->id}}" @if ($supplier->id == $purchase->supplier_id) selected
                                    @endif>{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <input type="hidden" name="old_product_id" value="{{$purchase->product_id}}">
                            <select id="product" name="product_id" class="form-control select2">
                                @foreach($products as $product)
                                <option value="{{$product->id}}" @if ($product->id == $purchase->product_id) selected
                                    @endif>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputQuantity">Quantity</label>
                            <input type="hidden" name="old_quantity" value="{{$purchase->quantity}}">
                            <input type="text" id="inputQuantity" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror"
                                value="{{old('quantity', $purchase->quantity ?? '')}}">
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPrice">Price</label>
                            <input type="text" id="inputPrice" name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{old('price', $purchase->price ?? '')}}">
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Purchased date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" id="purchased_date" name="purchased_date"
                                    class="form-control datetimepicker-input @error('purchased_date') is-invalid @enderror"
                                    data-target="#reservationdate"
                                    value="{{old('purchased_date', $purchase->purchased_date ?? '' )}}" />
                                <div class="input-group-append" data-target="#reservationdate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('purchased_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputNote">Note</label>
                            <textarea id="inputNote" name="note"
                                class="form-control @error('note') is-invalid @enderror"
                                row="4">{{old('note', $purchase->note ?? '')}}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.purchases.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Edit Purchase" class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<!-- /.content -->
@stop

@section('css')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

@stop
@section('js')
<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD',
        });
    })
</script>
@stop