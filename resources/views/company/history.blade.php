@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">

        <!-- Data Table -->
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card" >
                    <div class="card-header">{{ __('Company Sales History Table - ') }} {{$symbol}}</div>
                    <div class="card-body">
                        <table id="jquery-datatable" class="display">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Open</th>
                                    <th scope="col">High</th>
                                    <th scope="col">Low</th>
                                    <th scope="col">Close</th>
                                    <th scope="col">Volume</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($filteredHistoryData as $data)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($data['date'])->toDateString() ?? null}}</td>
                                    <td>{{$data['open'] ?? null}}</td>
                                    <td>{{$data['high'] ?? null}}</td>
                                    <td>{{$data['low'] ?? null}}</td>
                                    <td>{{$data['close'] ?? null}}</td>
                                    <td>{{$data['volume'] ?? null}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <!-- Data Chart -->
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">{{ __('Company Sales History Chart - ') }} {{$symbol}}</div>
                    <div class="card-body">
                        <div style="width: 100%; overflow-x: auto; overflow-y: hidden">
                            <div style="width: {{count($filteredHistoryData) * 50}}px; min-width: 900px; height: 500px;">
                                <canvas id="myChart" height="300" width="0"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#jquery-datatable').DataTable({
                pagingType: 'full_numbers',
                bProcessing : true,
                bDestroy : true,
                bAutoWidth : true,
                sScrollY : "400",
                bScrollCollapse : false,
                bSort : true,
                iDisplayLength : 25,
                bLengthChange : true
            });

            let data = {{ Js::from($filteredHistoryData) }};
            const chartData = Object.values(data).map(item => item)
            const dates = chartData.map(obj =>  (new Date(obj.date * 1000)).toLocaleDateString('en-CA'))
            const openingPrices =  chartData.map(obj => obj.open);
            const closingPrices =  chartData.map(obj => obj.close);

            data = {
                labels: dates,
                datasets: [{
                    label: 'Opening Price',
                    data: openingPrices,
                    borderColor: 'blue',
                    fill: false
                }, {
                    label: 'Closing Price',
                    data: closingPrices,
                    borderColor: 'red',
                    fill: false
                }]
            };

            const config = {
                type: 'line',
                data: data,
                maintainAspectRatio: false,
                responsive: true,
                options: {
                    scales: {
                        y: {
                            position: 'left',
                            beginAtZero: false,
                        },
                        x: {
                            reverse: true,
                            distribution: 'linear'
                        }
                    }
                }
            };

            new Chart(document.getElementById('myChart'), config);
        });

    </script>
@endsection
