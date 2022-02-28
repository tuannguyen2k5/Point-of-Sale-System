@extends('admin.layouts.app')
@section('title','Edit Category'. $category->name)
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$category->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$category->name}}</li>
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
                    <form method="post" action="{{route('admin.categories.edit.update',$category->id)}}"
                        enctype='multipart/form-data'>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="inputName" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{old('name', $category->name ?? '')}}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Parent</label>
                            <select id="parent_id" name="parent_id" class="form-control select2">
                                @foreach($categories as $item)
                                <option value="{{$item->id}}" @if ($item->id == $category->parent_id) selected
                                    @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tax</label>
                            <select id="tax_id" name="tax_id" class="form-control select2">
                                @foreach($tax_rates as $tax_rate)
                                <option value="{{$tax_rate->id}}" @if ($tax_rate->id == $category->tax_id) selected
                                    @endif>{{$tax_rate->name}} : {{$tax_rate->value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Facebook Category</label>
                            <select id="facebook_category_id" name="facebook_category_id" class="form-control select2">
                                @foreach($facebook_categories as $facebook_category)
                                <option value="{{$facebook_category->category_id}}" @if ($facebook_category->id ==
                                    $category->facebook_category_id) selected
                                    @endif>{{$facebook_category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Google Category</label>
                            <select id="google_category_id" name="google_category_id" class="form-control select2">
                                @foreach($google_categories as $google_category)
                                <option value="{{$google_category->category_id}}" @if ($google_category->id ==
                                    $category->google_category_id) selected
                                    @endif>{{$google_category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                row="4">{{old('description', $category->description ?? '')}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.categories.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Edit category" class="btn btn-success float-right">
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
            format: 'DD/MM/YYYY',
        });
    })
</script>
@stop