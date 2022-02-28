@extends('admin.layouts.app')
@section('title','Edit Product:'.$product->name)
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
                    <h3 class="card-title">Edit</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.products.edit.update',$product->id)}}"
                        enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="inputName" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{old('name', $product->name ?? '')}}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPrice">Price</label>
                            <input type="text" id="inputPrice" name="price"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{old('price', $product->price ?? '')}}">
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputQuantity">Quantity</label>
                            <input type="text" id="inputQuantity" name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror"
                                value="{{old('quantity', $product->quantity ?? '')}}">
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label> Brand</label>
                            <select id="brand_id" name="brand_id" class="form-control select2" style="width: 100%;">
                                @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Expired date</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" id="expired_date" name="expired_date"
                                    class="form-control datetimepicker-input @error('expired_date') is-invalid @enderror"
                                    data-target="#reservationdate"
                                    value="{{old('expired_date', $product->expired_date ?? '')}}" />
                                <div class="input-group-append" data-target="#reservationdate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('expired_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label> Unit</label>
                            <select id="unit_id" name="unit_id" class="form-control select2">
                                @foreach($units as $unit)
                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputBarcode">Barcode</label>
                            <input type="text" id="inputBarcode" name="barcode"
                                class="form-control @error('barcode') is-invalid @enderror"
                                value="{{old('barcode', $product->barcode ?? '')}}">
                            @error('barcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label> Type</label>
                            <select id="type" name="type" class="form-control select2">
                                <option value="standard" selected="selected">Standard</option>
                                <option value="digital">Digital</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputCategoryID">Category ID</label>
                            <input type="text" id="inputCategoryID" name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror"
                                value="{{old('category_id', $product->category_id ?? '')}}">
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputCreatedBy">Create by</label>
                            <input type="text" id="inputCreatedBy" name="created_by"
                                class="form-control @error('created_by') is-invalid @enderror"
                                value="{{old('created_by', $product->created_by ?? '')}}">
                            @error('created_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{old('description', $price->description ?? '')}}" row="4"></textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <fieldset class="form-group">
                            <legend class="col-form-label col-sm-2 pt-0"><strong>Published</strong></legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="published" id="published1"
                                        value="1" checked>
                                    <label class="form-check-label" for="published1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="published" id="published0"
                                        value="0">
                                    <label class="form-check-label" for="published0">
                                        No
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo"
                                    name="photo">
                                @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
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
            <a href="{{route('admin.products.index')}}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Edit" class="btn btn-success float-right">
        </div>
    </div>
    </form>
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
            format: 'DD/MM/YYYY',
        });
    })
</script>
@stop