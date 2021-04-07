@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div id="app">
        <div class="row justify-content-md-cente">
            <div class="col-auto">
                <table class="table table-bordered">
                    <thead>
                        <th>Expense Categories</th>
                        <th>Total</th>
                        <th>Color</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['sum_total'] }}</td>
                            <td><i class="fas fa-circle" style="color: {{ $item['color'] }};"></i> {{ $item['color'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-auto">
                <canvas id="chartjs-pie"></canvas>
            </div>
        </div>
    </div>
    <!--//app-card-->
@endsection

@section('scripts')
    <script>
        const e = new Vue({
            el: '#app',
            mounted() {
                // Pie chart
                new Chart(document.getElementById("chartjs-pie"), {
                    type: "pie",
                    data: {
                        labels: [@foreach ($data as $item) "{!! $item['name'] !!}", @endforeach],
                        datasets: [{
                            data: [@foreach ($data as $item) '{{ $item['sum_total'] }}', @endforeach],
                            backgroundColor: [
                                @foreach ($data as $item) '{{ $item['color'] }}', @endforeach
                            ],
                            borderColor: "transparent"
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: true
                        }
                    }
                });
            }
        });

    </script>
@endsection
