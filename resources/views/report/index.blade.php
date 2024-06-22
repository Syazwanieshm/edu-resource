@extends('layouts.master')

@section('content')
    {{-- Message --}}
    {!! Toastr::message() !!}

    <div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Annual Students Performance Report </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active">Reporting</li>
                    </ul>
                </div>
            </div>
        </div>
        
<!-- Place the Download PDF button here -->
<button id="downloadPdfButton" class="btn btn-primary">Download PDF</button>

    <div class="row">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card flex-fill comman-shadow">
                <div class="card-header">
                    <h5 class="card-title">Class Averages</h5>
                </div>
                <div class="card-body">
                    <div id="class-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card flex-fill comman-shadow">
                <div class="card-header">
                    <h5 class="card-title">Form Averages</h5>
                </div>
                <div class="card-body">
                    <div id="form-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 col-lg-12 col-xl-12 d-flex">
            <div class="card flex-fill comman-shadow">
                <div class="card-header">
                    <h5 class="card-title">Subject Averages</h5>
                </div>
                <div class="card-body">
                    <div id="subject-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Prepare Class Averages Data
        var classSeries = [];
        var classCategories = [];
        var isCategoriesSet = false;

        @foreach($classAverages as $class => $averages)
            var data = [
                @foreach($averages as $average)
                    {{ number_format($average->average_carry_mark, 2) }},
                @endforeach
            ];

            if (!isCategoriesSet) {
                classCategories = [
                    @foreach($averages as $average)
                        '{{ $average->subject }}',
                    @endforeach
                ];
                isCategoriesSet = true;
            }

            classSeries.push({
                name: '{{ $class }}',
                data: data
            });
        @endforeach

        var classOptions = {
            series: classSeries,
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            colors: ['#1E90FF', '#32CD32', '#FF8C00', '#FF1493', '#8A2BE2'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 0 // Removed markers
            },
            xaxis: {
                categories: classCategories
            },
            yaxis: {
                title: {
                    text: 'Average Carry Mark (%)'
                }
            },
            legend: {
                position: 'top'
            }
        };

        var classChart = new ApexCharts(document.querySelector("#class-chart"), classOptions);
        classChart.render();

        // Prepare Form Averages Data
        var formSeries = [];
        var formCategories = [];
        var isFormCategoriesSet = false;

        @for ($i = 1; $i <= 5; $i++)
            @php
                $formKey = (string)$i;
            @endphp
            @if (isset($formAverages[$formKey]))
                var formData{{$i}} = [
                    @foreach($formAverages[$formKey] as $average)
                        {{ number_format($average->average_carry_mark, 2) }},
                    @endforeach
                ];

                if (!isFormCategoriesSet) {
                    formCategories = [
                        @foreach($formAverages[$formKey] as $average)
                            '{{ $average->subject }}',
                        @endforeach
                    ];
                    isFormCategoriesSet = true;
                }

                formSeries.push({
                    name: 'Form {{ $i }}',
                    data: formData{{$i}}
                });
            @endif
        @endfor

        var formOptions = {
            series: formSeries,
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            colors: ['#FF6347', '#20B2AA', '#FFA07A', '#00CED1', '#9370DB'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 0 // Removed markers
            },
            xaxis: {
                categories: [
                    @foreach($subjectAverages as $subjectAverage)
                        '{{ $subjectAverage->name }}',
                    @endforeach
                ]
            },
            yaxis: {
                title: {
                    text: 'Average Carry Mark (%)'
                }
            },
            legend: {
                position: 'top'
            }
        };

        var formChart = new ApexCharts(document.querySelector("#form-chart"), formOptions);
        formChart.render();

        // Prepare Subject Averages Data
        var subjectSeries = [];
        var subjectCategories = [];
        var isSubjectCategoriesSet = false;

        @foreach($subjectAverages as $subjectAverage)
            subjectCategories.push('{{ $subjectAverage->name }}');

            subjectSeries.push({
                name: '{{ $subjectAverage->name }}',
                data: [{{ number_format($subjectAverage->average_carry_mark, 2) }}]
            });
        @endforeach

        // Subject Averages Chart
        var subjectOptions = {
            series: [{
                name: 'Average Carry Mark (%)',
                data: [
                    @foreach($subjectAverages as $subjectAverage)
                        {{ number_format($subjectAverage->average_carry_mark, 2) }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            colors: ['#20B2AA'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 0 // Removed markers
            },
            xaxis: {
                categories: [
                    @foreach($subjectAverages as $subjectAverage)
                        '{{ $subjectAverage->name }}',
                    @endforeach
                ]
            },
            yaxis: {
                title: {
                    text: 'Average Carry Mark (%)'
                }
            },
            legend: {
                position: 'top'
            }
        };
        var subjectChart = new ApexCharts(document.querySelector("#subject-chart"), subjectOptions);
        subjectChart.render();

       
        });

    
</script>

@endsection
