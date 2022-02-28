@extends('admin.layouts.app')
@section('title','Edit Transfer')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Transfer #{{$transfer->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transfer Add</li>
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
                    <form method="post" action="{{route('admin.transfers.edit.update',$transfer->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>Source Warehouse</label>
                            <input type="hidden" name="old_source_warehouse_id"
                                value="{{$transfer->source_warehouse_id}}">
                            <select id="source_warehouse" name="source_warehouse_id" class="form-control select2">
                                @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}" @if ($warehouse->id ==
                                    $transfer->source_warehouse_id)
                                    selected
                                    @endif>{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Destination Warehouse</label>
                            <input type="hidden" name="old_dest_warehouse_id" value="{{$transfer->dest_warehouse_id}}">
                            <select id="dest_warehouse" name="dest_warehouse_id" class="form-control select2">
                                @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}" @if ($warehouse->id ==
                                    $transfer->dest_warehouse_id)
                                    selected
                                    @endif>{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <input type="hidden" name="old_product_id" value="{{$transfer->product_id}}">
                            <select id="product" name="product_id" class="form-control select2">
                                @foreach($products as $product)
                                <option value="{{$product->id}}" @if ($product->id == $transfer->product_id) selected
                                    @endif>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputQuantity">Quantity</label>
                            <input type="hidden" name="old_quantity" value="{{$transfer->quantity}}">
                            <input type="number" id="inputProductID" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror"
                                value="{{old('quantity', $transfer->quantity)}}">
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputNote">Note</label>
                            <textarea id="inputNote" name="description"
                                class="form-control @error('note') is-invalid @enderror"
                                row="4">{{old('note', $transfer->note)}}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.transfers.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Edit Transfer" class="btn btn-success float-right">
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