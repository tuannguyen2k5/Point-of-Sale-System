@extends('admin.layouts.app')
@section('title','Create a new Category')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Category Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Category Add</li>
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
                    <form method="post" action="{{route('admin.categories.create.store')}}"
                        enctype='multipart/form-data'>
                        @csrf
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
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tax</label>
                            <select id="tax_id" name="tax_id" class="form-control select2">
                                @foreach($tax_rates as $tax_rate)
                                <option value="{{$tax_rate->id}}">{{$tax_rate->name}} : {{$tax_rate->value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Facebook Category</label>
                            <select id="facebook_category_id" name="facebook_category_id" class="form-control select2">
                                @foreach($facebook_categories as $facebook_category)
                                <option value="{{$facebook_category->category_id}}">
                                    {{$facebook_category->category_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Google Category</label>
                            <select id="google_category_id" name="google_category_id" class="form-control select2">
                                @foreach($google_categories as $google_category)
                                <option value="{{$google_category->category_id}}">{{$google_category->category_name}}
                                </option>
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
                                <input type="submit" value="Create New category" class="btn btn-success float-right">
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