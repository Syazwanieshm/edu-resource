@extends('layouts.master')
@section('content')
{{-- message --}}
{!! Toastr::message() !!}
<div class="page-wrapper">
    <div class="content container-fluid">
        <!--DISPLAY NAMA USER--> <!--WELCOMING TEXT-->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome !</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <!--<li class="breadcrumb-item active">{{ Session::get('name') }}</li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Students</h6> 
                                <h3>5</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Tutor</h6>
                                <h3>7</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Classroom</h6>
                                <h3>8</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Subject</h6>
                                <h3>2</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-04.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="card bg-comman w-100">
                    <div class="card-body">
                        <div class="db-widgets d-flex justify-content-between align-items-center">
                            <div class="db-info">
                                <h6>Resources</h6> 
                                <h3>12</h3>
                            </div>
                            <div class="db-icon">
                                <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <!-- Calendar Section -->
          <div class="col-xl-3">
                <div class="card flex-fill comman-shadow">
                    <div class="card-body">
                        <div id="calendar-doctor" class="calendar-container"></div>
                    </div>
                </div>
            </div>
            <!-- End Calendar Section -->
     

      
           
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/core/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/daygrid/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calendar Initialization
        var calendarEl = document.getElementById('calendar-doctor');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // You can change the initial view if needed
            // Add more options and event sources as needed
        });
        calendar.render();

        // Chart Initialization
        @if(isset($classAverages))
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
        @endif

        @if(isset($formAverages))
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
                    categories: formCategories
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
        @endif

        @if(isset($subjectAverages))
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

            var subjectOptions = {
                series: [{
                    name: 'Average Carry Mark (%)',
                    data: subjectSeries.map(series => series.data[0])
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
                    categories: subjectCategories
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
        @endif
    });
</script>
@endsection

