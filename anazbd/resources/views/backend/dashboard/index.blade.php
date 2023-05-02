@extends('backend.layouts.master')
@section('page-header')
    <i class="fa fa-home"></i> Dashboard
@endsection
@section('title', 'Dashboard')

@section('content')
    {{--  Heading  --}}
    <div class="page-header">
        <h1>
            @yield('page-header')
        </h1>
    </div>

    {{--  Content  --}}
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
                <div class="row">
                    <div class="col">
                        <canvas id="most_sold_items_chart" style="height:400px;"></canvas>
                    </div>
                    <div class="col">
                        <canvas id="most_sold_sellers_chart" style="height:400px;"></canvas>
                    </div>
                </div>
                
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
