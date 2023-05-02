@extends('admin.layout.master')

@section('title','Dashboard')

@section('content')
    <div class="row">
        <div class="col mr-1 bg-info rounded shadow">
            <div class=" position-relative">
                <div class="col-12 text-center">
                    <span class="text-white" style="font-size: 55px">{{ $users }}</span>
                </div>
                <p class="col-12 text-center text-white" style="font-size: 20px">Users</p>
            </div>
        </div>
        <div class="col mx-1 bg-white rounded shadow">
            <div>
                <div class="col-12 text-center">
                    <span class="text-info" style="font-size: 55px">{{ $sellers }}</span>
                </div>
                <p class="col-12 text-center text-info" style="font-size: 20px">Sellers</p>
            </div>
        </div>
        <div class="col mx-1 bg-success rounded shadow" >
            <div>
                <div class="col-12 text-center">
                    <span class="text-white" style="font-size: 55px">{{ $products }}</span>
                </div>
                <p class="col-12 text-center text-white" style="font-size: 20px">Products</p>
            </div>
        </div>
        <div class="col mx-1 bg-primary rounded shadow" >
            <div>
                <div class="col-12 text-center">
                    <span class="text-white" style="font-size: 55px">{{ $onDelivery }}</span>
                </div>
                <p class="col-12 text-center text-white" style="font-size: 15px">OnDelivery Orders</p>
            </div>
        </div>
        <div class="col mx-1 bg-warning rounded shadow" >
            <div>
                <div class="col-12 text-center">
                    <span class="text-danger" style="font-size: 55px">{{ $pending }}</span>
                </div>
                <p class="col-12 text-center text-danger" style="font-size: 20px">Pending Orders</p>
            </div>
        </div>
        {{--  <div class="col-2 ml-1 bg-danger rounded shadow" style="height:100px"></div>  --}}
    </div>
<div class="row mt-3">
        <div class="col mr-1">
            <a href="#" class="btn btn-block btn-primary">Create Order</a>
        </div>
        <div class="col mx-1">
            <a href="#" class="btn btn-block btn-primary">Create User</a>
        </div>
        <div class="col mx-1">
            <a href="#" class="btn btn-block btn-primary">Create Slider</a>
        </div>
        <div class="col mx-1">
            <a href="#" class="btn btn-block btn-primary">Create Coupon</a>
        </div>
        <div class="col mx-1">
            <a href="#" class="btn btn-block btn-primary">Create Flash Sale</a>
        </div>
        {{--  <div class="col-2 ml-1 bg-danger rounded shadow" style="height:100px"></div>  --}}
    </div>
    
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="weekly_chart" style="height:400px;"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="monthly_chart" style="height:400px;"></canvas>
                    </div>
                </div>
                {{--  <div class="row">
                    <div class="col">
                        <canvas id="most_sold_items_chart" style="height:400px;"></canvas>
                    </div>
                    <div class="col">
                        <canvas id="most_sold_sellers_chart" style="height:400px;"></canvas>
                    </div>
                </div>  --}}
                
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script>

        var weekData = {!! json_encode($saleWeekly) !!};
        var weekLabels = [];
        var weekDatasets = [];
        var weekColors = [];
        $.each(weekData,function (index,data){
            weekLabels.push(Object.entries(data)[0][0]); 
            weekDatasets.push(Object.entries(data)[0][1]);
            weekColors.push('rgba(44, 130, 201, '+Object.entries(data)[0][1] / 10+')')
        });
        console.log(weekDatasets)

        var monthData = {!! json_encode($saleMonthly) !!};
        var monthLabels = [];
        var monthDatasets = [];
        var monthColors = [];
        $.each(monthData,function (index,data){
            monthLabels.push(Object.entries(data)[0][0]); 
            monthDatasets.push(Object.entries(data)[0][1]);
            monthColors.push('rgba(207, 0, 15, '+Object.entries(data)[0][1] / 10+')')
        });

        var weekChart = document.getElementById('weekly_chart').getContext('2d');
        var myChart = new Chart(weekChart, {
            type: 'bar',
            data: {
                labels: weekLabels,
                datasets: [{
                    label: 'Weekly Order Placed',
                    data: weekDatasets,
                    backgroundColor: weekColors,
                    borderColor: weekColors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var monthChart = document.getElementById('monthly_chart').getContext('2d');
        var myChart = new Chart(monthChart, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Monthly Order Placed',
                    data: monthDatasets,
                    backgroundColor: monthColors,
                    borderColor: monthColors,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
