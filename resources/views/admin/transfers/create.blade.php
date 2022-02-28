@extends('admin.layouts.app')
@section('title','Create a new Transfer')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Transfer Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Transfer Add</li>
                </ol>
            </div>
        </div>
        @if (session()->has('warning'))
        <div class="alert alert-warning alert-dismissible fade show w-100" role="alert">
            <div>{{session('warning')}}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create Form</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.transfers.create.store')}}">
                        @csrf
                        <div class="form-group">
                            <label>Source Warehouse</label>
                            <select id="source_warehouse" name="source_warehouse_id" class="form-control select2">
                                @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                            @error('source_warehouse_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Destination Warehouse</label>
                            <select id="dest_warehouse" name="dest_warehouse_id" class="form-control select2">
                                @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                            @error('dest_warehouse_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <select id="product" name="product_id" class="form-control select2">
                                @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputQuantity">Quantity</label>
                            <input type="number" id="inputQuantity" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror"
                                value="{{old('quantity', 1)}}">
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputNote">Note</label>
                            <textarea id="inputNote" name="note"
                                class="form-control @error('note') is-invalid @enderror"
                                row="4">{{old('note', '')}}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.transfers.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Create New Transfer" class="btn btn-success float-right">
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