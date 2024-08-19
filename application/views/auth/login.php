<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>
		Material Dashboard 2 by Creative Tim
	</title>
	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
	<!-- Nucleo Icons -->
	<link href="<?= site_url() ?>public/css/nucleo-icons.css" rel="stylesheet" />
	<link href="<?= site_url() ?>public/css/nucleo-svg.css" rel="stylesheet" />
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<!-- Material Icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
	<!-- CSS Files -->
	<link id="pagestyle" href="<?= site_url() ?>public/css/material-dashboard.css" rel="stylesheet" />
</head>

<body class="bg-gray-200">

	<main class="main-content  mt-0">
		<div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
			<span class="mask bg-gradient-dark opacity-6"></span>
			<div class="container my-auto">
				<div class="row">
					<div class="col-lg-4 col-md-8 col-12 mx-auto">
						<div class="card z-index-0 fadeIn1 fadeInBottom">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-info shadow-info border-radius-md py-3 pe-1">
									<h4 class="text-white fw-bold text-center mb-0">LOGIN</h4>
								</div>
							</div>
							<div class="card-body">

								<form role="form" class="text-start" method="POST" action="<?= site_url() ?>auth">
									<div class="input-group input-group-outline my-3">
										<input type="text" class="form-control" placeholder="Username" name="username" autofocus>
									</div>
									<div class="input-group input-group-outline mb-3">
										<input type="password" class="form-control" placeholder="Password" name="password">
									</div>

									<?= form_error('username', '<small class="text-danger">', '</small>') ?>
									<?= form_error('password', '<small class="text-danger">', '</small>') ?>
									<?= $this->session->flashdata('message'); ?>

									<div class="text-center">
										<button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2">Sign in</button>
									</div>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer position-absolute bottom-2 py-2 w-100">
				<div class="container">
					<div class="row align-items-center justify-content-lg-between">
						<div class="col-12 col-md-6 my-auto">
							<div class="copyright text-center text-sm text-white text-lg-start">
								<p>
									© <script>
										document.write(new Date().getFullYear())
									</script>,
									Made with <span style="color: #e25555;">♥</span> by <strong>IT Project & PKL</strong>
								</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</main>

</body>

</html>
