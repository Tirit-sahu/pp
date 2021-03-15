<?php 
$lastSegment = request()->segment(count(request()->segments()));
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>PAVAN PUTRA SABJI BHANDAR</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="turbolinks-cache-control" content="no-cache">

    {{-- @livewireStyles
	<link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/bootstrap.min.css') }}">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/jquery-ui/jquery-ui.min.css') }}">
	<!-- PageGuide -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/pageguide/pageguide.css') }}">
	<!-- Fullcalendar -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/fullcalendar/fullcalendar.css') }}">
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/fullcalendar/fullcalendar.print.css') }}" media="print">
	<!-- Tagsinput -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/tagsinput/jquery.tagsinput.css') }}">
	<!-- chosen -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/chosen/chosen.css') }}">
	<!-- multi select -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/multiselect/multi-select.css') }}">
	<!-- timepicker -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/timepicker/bootstrap-timepicker.min.css') }}">
	<!-- colorpicker -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/colorpicker/colorpicker.css') }}">
	<!-- Datepicker -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/datepicker/datepicker.css') }}">
	<!-- Daterangepicker -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- Plupload -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/plupload/jquery.plupload.queue.css') }}">
	<!-- select2 -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/select2/select2.css') }}">
	<!-- icheck -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/plugins/icheck/all.css') }}">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/style.css') }}">
	<!-- Color CSS -->
	<link rel="stylesheet" href="{{ asset('public/cdn/css/themes.css') }}">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		
	<link rel="shortcut icon" href="public/cdn/img/favicon.html" />
	<link rel="apple-touch-icon-precomposed" href="public/cdn/img/apple-touch-icon-precomposed.png" />
	
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">

	<style>
		
		
