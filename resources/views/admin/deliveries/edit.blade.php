@extends('admin.layouts.app')
@section('title','Edit Delivery')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Delivery #{{$delivery->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Delivery</li>
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
                    <h3 class="card-title">Delivery #{{$delivery->id}}</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.deliveries.edit.update',$delivery->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <div><strong>Customer</strong></div>
                            <div>{{$delivery->customer}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Address</strong></div>
                            <div>{{$delivery->address}}</div>
                        </div>
                        <div class="form-group">
                            <div><strong>Received Money</strong></div>
                            <div>{{$delivery->received_money}}</div>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" name="status_id" class="form-control select2">
                                @foreach($status as $item)
                                <option value="{{$item->id}}" @if ($item->id == $delivery->status_id) selected
                                    @endif><b>{{$item->name}}</b> ({{$item->description}})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputNote">Note</label>
                            <textarea id="inputNote" name="note"
                                class="form-control @error('note') is-invalid @enderror"
                                row="4">{{old('note', $delivery->note ?? '')}}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.deliveries.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Edit Delivery" class="btn btn-success float-right">
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
    })
</script>
@stop