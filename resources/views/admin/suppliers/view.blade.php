@extends('admin.layouts.app')
@section('title','View Supplier')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View {{$supplier->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Supplier</li>
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
                        <div><strong>Name</strong></div>
                        <div>{{$supplier->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Address</strong></div>
                        <div>{{$supplier->address}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Phone</strong></div>
                        <div>{{$supplier->phone}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Email</strong></div>
                        <div>{{$supplier->email}}</div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.suppliers.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.suppliers.edit', $supplier->id)}}" class="btn btn-primary">Edit Supplier</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop