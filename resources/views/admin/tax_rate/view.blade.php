@extends('admin.layouts.app')
@section('title','View tax:' . $tax->name)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$tax->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$tax->name}}</li>
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
                            <div><strong> Name</strong></div>
                            <div>{{$tax->name}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Tax ID</strong></div>
                            <div>{{$tax->id}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Value</strong></div>
                            <div>{{$tax->value}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Description</strong></div>
                            <div>{{$tax->description}}</div>
                        </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('admin.tax_rate.index')}}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop