@extends('layouts.app')
@section('content')
		
<div class="container-fluid">
	<div class="page-header">
		<div class="pull-left">
			<h1>Dashboard</h1>
		</div>
		<div class="pull-right">
			<ul class="minitiles">
				<li class='grey'>
					<a href="#">
						<i class="fa fa-cogs"></i>
					</a>
				</li>
				<li class='lightgrey'>
					<a href="#">
						<i class="fa fa-globe"></i>
					</a>
				</li>
			</ul>
			<ul class="stats">
				<li class='satgreen'>
					<i class="fa fa-money"></i>
					<div class="details">
						<span class="big">$324,12</span>
						<span>Balance</span>
					</div>
				</li>
				<li class='lightred'>
					<i class="fa fa-calendar"></i>
					<div class="details">
						<span class="big">February 22, 2013</span>
						<span>Wednesday, 13:56</span>
					</div>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<ul class="tiles">
				<li class="orange high long">
					<a href="#">
						<span class='count'>
							<i class="fa fa-shopping-cart"></i>8</span>
						<span class='name'>New orders</span>
					</a>
				</li>
				<li class="blue">
					<a href="#">
						<span>
							<i class="fa fa-phone"></i>
						</span>
						<span class='name'>Phone</span>
					</a>
				</li>
				<li class="red">
					<a href="#">
						<span class='count'>
							<i class="fa fa-envelope"></i>1</span>
						<span class='name'>Mails</span>
					</a>
				</li>
				<li class="lime">
					<a href="#">
						<span class='count'>
							<i class="fa fa-comment"></i>4</span>
						<span class='name'>Comments</span>
					</a>
				</li>
				<li class="image">
					<a href="#">
						<img src="img/demo/user-1.jpg" alt="">
						<span class='name'>Jane Doe</span>
					</a>
				</li>
				<li class="blue long">
					<a href="#">
						<span class='nopadding'>
							<h5>@eakroko</h5>
							<p>Check the new Flat theme on themeforest. Incredible fast and easy to use.</p>
						</span>
						<span class='name'>
							<i class="fa fa-twitter"></i>
							<span class="right">1min ago</span>
						</span>
					</a>
				</li>
				<li class="green long">
					<a href="#">
						<span>
							<i class="fa fa-globe"></i>
						</span>
						<span class='name'>User regions</span>
					</a>
				</li>
				<li class="brown">
					<a href="#">
						<span class='count'>
							<i class="fa fa-bolt"></i>3</span>
						<span class='name'>Warnings</span>
					</a>
				</li>
				<li class="teal long">
					<a href="#">
						<span class='count'>
							<i class="fa fa-cloud-upload"></i>12</span>
						<span class='name'>New uploads</span>
					</a>
				</li>
				<li class="blue">
					<a href="#">
						<span>
							<i class="fa fa-cogs"></i>
						</span>
						<span class='name'>Settings</span>
					</a>
				</li>
				<li class="magenta">
					<a href="#">
						<span>
							<i class="fa fa-star"></i>
						</span>
						<span class='name'>Ratings</span>
					</a>
				</li>
				<li class="pink long">
					<a href="#">
						<span>
							<i class="fa fa-money"></i>
						</span>
						<span class='name'>Balance</span>
					</a>
				</li>
				<li class="blue">
					<a href="#">
						<span>
							<i class="fa fa-wrench"></i>
						</span>
						<span class='name'>Optimize site</span>
					</a>
				</li>
				<li class="lime">
					<a href="#">
						<span>
							<i class="fa fa-dashboard"></i>
						</span>
						<span class='name'>Dashboard</span>
					</a>
				</li>
				<li class="orange">
					<a href="#">
						<span>
							<i class="fa fa-sign-out"></i>
						</span>
						<span class='name'>Sign out</span>
					</a>
				</li>
				<li class="red long">
					<a href="#">
						<span>
							<i class="fa fa-eye-open"></i>
						</span>
						<span class='name'>Preview changes</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="box box-color box-bordered">
				<div class="box-title">
					<h3>
						<i class="fa fa-th-large"></i>
						More tiles
					</h3>
				</div>
				<div class="box-content">
					<ul class="minitiles">
						<li class='teal'>
							<a href="#">
								<i class="fa fa-inbox"></i>
							</a>
						</li>
						<li class='red'>
							<a href="#">
								<i class="fa fa-cogs"></i>
							</a>
						</li>
						<li class='lime'>
							<a href="#">
								<i class="fa fa-globe"></i>
							</a>
						</li>
					</ul>
					<ul class="stats">
						<li class='blue'>
							<i class="fa fa-shopping-cart"></i>
							<div class="details">
								<span class="big">175</span>
								<span>New orders</span>
							</div>
						</li>
						<li class='green'>
							<i class="fa fa-money"></i>
							<div class="details">
								<span class="big">$324,12</span>
								<span>Balance</span>
							</div>
						</li>
						<li class='orange'>
							<i class="fa fa-calendar"></i>
							<div class="details">
								<span class="big">February 22, 2013</span>
								<span>Wednesday, 13:56</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection