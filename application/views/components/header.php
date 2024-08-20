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
			background-image: url('public/img/nature.jpeg');
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

	<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-gradient-dark  bg-sidebar" id="sidenav-main">
		<div class="sidenav-header">
			<i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
			<a class="navbar-brand m-0" href="<?= base_url() ?>">
				<h6 class="fw-light text-white">Printer Management Stock</h6>
			</a>
		</div>
		<hr class="horizontal light mt-0 mb-1">
		<div class="d-flex align-items-center py-3 ms-4">
			<a href="<?= site_url() ?>p" class="d-flex align-items-center">
				<img src="<?= site_url() ?>public/img/jne_profil.png" class="rounded-circle mr-2 me-2" alt="Profile Image" width="34">
				<h5 class="mb-0 text-white fw-light fs-6"><?= $data_user['username']; ?></h5>
			</a>
		</div>
		<hr class="horizontal light mt-0 mb-2">
		<div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link text-white <?= ($this->uri->segment(1) == '') ? 'active bg-info' : ''; ?>" href="<?= site_url() ?>">
						<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
							<i class="material-icons opacity-10">dashboard</i>
						</div>
						<span class="nav-link-text ms-1">Dashboard</span>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link text-white <?= ($this->uri->segment(1) == 'printer') ? 'active bg-info' : ''; ?>" href="<?= site_url('printer') ?>">
						<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
							<i class="material-icons">format_list_bulleted</i>
						</div>
						<span class="nav-link-text ms-1">Printer Backup List</span>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link text-white <?= ($this->uri->segment(1) == 'replacement') ? 'active bg-info' : ''; ?>" href="<?= site_url('replacement') ?>">
						<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
							<i class="material-icons">format_list_bulleted</i>
						</div>
						<span class="nav-link-text ms-1">Printer Replacement</span>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link text-white <?= ($this->uri->segment(1) == 'agen') ? 'active bg-info' : ''; ?>" href="<?= site_url('agen') ?>">
						<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
							<i class="material-icons">business</i>
						</div>
						<span class="nav-link-text ms-1">Master Data Customer</span>
					</a>
				</li>

				<?php if ($data_user['role'] === 'MODERATOR'): ?>
					<li class="nav-item">
						<a class="nav-link text-white <?= ($this->uri->segment(1) == 'users') ? 'active bg-info' : ''; ?>" href="<?= site_url('users') ?>">
							<div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
								<i class="material-icons">people</i>
							</div>
							<span class="nav-link-text ms-1">User Manage</span>
						</a>
					</li>
				<?php endif ?>

			</ul>
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
