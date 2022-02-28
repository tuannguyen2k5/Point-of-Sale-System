@extends('admin.layouts.app')
@section('title','Create a new Tax')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tax Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Tax Add</li>
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
                    <h3 class="card-title">Create</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.tax_rate.create.store')}}">
                        @csrf
                        <div class="form-group">
                            <label for="inputName">Tax Name</label>
                            <input type="text" id="inputTaxName" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{old('name', $tax->name ?? '')}}">
                            @error('group_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputTaxID">Tax ID</label>
                            <input type="text" id="inputTaxID" name="customer_id"
                                class="form-control @error('id') is-invalid @enderror"
                                value="{{old('id', $tax->id ?? '')}}">
                            @error('id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{old('description', $tax->description ?? '')}}" row="4"></textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.tax_rate.index')}}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Create New Tax" class="btn btn-success float-right">
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop