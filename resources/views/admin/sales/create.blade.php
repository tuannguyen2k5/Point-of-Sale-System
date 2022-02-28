@extends('admin.layouts.app')
@section('title','Create a new Sale')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sale Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sale Add</li>
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
                    <form method="post" action="{{route('admin.sales.create.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select id="customer" name="customer_id" class="form-control select2">
                                        @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputPrice">Total Price</label>
                                    <input type="text" id="inputPrice" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{old('price', $sale->price ?? '')}}" readonly>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Order date</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" id="order_date" name="order_date"
                                            class="form-control datetimepicker-input @error('order_date') is-invalid @enderror"
                                            data-target="#reservationdate"
                                            value="{{old('order_date', $sale->order_date ?? '' )}}" />
                                        <div class="input-group-append" data-target="#reservationdate"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputShippingFee">Shipping Fee</label>
                                    <input type="text" id="inputShippingFee" name="shipping_fee"
                                        class="form-control @error('shipping_fee') is-invalid @enderror"
                                        value="{{old('shipping_fee', $sale->shipping_fee ?? '')}}">
                                    @error('shipping_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label><b>List of product</b></label>
                                <table id="dynamic-product-list" class="w-100 table table-bordered">
                                    <tr>
                                        <th style="width: 50%">Product</th>
                                        <th style="width: 35%">Quantity</th>
                                        <th style="width: 15%"></th>
                                    </tr>
                                    <tr>
                                        <td id="product-id-0" class="product-id">
                                            <select id="productId-0" name="products[0][name]"
                                                class="form-control select2">
                                                @foreach($products as $product)
                                                <option value="{{$product->id}}" data-price="{{$product->price}}">
                                                    {{$product->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="products[0][quantity]" id="inputQuantity-0"
                                                class="form-control" value="{{old('products[0][quantity]', 1)}}">
                                        </td>
                                        <td>
                                            <button type="button" name="add" id="dynamic-ar"
                                                class="btn btn-primary w-100">Add
                                                Product</button>
                                        </td>
                                    </tr>
                                </table>
                                <a class="btn-success btn" id="updateTotalPrice">Update Total Price</a>
                                <div class="form-group">
                                    <label for="inputNote">Note</label>
                                    <textarea id="inputNote" name="note"
                                        class="form-control @error('note') is-invalid @enderror"
                                        value="{{old('note', $sale->note ?? '')}}" row="4"></textarea>
                                    @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.sales.index')}}" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Create New sale" class="btn btn-success float-right">
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
<script type="text/javascript">
    var i = 0;
    $("#dynamic-ar").click(function () {
        ++i;
        $("#dynamic-product-list").append(
            `<tr>
                <td id="product-id-`+ i +`" class="product-id">
                    <select id="product" name="products[`+ i + `][name]" class="form-control select2">
                        @foreach($products as $product)
                        <option value="{{$product->id}}" data-price="{{$product->price}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" id="inputQuantity-`+ i +`" name="products[`+ i +`][quantity]" class="form-control" value="1">
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-input-field w-100">Delete</button>
                </td>
            </tr>`
            );
    });
    $(document).on('click', '.remove-input-field', function () {
        $(this).parents('tr').remove();
    });

    $("#updateTotalPrice").click(function() {
        var total = 0;
        n = document.getElementsByClassName('product-id').length;
        for(var j=0;j<n;j++) {
            var p = parseFloat($(`#product-id-`+ j +``).find(':selected').data('price'));
            var q = parseFloat($(`#inputQuantity-`+j+``).val());
            total += p*q;
        }

        $("#inputPrice").val(total.toFixed(2));
    });    
</script>
@stop