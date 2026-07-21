@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    <link rel="stylesheet" href="{{asset('assets/plugins/chart.js/Chart.min.css')}}">
    <style>
        .dashboard-hero {
            background-image: linear-gradient(180deg, rgba(16,78,146,0.85), rgba(44, 62, 80, 0.9)), url('{{asset('assets/img/img-01.jpg')}}');
            background-size: cover;
            background-position: center;
            border-radius: 18px;
            color: #fff;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.12);
        }
        .dashboard-hero h3 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }
        .dashboard-hero p {
            color: rgba(255,255,255,0.8);
            margin-bottom: 0;
        }
        .dashboard-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        }
        .dashboard-card .dash-widget-icon {
            width: 56px;
            height: 56px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            font-size: 1.25rem;
        }
    </style>
@endpush

@push('page-header')
<div class="col-sm-12">
    <div class="dashboard-hero">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3>Welcome back, {{auth()->user()->name}}!</h3>
                <p>Monitor inventory health, expired products, and barcode-ready stock from a clean control panel.</p>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <a href="{{ route('products.scan') }}" class="btn btn-light btn-lg">Scan Barcode</a>
            </div>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-primary bg-soft-primary">
                        <i class="fe fe-money"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{AppSettings::get('app_currency', '$')}} {{$today_sales}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">Today Sales Cash</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-success bg-soft-success">
                        <i class="fe fe-credit-card"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$total_categories}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    
                    <h6 class="text-muted">Product Categories</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-danger bg-soft-danger">
                        <i class="fe fe-folder"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$total_expired_products}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    
                    <h6 class="text-muted">Expired Products</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-danger w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card dashboard-card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-info bg-soft-info">
                        <i class="fe fe-barcode"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{$total_barcoded_products}}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">Barcode Products</h6>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info w-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card card-table p-3">
            <div class="card-header">
                <h4 class="card-title ">Today Sales</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="sales-table" class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                                                                                      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-6">
                    
        <!-- Pie Chart -->
        <div class="card card-chart">
            <div class="card-header">
                <h4 class="card-title text-center">Resources</h4>
            </div>
            <div class="card-body">
                <div style="">
                    {!! $pieChart->render() !!}
                </div>
            </div>
        </div>
        <!-- /Pie Chart -->
        
    </div>	
    
    
</div>

@endsection

@push('page-js')
<script>
    $(document).ready(function() {
        var table = $('#sales-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('sales.index')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'quantity', name: 'quantity'},
                {data: 'total_price', name: 'total_price'},
				{data: 'date', name: 'date'},
            ]
        });
        
    });
</script> 
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endpush