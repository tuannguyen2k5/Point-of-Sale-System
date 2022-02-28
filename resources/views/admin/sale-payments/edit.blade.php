@extends('admin.layouts.app')
@section('title','Edit Sale Payment')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sale Payment #{{$sale_payment->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Sale Payment</li>
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
                    <h3 class="card-title">Sale Payment #{{$sale_payment->id}}</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.sale-payments.edit.update',$sale_payment->id)}}"
                        enctype='multipart/form-data'>
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div><strong>Customer</strong></div>
                                    <div>{{$sale_payment->customer}}</div>
                                </div>
                                <div class="form-group">
                                    <div><strong>Price</strong></div>
                                    <div>{{$sale_payment->price}}</div>
                                </div>
                                <div class="form-group" id="payment-type">
                                    <label>Payment Type</label>
                                    <select id="payment_type_id" name="payment_type_id" class="form-control select2">
                                        @foreach($types as $type)
                                        <option value="{{$type->id}}" @if ($type->id == $sale_payment->payment_type_id)
                                            selected
                                            @endif><b>{{$type->name}}</b> ({{$type->description}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input radio-check" type="radio" name="payment_status"
                                            value="1" @if ($sale_payment->payment_status == 1) checked @endif>
                                        <label class="form-check-label">Complete</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input radio-check" type="radio" name="payment_status"
                                            value="0" @if ($sale_payment->payment_status == 0) checked @endif>
                                        <label class="form-check-label">Processing</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="validate_photo" class="col-form-label">Validate Photo</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="old_validate_photo"
                                            value="{{$sale_payment->validate_photo}}">
                                        <input class="form-control @error('validate_photo') is-invalid @enderror"
                                            type="file" id="validate_photo" name="validate_photo">
                                        @error('validate_photo')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="photo-preview">
                                    <img id="preview-image-before-upload"
                                        src="{{asset('uploads/1200px-No-Image-Placeholder.svg.png')}}"
                                        alt="preview image" style="max-height: 250px;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.sale-payments.index')}}" class="btn btn-secondary">Cancel</a>
                                <a href="{{route('admin.sales.view', $sale_payment->sale_id)}}"
                                    class="btn btn-primary">View Sale</a>
                                <input type="submit" value="Edit Sale Payment" class="btn btn-success float-right">
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
        $('#validate_photo').prop('disabled', true);
        }
    })

    $('#payment-type').change(function () {
        if($(this).find(":selected").val() == 1) {
            $('#validate_photo').prop('disabled', true);
        } else {
            $('#validate_photo').prop('disabled', false);
        }
    })

    $(document).ready(function (e) {
        $('#validate_photo').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@stop