@extends('admin.layouts.app')
@section('title','View Biller')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View {{$biller->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Biller</li>
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
                        <div><strong>Store</strong></div>
                        <div>{{$biller->store}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Name</strong></div>
                        <div>{{$biller->name}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Address</strong></div>
                        <div>{{$biller->address}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Phone</strong></div>
                        <div>{{$biller->phone}}</div>
                    </div>
                    <div class="form-group">
                        <div><strong>Email</strong></div>
                        <div>{{$biller->email}}</div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.billers.index')}}" class="btn btn-secondary">Back</a>
            <a href="{{route('admin.billers.edit', $biller->id)}}" class="btn btn-primary">Edit Biller</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop