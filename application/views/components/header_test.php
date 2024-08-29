<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
	<title>
		<?= $title ?>
	</title>
	<link rel="icon" href="https://www.jne.co.id/cfind/source/images/logo-white.svg" type="image/x-icon">


	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

	<!-- Nucleo Icons -->
	<link href="<?= base_url() ?>public/css/nucleo-icons.css" rel="stylesheet" />
	<link href="<?= base_url() ?>public/css/nucleo-svg.css" rel="stylesheet" />

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

	<!-- Material Icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

	<!-- CSS Files -->
	<link id="pagestyle" href="<?= base_url() ?>public/css/material-dashboard.css" rel="stylesheet" />

</head>

<body class="g-sidenav-show bg-gray-200">

	<!-- seting background sidebar -->
	<style>
		.bg-sidebar {
			background-image: url(<?= base_url('public/img/nature.jpeg') ?>);
			background-size: cover;
			background-position: center;
			position: relative;
			z-index: 3;
		}

		.bg-sidebar::before {
			content: '';
			position: absolute;
			width: 100%;
			height: 100%;
			background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 1));
			z-index: -1;
		}
	</style>

	<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark ps ps--active-y bg-white" id="sidenav-main">
		<div class="sidenav-header">
			<i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-xl-none" aria-hidden="true" id="iconSidenav"></i>
			<a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard-pro/pages/dashboards/analytics.html " target="_blank">
				<img src="../../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
				<span class="ms-1 font-weight-bold text-white">Material Dashboard 2 PRO</span>
			</a>
		</div>
		<hr class="horizontal light mt-0 mb-2">
		<div class="collapse navbar-collapse w-auto h-auto ps" id="sidenav-collapse-main">
			<ul class="navbar-nav">
				<li class="nav-item mb-2 mt-0">
					<a data-bs-toggle="collapse" href="#ProfileNav" class="nav-link text-white" aria-controls="ProfileNav" role="button" aria-expanded="false">
						<img src="../../assets/img/team-3.jpg" class="avatar">
						<span class="nav-link-text ms-2 ps-1">Brooklyn Alice</span>
					</a>
					<div class="collapse" id="ProfileNav" style="">
						<ul class="nav ">
							<li class="nav-item">
								<a class="nav-link text-white" href="../../pages/pages/profile/overview.html">
									<span class="sidenav-mini-icon"> MP </span>
									<span class="sidenav-normal  ms-3  ps-1"> My Profile </span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-white " href="../../pages/pages/account/settings.html">
									<span class="sidenav-mini-icon"> S </span>
									<span class="sidenav-normal  ms-3  ps-1"> Settings </span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-white " href="../../pages/authentication/signin/basic.html">
									<span class="sidenav-mini-icon"> L </span>
									<span class="sidenav-normal  ms-3  ps-1"> Logout </span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<hr class="horizontal light mt-0">
				<li class="nav-item">
					<a data-bs-toggle="collapse" href="#dashboardsExamples" class="nav-link text-white active" aria-controls="dashboardsExamples" role="button" aria-expanded="false">
						<i class="material-icons-round opacity-10">dashboard</i>
						<span class="nav-link-text ms-2 ps-1">Dashboards</span>
					</a>
					<div class="collapse  show " id="dashboardsExamples">
						<ul class="nav ">
							<li class="nav-item active">
								<a class="nav-link text-white active" href="../../pages/dashboards/analytics.html">
									<span class="sidenav-mini-icon"> A </span>
									<span class="sidenav-normal  ms-2  ps-1"> Analytics </span>
								</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link text-white " href="../../pages/dashboards/discover.html">
									<span class="sidenav-mini-icon"> D </span>
									<span class="sidenav-normal  ms-2  ps-1"> Discover </span>
								</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link text-white " href="../../pages/dashboards/sales.html">
									<span class="sidenav-mini-icon"> S </span>
									<span class="sidenav-normal  ms-2  ps-1"> Sales </span>
								</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link text-white " href="../../pages/dashboards/automotive.html">
									<span class="sidenav-mini-icon"> A </span>
									<span class="sidenav-normal  ms-2  ps-1"> Automotive </span>
								</a>
							</li>
							<li class="nav-item ">
								<a class="nav-link text-white " href="../../pages/dashboards/smart-home.html">
									<span class="sidenav-mini-icon"> S </span>
									<span class="sidenav-normal  ms-2  ps-1"> Smart Home </span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				
			</ul>
			<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
				<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
			</div>
			<div class="ps__rail-y" style="top: 0px; right: 0px;">
				<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
			</div>
		</div>
		<div class="ps__rail-x" style="left: 0px; bottom: -65px;">
			<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
		</div>
		<div class="ps__rail-y" style="top: 65px; height: 644px; right: 0px;">
			<div class="ps__thumb-y" tabindex="0" style="top: 45px; height: 448px;"></div>
		</div>
	</aside>


	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<!-- Navbar -->
		<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
			<div class="container-fluid py-1 px-3">
				<nav aria-label="breadcrumb">
				</nav>
				<div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
					<div class="ms-md-auto pe-md-3 d-flex align-items-center">

						<a href="javascript:;" class="nav-link text-body d-md-none pb-0 me-3 mb-2" id="iconNavbarSidenav">
							<div class="sidenav-toggler-inner">
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
							</div>
						</a>

						<script>
							document.getElementById('iconNavbarSidenav').addEventListener('click', function() {
								var body = document.querySelector('body');
								var sidenav = document.querySelector('.sidenav');

								if (body.classList.contains('g-sidenav-pinned')) {
									body.classList.remove('g-sidenav-pinned');
									sidenav.classList.remove('bg-white');
								} else {
									body.classList.add('g-sidenav-pinned');
									sidenav.classList.add('bg-white');
								}
							});
						</script>

						<a href="" class="me-4">
							<i class="material-icons">dashboard</i>
						</a>
						<a href="<?= site_url() ?>p" class="me-4">
							<i class="material-icons">person</i>
						</a>

						<a href="<?= site_url() ?>auth/logout" onclick="return confirm('Anda akan Logout, yakin?')">
							<i class="material-icons">logout</i>
						</a>

					</div>
				</div>
			</div>
		</nav>
		<!-- End Navbar -->

		<div class="container-fluid py-4">
