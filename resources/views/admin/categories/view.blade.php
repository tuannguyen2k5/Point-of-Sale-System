@extends('admin.layouts.app')
@section('title','View Category:' . $category->name)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">View Category {{$category->name}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Category {{$category->name}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div><strong>Name</strong></div>
                            <div>{{$category->name}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Parent</strong></div>
                            <div>{{$category->parent}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Tax</strong></div>
                            <div>{{$tax_rate->name}} : {{$tax_rate->value}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Facebook Category</strong></div>
                            <div>{{$category->facebook_category}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Google Category</strong></div>
                            <div>{{$category->google_category}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Description</strong></div>
                            <div>{{$category->description}}</div>
                        </div>
                        <div class="form-group">
                            <form method="post" action="{{route('admin.categories.google-export')}}">
                                @csrf
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <input type="submit" class="btn btn-danger" value="Export XML for Google">
                            </form>
                        </div>
                        <div class="form-group">
                            <form method="post" action="{{route('admin.categories.facebook-export')}}">
                                @csrf
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <input type="submit" class="btn btn-danger" value="Export XML for Facebook">
                            </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{route('admin.categories.index')}}" class="btn btn-secondary">Back</a>
                <a href="{{route('admin.categories.edit', $category->id)}}" class="btn btn-primary">Edit Category</a>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@stop