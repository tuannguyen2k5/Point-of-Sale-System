@extends('admin.layouts.app')
@section('title','Change Site Settings')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Change Site Setting</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Change Site Settings</li>
                </ol>
            </div>
        </div>
        @if (session()->has('warning'))
        <div class="alert alert-warning alert-dismissible fade show w-100" role="alert">
            <div>{{session('warning')}}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
            <div>{{session('success')}}</div>
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
                    <h3 class="card-title">Site Setting</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.site-settings.edit.update')}}"
                        enctype='multipart/form-data'>
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="inputTitle">Site Title</label>
                            <input type="text" id="inputTitle" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{old('title', $site_setting->title ?? '')}}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="logo" class="col-form-label">Logo</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="old_logo" value="{{$site_setting->logo}}">
                                <input class="form-control @error('logo') is-invalid @enderror" type="file" id="logo"
                                    name="logo" value="{{$site_setting->logo}}">
                                @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="photo-preview">
                            <img id="preview-image-before-upload" src="{{asset($site_setting->logo)}}"
                                alt="preview image" style="max-height: 250px;">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.dashboard')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Change Site Settings" class="btn btn-success float-right">
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
            format: 'YYYY-MM-DD',
        });
        if($(this).find(":selected").val() == 1) {
        $('#logo').prop('disabled', true);
        }
    })

    $('#payment-type').change(function () {
        if($(this).find(":selected").val() == 1) {
            $('#logo').prop('disabled', true);
        } else {
            $('#logo').prop('disabled', false);
        }
    })

    $(document).ready(function (e) {
        $('#logo').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@stop