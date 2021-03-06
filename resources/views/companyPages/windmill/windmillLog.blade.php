@extends('companyPages.layouts.app')
@section('title', 'View Wind-Turbine')
@section('sideBarActivator_WindTurbines', 'class=active')

@section('pageSpecificHeadContent')
	<link rel="stylesheet" href="{{ asset('rawThemes/adminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('body')

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<strong class="text-success">View Wind-Turbine Log</strong>
		<small>log of the wind-turbine</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li>Wind-Turbine</li>
		<li class="active">Show</li>
	</ol>
</section>

<section class="content">
	<div class="box box-success">
		<div class="box-body">
			<div class="row">
				<div class="col-lg-3 col-xs-5">
		          <!-- small box -->
		          <div class="small-box bg-green">
		            <div class="inner">
		              <h3>{{ $id }}</h3>
		            </div>
		            <div class="icon">
		              <i class="fa fa-key" style="padding-top: 10px;"></i>
		            </div>
		            <span class="small-box-footer">Wind-Turbine ID</span>
		          </div>
		        </div>
		        <div class="col-md-3 col-xs-7 pull-right">
		        	<a href="{{ route('windmill.show', $id) }}" class="btn btn-block btn-info">Back</a>
		        	<a href="" class="btn btn-block btn-primary btn-lg"><strong>Download Log</strong></a>
		        </div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="box">
				<div class="box-header with-border">
					<h3>Graphs</h3>
          			<button id="refresh" class="btn pull-right">Refresh</button>
				</div>

				<div class="box-body">
					<div class="container-fluid">
						<div class="row">
							<div class="box box-success">
								<div class="box-header with-border">
									<h4 class="text-success">Power <small>(mW)</small></h4>
								</div>
								<div class="panel-body">
									<div id="interactive-power" style="height: 300px;"></div>
								</div>

								<div class="box-footer">
									@isset($windmill->predictionValue)
									<div class="jumbotron">
										<h2>
											<center>
												Latest Prediction of Power is &nbsp;
												<span class="text-yellow">
													<strong>{{ $windmill->predictionValue }} mW</strong>.
												</span>
											</center>
										</h2>
										<hr>
										<h3>
											<center>
												Average Power generation is <span class="text-purple" id="avgPower"></span>.
											</center>
										</h3>
										<hr>
										<h4>
											<center>
												The difference between the Prediction and Actual Values is <span class="text-warning" id="difference1"></span>, which is <span class="text-danger" id="percentagediff1"></span>.
											</center>
										</h4>
									</div>
									@endisset
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="box box-success">
									<div class="box-header with-border">
										<h4 class="text-success">Voltage <small>(mV)</small></h4>
									</div>
									<div class="panel-body">
										<div id="interactive-voltage" style="height: 300px"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-lg-6">
								<div class="box box-success">
									<div class="box-header with-border">
										<h4 class="text-success">Temperature <small>(&deg; C)</small></h4>
									</div>
									<div class="panel-body">
										<div id="interactive-temperature" style="height: 300px"></div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-lg-6">
								<div class="box box-success">
									<div class="box-header with-border">
										<h4 class="text-success">Humidity <small>(%)</small></h4>
									</div>
									<div class="panel-body">
										<div id="interactive-humidity" style="height: 300px"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="box">
				<div class="box-header with-border">
					<h3>Raw Data Log</h3>
				</div>

				<div class="box-body table-responsive">
					<table class="table table-bordered table-hover" id="sensorLog">
						<thead>
							<tr>
								<th><span class="text-success">Voltage (V)</span></th>
								<th><span class="text-success">Power (mW)</span></th>
								<th><span class="text-success">Temprature (&degC)</span></th>
								<th><span class="text-success">Humidity (%)</span></th>
								<th><span class="text-success">Timestamp</span></th>
							</tr>
						</thead>

						<tbody>
							@foreach ($sensors as $sensor)
							
							<tr>
								{{-- <td>{{ $sensor->current }}</td> --}}
								<td>{{ $sensor->voltage }}</td>
								<td>{{ $sensor->power }}</td>
								<td>{{ $sensor->temperature }}</td>
								<td>{{ $sensor->humidity }}</td>
								<td>{{ $sensor->created_at }}</td>
							</tr>
							
							@endforeach
						</tbody>

						<tfoot>
							<tr>
								<th><span class="text-success">Voltage (V)</span></th>
								<th><span class="text-success">Power (mW)</span></th>
								<th><span class="text-success">Temprature (&degC)</span></th>
								<th><span class="text-success">Humidity (%)</span></th>
								<th><span class="text-success">Timestamp</span></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@section('pageSpecificLoadScripts')
	<script src="{{ asset('rawThemes/adminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('rawThemes/adminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	{{-- FastClick --}}
	<script src="{{ asset('rawThemes/adminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
	
	<!-- FLOT CHARTS -->
	<script src="{{ asset('rawThemes/adminLTE/bower_components/Flot/jquery.flot.js') }}"></script>
	<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
	<script src="{{ asset('rawThemes/adminLTE/bower_components/Flot/jquery.flot.resize.js') }}"></script>
	<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
	<script src="{{ asset('rawThemes/adminLTE/bower_components/Flot/jquery.flot.categories.js') }}"></script>
	{{-- EXTRA SCRIPTS --}}

	<script>
	  $(function () {
	    $('#sensorLog').DataTable({
	      'paging'      : true,
	      'lengthChange': true,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : true
	    })
	  
	    /*
         * Flot Interactive Chart
         * -----------------------
         */
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        // var data = [], totalPoints = 100

        $(document).ready(function() {
          update();
        });

        function update() {
          
          // event.preventDefault();
          /* Act on the event */

          $.ajax({
            url: '{{ route('windmill.log.graphs', $id) }}',
            type: 'GET',
            dataType: 'json',
            data: {},
          })
          .done(function(data) {
            console.log("success");
            var arr = Object.values(data);
            var arr2 = Object.values(arr[0]);
            arr2.reverse();

            var voltageRes=[], powerRes=[], powerPredict=[], temperatureRes=[], humidityRes=[];

            for (var i = 0; i < arr2.length; i++) {
              voltageRes.push([i, arr2[i].voltage]);
              powerRes.push([i, arr2[i].power]);
              powerPredict.push([i, arr[1]]);
              temperatureRes.push([i, arr2[i].temperature]);
              humidityRes.push([i, arr2[i].humidity]);
            }

            var total = 0;
            for(var i = 0; i < powerRes.length; i++) {
                total += powerRes[i][1];
            }
            var avg = Math.round((total / powerRes.length) * 10000) / 10000;
            
            document.getElementById('avgPower').innerHTML = avg + ' mW';
            var powerDifference = Math.abs(powerPredict[0][1] - avg);
            document.getElementById('difference1').innerHTML = (Math.round(powerDifference * 10000) / 10000)  + ' mW';
            var percentagediff = (powerDifference / powerPredict[0][1]) * 100;
            document.getElementById('percentagediff1').innerHTML = (Math.round(percentagediff * 10000) / 10000) + ' %';

            powerPredict = {
            	data: powerPredict,
            	color: '#ffc107',
            };

            var interactive_plot_power = $.plot('#interactive-power', [powerRes, powerPredict], {
              grid  : {
                borderColor: '#f3f3f3',
                borderWidth: 1,
                tickColor  : '#f3f3f3'
              },
              series: {
                shadowSize: 0, // Drawing is faster without shadows
                color     : '#00a65a'
              },
              lines : {
                fill : true, //Converts the line chart to area chart
                color: '#00a65a'
              },
              yaxis : {
                min : 0,
                max : 0.5,
                show: true
              },
              xaxis : {
                show: true
              }
            });
            var interactive_plot_voltage = $.plot('#interactive-voltage', [voltageRes], {
              grid  : {
                borderColor: '#f3f3f3',
                borderWidth: 1,
                tickColor  : '#f3f3f3'
              },
              series: {
                shadowSize: 0, // Drawing is faster without shadows
                color     : '#00a65a'
              },
              lines : {
                fill : true, //Converts the line chart to area chart
                color: '#00a65a'
              },
              yaxis : {
                min : 0,
                max : 1,
                show: true
              },
              xaxis : {
                show: true
              }
            });
            var interactive_plot_temp = $.plot('#interactive-temperature', [temperatureRes], {
              grid  : {
                borderColor: '#f3f3f3',
                borderWidth: 1,
                tickColor  : '#f3f3f3'
              },
              series: {
                shadowSize: 0, // Drawing is faster without shadows
                color     : '#00a65a'
              },
              lines : {
                fill : true, //Converts the line chart to area chart
                color: '#00a65a'
              },
              yaxis : {
                min : 0,
                max : 60,
                show: true
              },
              xaxis : {
                show: true
              }
            });
            var interactive_plot_hume = $.plot('#interactive-humidity', [humidityRes], {
              grid  : {
                borderColor: '#f3f3f3',
                borderWidth: 1,
                tickColor  : '#f3f3f3'
              },
              series: {
                shadowSize: 0, // Drawing is faster without shadows
                color     : '#00a65a'
              },
              lines : {
                fill : true, //Converts the line chart to area chart
                color: '#00a65a'
              },
              yaxis : {
                min : 0,
                max : 100,
                show: true
              },
              xaxis : {
                show: true
              }
            });
          })
          .fail(function() {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
          
          setTimeout(update, 5000);
        }

	  })
	</script>
@endsection