.menu {
	padding: 10px;
  color: white;
  font-size:13px;
  font-family: Arial;
  font-weight:bold;
  border-radius: 15px;
}
.success {background-color: #4CAF50;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */ 
.other {background-color: #e7e7e7; color: black;} /* Gray */ 

.c1 {background-color: #939;} /* Orange */
.c2 {background-color: #039;} /* Orange */
.c3 {background-color: #930;} /* Orange */

.c4 {background-color: #03F;} /* Orange */
.c5 {background-color: #C09;} /* Orange */
.c6 {background-color: #F00;} /* Orange */
.c7 {background-color: #39F;} /* Orange */


		
		
.js-select2{
	width: 100%;
}
.border-danger{
	border-color: red!important;
}	



.w-100{
	width: 100px;
}
.w-150{
	width: 150px;
}
.w-200{
	width: 200px;
}
.w-250{
	width: 250px;
}
.w-300{
	width: 300px;
}
.w-400{
	width: 400px;
}
.w-500{
	width: 500px;
}




/* Tirit sahu */

.high-light {
    background: #378ee0 !important;
    color: white;
}


/* Tirit sahu */

	</style>

</head>

<body>
    @auth
	<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">PAVAN PUTRA</a>
			<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation">
				<i class="fa fa-bars"></i>
			</a>
			
				
			
			<div class="user">
				<ul class="icon-nav">
					
<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Customer</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
							<a href="{{ url('/ledger-book') }}">Party Ledger Book</a>
						</li>

						<li>
							<a href="{{ url('/ledger-book-details') }}">Party Detail Ledger Book</a>
						</li>

						<li>
							<a href="{{ url('/party-balance-report') }}">Party Balance Report</a>
						</li>						

						<li>
							<a href="{{ url('/report-customer-carret-receive') }}">Carret Receive Report</a>
						</li>
						
						<li>
							<a href="{{ url('/report-payment-receive') }}">Customer Payment Report</a>
						</li>					

						<li>
							<a href="{{ url('/customer-supplier-carret-ledger') }}">Customer/Supplier Carret Ledger</a>
						</li>

						

					</ul>
				</li>

				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Company</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
							<a href="{{ url('/master-company-setting') }}">Item Report</a>
						</li>
						
						<li>
							<a href="{{ url('/master-session') }}">Sale Report</a>
						</li>
						
						<li>
							<a href="{{ url('/master-unit') }}">Purchase Report</a>
						</li>
						
						<li>
							<a href="{{ url('/master-item') }}">Other Income Report</a>
						</li>
						
						<li>
							<a href="{{ url('/master-group') }}">Other Expense Report</a>
						</li>
						
						<li>
							<a href="{{ url('/master-addtional-expenses') }}">Addtionl Expenses Master</a>
						</li>

						<li>
							<a href="{{ url('/master-customer-supplier') }}">Customer / Supplier Master</a>
						</li>

						<li>
							<a href="{{ url('/other-income-expenses') }}">Other Income Expenses Head</a>
						</li>						
					</ul>
				</li>
				
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Master</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						
						<li>
							<a href="{{ url('/master-company-setting') }}">Comany Master</a>
						</li>
						
						<li>
							<a href="{{ url('/master-session') }}">Session Master</a>
						</li>
						
						<li>
							<a href="{{ url('/master-unit') }}">Unit Master</a>
						</li>
						
						<li>
							<a href="{{ url('/master-item') }}">Item Master</a>
						</li>
						
						<li>
							<a href="{{ url('/master-group') }}">Group Master</a>
						</li>
						
						<li>
							<a href="{{ url('/master-addtional-expenses') }}">Addtionl Expenses Master</a>
						</li>

						<li>
							<a href="{{ url('/master-customer-supplier') }}">Customer / Supplier Master</a>
						</li>

						<li>
							<a href="{{ url('/master-bijak-print-name') }}">Bijak Print Name Master</a>
						</li>

						<li>
							<a href="{{ url('/other-income-expenses') }}">Other Income Expenses Head</a>
						</li>				
						
						
					</ul>
				</li>

					<li class="dropdown sett">
						<a href="#" class='dropdown-toggle' data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu pull-right theme-settings">
							<li>
								<span>Layout-width</span>
								<div class="version-toggle">
									<a href="#" class='set-fixed'>Fixed</a>
									<a href="#" class="active set-fluid">Fluid</a>
								</div>
							</li>
							<li>
								<span>Topbar</span>
								<div class="topbar-toggle">
									<a href="#" class='set-topbar-fixed'>Fixed</a>
									<a href="#" class="active set-topbar-default">Default</a>
								</div>
							</li>
							<li>
								<span>Sidebar</span>
								<div class="sidebar-toggle">
									<a href="#" class='set-sidebar-fixed'>Fixed</a>
									<a href="#" class="active set-sidebar-default">Default</a>
								</div>
							</li>
						</ul>
					</li>
					<li class='dropdown colo'>
						<a href="#" class='dropdown-toggle' data-toggle="dropdown">
							<i class="fa fa-tint"></i>
						</a>
						<ul class="dropdown-menu pull-right theme-colors">
							<li class="subtitle">
								Predefined colors
							</li>
							<li>
								<span class='red'></span>
								<span class='orange'></span>
								<span class='green'></span>
								<span class="brown"></span>
								<span class="blue"></span>
								<span class='lime'></span>
								<span class="teal"></span>
								<span class="purple"></span>
								<span class="pink"></span>
								<span class="magenta"></span>
								<span class="grey"></span>
								<span class="darkblue"></span>
								<span class="lightred"></span>
								<span class="lightgrey"></span>
								<span class="satblue"></span>
								<span class="satgreen"></span>
							</li>
						</ul>
					</li>
					
                </ul>
                
				<div class="dropdown">
					<a href="#" class='dropdown-toggle' data-toggle="dropdown">{{ Auth::user()->name }}
						<img src="public/cdn/img/demo/user-avatar.jpg" alt="">
					</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="more-userprofile.html">Edit profile</a>
						</li>
						<li>
							<a href="#">Account settings</a>
						</li>
						<li>
							<a href="{{ url('logout') }}">Logout</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
    @endauth
	
	<div class="container-fluid" id="content">
        @auth
		<div id="navigation">
		<ul class='main-nav'>
				<li class="">
					<a class="@if($lastSegment == '') active @endif">
						<span class="menu label success">Dashboard</span>
					</a>
				</li>

				<li class="@if($lastSegment == 'customer-sale') active @endif">
					<a href="{{ url('/customer-sale') }}"><span class="menu label success">Sale</span></a>
				</li>

				<li class="@if($lastSegment == 'payment-receive') active @endif">
					<a href="{{ url('/payment-receive') }}"><span class="menu label success">Payment Rec.</span></a>
				</li>

				<li class="@if($lastSegment == 'customer-carret-receive') active @endif">
					<a href="{{ url('/customer-carret-receive') }}"><span class="menu label success">Customer Carret Rec.</span></a>
				</li>

				<li class="@if($lastSegment == 'supplier-carret-returns') active @endif">
					<a href="{{ url('/supplier-carret-returns') }}"><span class="menu label danger">Supplier Carret Return</a>
				</li>

				<li class="@if($lastSegment == 'purchase-entry') active @endif">
					<a href="{{ url('/purchase-entry') }}"><span class="menu label danger">Purchase</span></a>
				</li>

				<li class="@if($lastSegment == 'purchase-payment-entries') active @endif">
					<a href="{{ url('/purchase-payment-entries') }}"><span class="menu label danger">Purchase Payment</span></a>
				</li>

				<li class="@if($lastSegment == 'loading_entries') active @endif">
					<a href="{{ url('/loading_entries') }}"><span class="menu label warning">Loading</span></a>
				</li>

			<li class="@if($lastSegment == 'loading_entries') active @endif">
					<a href="#"><span class="menu label c4">Loading Home</span></a>
				</li>
			
			<li class="@if($lastSegment == 'loading_entries') active @endif">
					<a href="{{ url('/ledger-book') }}"><span class="menu label c4">Customer Ledger</span></a>
			</li>

			<li class="@if($lastSegment == 'loading_entries') active @endif">
				<a href="{{ url('/incomeandexpenses') }}"><span class="menu label c4">O. Income & Expenses</span></a>
			</li>
			
			</ul>
			</div>
		{{-- <div id="left">			
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Process</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="{{ url('/customer-sale') }}">Customer Sale</a>
					</li>
					<li>
						<a href="{{ url('/payment-receive') }}">Payment Receive</a>
					</li>
					<li>
						<a href="{{ url('/customer-carret-receive') }}">Customer Carret Receive</a>
					</li>

					<li>
						<a href="{{ url('/supplier-carret-returns') }}">Supplier Carret Return</a>
					</li>

					<li>
						<a href="{{ url('/purchase-entry') }}">Purchase Entry</a>
					</li>

					<li>
						<a href="{{ url('/purchase-payment-entries') }}">Purchase Payment</a>
					</li>

					<li>
						<a href="{{ url('/loading_entries') }}">Loading</a>
					</li>


				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Plugins</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="#">Cache manager</a>
					</li>
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">Import manager</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Unlimited levels</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Contact form generator</a>
					</li>
					<li>
						<a href="#">SEO optimization</a>
					</li>
				</ul>
			</div>
			<div class="subnav">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-down"></i>
						<span>Settings</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="#">Theme settings</a>
					</li>
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">Page settings</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>Go to level 3</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Unlimited levels</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Security settings</a>
					</li>
				</ul>
			</div>
			<div class="subnav subnav-hidden">
				<div class="subnav-title">
					<a href="#" class='toggle-subnav'>
						<i class="fa fa-angle-right"></i>
						<span>Default hidden</span>
					</a>
				</div>
				<ul class="subnav-menu">
					<li>
						<a href="#">Menu</a>
					</li>
					<li class='dropdown'>
						<a href="#" data-toggle="dropdown">With submenu</a>
						<ul class="dropdown-menu">
							<li>
								<a href="#">Action #1</a>
							</li>
							<li>
								<a href="#">Antoher Link</a>
							</li>
							<li class='dropdown-submenu'>
								<a href="#" data-toggle="dropdown" class='dropdown-toggle'>More stuff</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">This is level 3</a>
									</li>
									<li>
										<a href="#">Easy to use</a>
									</li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="#">Security settings</a>
					</li>
				</ul>
			</div>
        </div> --}}
        @endauth
		<!-- Main Content -->
        @yield('content')
		<!-- End Main Content -->
	</div>


	
	

	<!-- jQuery -->
	<script src="{{ asset('public/cdn/js/jquery.min.js') }}"></script>

	<script src="{{ asset('public/cdn/js/jquery.validate.js') }}"></script>
	<!-- Nice Scroll -->
	<script src="{{ asset('public/cdn/js/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>
	<!-- imagesLoaded -->
	<script src="{{ asset('public/cdn/js/plugins/imagesLoaded/jquery.imagesloaded.min.js') }}"></script>
	<!-- jQuery UI -->
	<script src="{{ asset('public/cdn/js/plugins/jquery-ui/jquery-ui.js') }}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('public/cdn/js/bootstrap.min.js') }}"></script>
	<!-- Bootbox -->
	<script src="{{ asset('public/cdn/js/plugins/bootbox/jquery.bootbox.js') }}"></script>
	<!-- Masked inputs -->
	<script src="{{ asset('public/cdn/js/plugins/maskedinput/jquery.maskedinput.min.js') }}"></script>
	<!-- TagsInput -->
	<script src="{{ asset('public/cdn/js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
	<!-- Datepicker -->
	<script src="{{ asset('public/cdn/js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
	<!-- Daterangepicker -->
	<script src="{{ asset('public/cdn/js/plugins/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('public/cdn/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<!-- Timepicker -->
	<script src="{{ asset('public/cdn/js/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
	<!-- Colorpicker -->
	<script src="{{ asset('public/cdn/js/plugins/colorpicker/bootstrap-colorpicker.js') }}"></script>
	<!-- Chosen -->
	<script src="{{ asset('public/cdn/js/plugins/chosen/chosen.jquery.min.js') }}"></script>
	<!-- MultiSelect -->
	<script src="{{ asset('public/cdn/js/plugins/multiselect/jquery.multi-select.js') }}"></script>
	<!-- CKEditor -->
	<script src="{{ asset('public/cdn/js/plugins/ckeditor/ckeditor.js') }}"></script>
	<!-- PLUpload -->
	<script src="{{ asset('public/cdn/js/plugins/plupload/plupload.full.min.js') }}"></script>
	<script src="{{ asset('public/cdn/js/plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.min.js') }}"></script>
	<!-- Custom file upload -->
	<script src="{{ asset('public/cdn/js/plugins/fileupload/bootstrap-fileupload.min.js') }}"></script>
	<script src="{{ asset('public/cdn/js/plugins/mockjax/jquery.mockjax.js') }}"></script>
	<!-- select2 -->
	<script src="{{ asset('public/cdn/js/plugins/select2/select2.min.js') }}"></script>
	<!-- icheck -->
	<script src="{{ asset('public/cdn/js/plugins/icheck/jquery.icheck.min.js') }}"></script>
	<!-- complexify -->
	<script src="{{ asset('public/cdn/js/plugins/complexify/jquery.complexify-banlist.min.js') }}"></script>
	<script src="{{ asset('public/cdn/js/plugins/complexify/jquery.complexify.min.js') }}"></script>
	<!-- Mockjax -->
	<script src="{{ asset('public/cdn/js/plugins/mockjax/jquery.mockjax.js') }}"></script>

	<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>


	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script src="{{ asset('public/cdn/input-mask/jquery.inputmask.js') }}"></script>

	<script src="{{ asset('public/cdn/input-mask/jquery.inputmask.date.extensions.js') }}"></script>

	<script src="{{ asset('public/cdn/input-mask/jquery.inputmask.extensions.js') }}"></script>
	  

		<script>

			$(function () {
		  
			  //Initialize Select2 Elements
		  
			  $('.select2').select2()
		  
		  
		  
			  //Datemask dd/mm/yyyy
		  
			  $('.datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'DD-MM-YYYY' })
		  
			  //Datemask2 mm/dd/yyyy
		  
			  $('.datemask2').inputmask('mm-dd-yyyy', { 'placeholder': 'mm-dd-yyyy' })
		  
			  //Money Euro
		  
			  $('[data-mask]').inputmask()
		  
		  
		  
			  //Date range picker
		  
			  $('#reservation').daterangepicker()
		  
			  //Date range picker with time picker
		  
			  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
		  
			  //Date range as a button
		  
			  $('#daterange-btn').daterangepicker(
		  
				{
		  
				  ranges   : {
		  
					'Today'       : [moment(), moment()],
		  
					'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		  
					'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
		  
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		  
					'This Month'  : [moment().startOf('month'), moment().endOf('month')],
		  
					'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		  
				  },
		  
				  startDate: moment().subtract(29, 'days'),
		  
				  endDate  : moment()
		  
				},
		  
				function (start, end) {
		  
				  $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
		  
				}
		  
			  )
		  
		  
		  
			  //Date picker
		  
			  $('#datepicker').datepicker({
		  
				autoclose: true
		  
			  })
		  
		  
		  
			  //iCheck for checkbox and radio inputs
		  
			  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		  
				checkboxClass: 'icheckbox_minimal-blue',
		  
				radioClass   : 'iradio_minimal-blue'
		  
			  })
		  
			  //Red color scheme for iCheck
		  
			  $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
		  
				checkboxClass: 'icheckbox_minimal-red',
		  
				radioClass   : 'iradio_minimal-red'
		  
			  })
		  
			  //Flat red color scheme for iCheck
		  
			  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  
				checkboxClass: 'icheckbox_flat-green',
		  
				radioClass   : 'iradio_flat-green'
		  
			  })
		  
		  
		  
			  //Colorpicker
		  
			  $('.my-colorpicker1').colorpicker()
		  
			  //color picker with addon
		  
			  $('.my-colorpicker2').colorpicker()
		  
		  
		  
			  //Timepicker
		  
			  $('.timepicker').timepicker({
		  
				showInputs: false
		  
			  })
		  
			})
		  
		  </script>


	  <script>
		jQuery(function($) {
		// $(document).on('click', '#date', function () { 
		// 	var me = $("#date");   
		// 	me.datepicker({
		// 		showOn: 'focus',
		// 		altFormat: "dd-mm-yy",
		// 		dateFormat: "dd-mm-yy",
		// 	}).focus();
		// });		

	
			
		$(document).ready(function() {
		$('.js-select2').select2();
		});

		$('#myTable2').DataTable();

		$('#pagingFalseDataTable').dataTable({
		"paging": false
		});

	});
	</script>

<script>
	$(function() {
	  $('input[name="daterange"]').daterangepicker({
		opens: 'left'
	  }, function(start, end, label) {
		console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	  });
	});
	</script>


</body>



</html>


