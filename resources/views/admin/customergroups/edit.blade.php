@extends('admin.layouts.app')
@section('title','Edit Customer Group: '.$customergroup->group_name)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$customergroup->group_name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$customergroup->group_name}}</li>
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
                    <form method="post" action="{{route('admin.customergroups.edit.update',$customergroup->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputName">Group Name</label>
                            <input type="text" id="inputName" name="group_name"
                                class="form-control @error('group_name') is-invalid @enderror"
                                value="{{old('group_name', $customergroup->group_name ?? '')}}">
                            @error('group_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                row="4">{{$customergroup->description ?? ''}}</textarea>
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
            <a href="{{route('admin.customergroups.index')}}" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Edit Customergroup" class="btn btn-success float-right">
        </div>
    </div>
    </form>
</section>
<!-- /.content -->
@stop