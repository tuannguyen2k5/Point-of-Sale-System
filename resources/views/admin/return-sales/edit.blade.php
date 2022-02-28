@extends('admin.layouts.app')
@section('title','Edit Return Sale')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Return Sale #{{$return_sale->id}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Return Sale</li>
                </ol>
            </div>
        </div>
        @if (session()->has('warning'))
        <div class="alert alert-warning alert-dismissible fade show w-100" role="alert">
            <div>{{session('warning')}}</div>
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
                    <h3 class="card-title">Detail</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('admin.return-sales.edit.update',$return_sale->id)}}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>Sale ID</label>
                            <select id="sale" name="sale_id" class="form-control select2">
                                @foreach($sales as $sale)
                                <option value="{{$sale->id}}" @if ($sale->id == $return_sale->sale_id)
                                    checked
                                    @endif>#{{$sale->id}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><b>List of product return</b></label>
                            <table id="old-dynamic-product-list" class="w-100 table table-bordered">
                                <tr>
                                    <th style="width: 50%">Product</th>
                                    <th style="width: 35%">Quantity</th>
                                    <th style="width: 15%"></th>
                                </tr>
                                @foreach ($old_products as $key=>$item)
                                <tr>
                                    <td id="old-product-id-{{$key}}" class="product-id">
                                        <input type="hidden" name="old[{{key}}][id]">
                                        <select id="old-productId-{{$key}}" name="old_products[{{$key}}][id]"
                                            class="form-control select2">
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}" @if ($product->id ==
                                                $item->product_id) selected
                                                @endif>{{$product->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="old[{{key}}][quantity]">
                                        <input type="number" id="old-inputQuantity-{{$key}}"
                                            name="old_products[{{$key}}][quantity]" class="form-control"
                                            value="{{$item->quantity}}">
                                    </td>
                                    <td>
                                        @if ($key == 0)
                                        <button type="button" name="add" id="old-dynamic-ar"
                                            class="btn btn-primary w-100">Add
                                            Product</button>
                                        @else
                                        <button type="button"
                                            class="btn btn-danger old-remove-input-field w-100">Delete</button>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="form-group">
                            <label><b>List of product return</b></label>
                            <table id="new-dynamic-product-list" class="w-100 table table-bordered">
                                <tr>
                                    <th style="width: 50%">Product</th>
                                    <th style="width: 35%">Quantity</th>
                                    <th style="width: 15%"></th>
                                </tr>
                                @foreach ($new_products as $key=>$item)
                                <tr>
                                    <td id="new-product-id-{{$key}}" class="product-id">
                                        <input type="hidden" name="new[{{key}}][id]">
                                        <select id="productId-{{$key}}" name="new_products[{{$key}}][name]"
                                            class="form-control select2">
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}" @if ($product->id ==
                                                $item->product_id) selected
                                                @endif>{{$product->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="new[{{key}}][quantity]">
                                        <input type="number" id="new-inputQuantity-{{$key}}"
                                            name="new_products[{{$key}}][quantity]" class="form-control"
                                            value="{{$item->quantity}}">
                                    </td>
                                    <td>
                                        @if ($key == 0)
                                        <button type="button" name="add" id="new-dynamic-ar"
                                            class="btn btn-primary w-100">Add
                                            Product</button>
                                        @else
                                        <button type="button"
                                            class="btn btn-danger new-remove-input-field w-100">Delete</button>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="inputNote">Note</label>
                            <textarea id="inputNote" name="note"
                                class="form-control @error('note') is-invalid @enderror"
                                row="4">{{old('note', $return_sale->note ?? '')}}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.return-sales.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Edit sale" class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                </div>

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
<script type="text/javascript">
    var i = 0;
    $("#old-dynamic-ar").click(function () {
    ++i;
    $("#old-dynamic-product-list").append(
    `<tr>
        <td id="old-product-id-`+ i +`" class="product-id">
            <select id="old_product" name="old_products[`+ i + `][id]" class="form-control select2">
                @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" id="old-inputQuantity-`+ i +`" name="old_products[`+ i +`][quantity]" class="form-control" value="1">
        </td>
        <td>
            <button type="button" class="btn btn-danger remove-input-field w-100">Delete</button>
        </td>
    </tr>`
    );
    });
    $(document).on('click', '.old-remove-input-field', function () {
    $(this).parents('tr').remove();
    });

    $("#new-dynamic-ar").click(function () {
    ++i;
    $("#new-dynamic-product-list").append(
    `<tr>
        <td id="new-product-id-`+ i +`" class="product-id">
            <select id="new_product" name="new_products[`+ i + `][id]" class="form-control select2">
                @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" id="new-inputQuantity-`+ i +`" name="new_products[`+ i +`][quantity]" class="form-control"
                value="1">
        </td>
        <td>
            <button type="button" class="btn btn-danger remove-input-field w-100">Delete</button>
        </td>
    </tr>`
    );
    });
    $(document).on('click', '.new-remove-input-field', function () {
    $(this).parents('tr').remove();
    });
</script>
@stop