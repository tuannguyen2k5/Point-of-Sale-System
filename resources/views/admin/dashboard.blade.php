@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('css')
<!-- IonIcons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>Overview Yearly Sales</b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                            @for ($i = 0; $i < 12; $i++) <input type="hidden" name="month-{{$i}}"
                                value="{{$month[$i]}}">
                                <input type="hidden" name="revenue-{{$i}}" value="{{$revenue[$i]}}">
                                @endfor
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Last 12 months
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>5 Latest Sales</b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Order Date</th>
                                    <th>Price</th>
                                    <th>Shipping Fee</th>
                                    <th>Is Complete</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($latest_sales as $latest_sale)
                                <tr>
                                    <td>{{$latest_sale->customer}}</td>
                                    <td>{{$latest_sale->order_date}}</td>
                                    <td>{{$latest_sale->price}}</td>
                                    <td>{{$latest_sale->shipping_fee}}</td>
                                    <td>{{$latest_sale->is_complete}}</td>
                                    <td class="sale-actions text-right">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{route('admin.sales.view',$latest_sale->id)}}">
                                            <i class="fas fa-folder">
                                            </i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>Top 5 Best Selling Yearly</b></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Top</th>
                                    <th>Product Name</th>
                                    <th>Selling Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_years as $key => $value)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->total}}</td>
                                    <td class="sale-actions text-right">
                                        <a class="btn btn-primary btn-sm"
                                            href="{{route('admin.products.view',$value->product_id)}}">
                                            <i class="fas fa-folder">
                                            </i>
                                            View Product
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
@section('js')
<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>

<script>
    $((function(){
    "use strict";
    var month = [];
    var revenue = [];
    for(var i=0;i<12;i++) {
        month[i]=document.getElementsByName(`month-`+ (11-i).toString())[0].value; 
        revenue[i]=document.getElementsByName(`revenue-`+ (11-i).toString())[0].value; 
    }
    console.log(document.getElementsByName("month-2")[0].value);
    var e={fontColor:"#495057",fontStyle:"bold"},
    o="index",t=!0,r=$("#sales-chart"),
    a=(new Chart(
    r,
    {
    type:"bar",
    data:{
    labels:month,
    datasets:[
    {
    backgroundColor:"#007bff",borderColor:"#007bff",
    data:revenue
    }
    ]
    },
    options:{
    maintainAspectRatio:!1,
    tooltips:{mode:o,intersect:t},
    hover:{mode:o,intersect:t},
    legend:{display:!1},
    scales:{
    yAxes:[
    {
    gridLines:
    {
    display:!0,
    lineWidth:"4px",
    color:"rgba(0, 0, 0, .2)",
    zeroLineColor:"transparent"
    },
    ticks:$.extend(
    {
    beginAtZero:!0,
    callback:function(e){return e>=1e3&&(e/=1e3,e+="k"),"$"+e}
    },e
    )
    }
    ],
    xAxes:[
    {
    display:!0,
    gridLines:{display:!1},
    ticks:e
    }
    ]
    }
    }
    }
    ),
    $("#visitors-chart"));
    
    }
    ));
</script>
@endsection