<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>
		Login
	</title>
	<link rel="icon" href="<?= base_url('public/img/printer.png') ?>" type="image/x-icon">
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
		<div class="page-header align-items-start min-vh-100" style="background-image: url('<?= base_url('public/img/cover_w1296_h540_banner-web-jne_page-0001.jpg') ?>');">
			<span class="mask bg-gradient-dark opacity-6"></span>
			<div class="container my-auto">
				<div class="row">
					<div class="col-lg-4 col-md-8 col-12 mx-auto">
						<div class="card z-index-0 shadow-lg">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-danger shadow-danger border-radius-md py-3 pe-1">
									<h4 class="text-white fw-bold text-center mb-0">LOGIN</h4>
								</div>
							</div>
							<div class="card-body">

								<form role="form" class="text-start" method="POST" action="<?= site_url() ?>auth">
									<div class="input-group input-group-outline my-3">
										<input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
									</div>
									<div class="input-group input-group-outline mb-3">
										<input type="password" class="form-control" placeholder="Password" name="password" id="password1" required>
										<span id="toggle-password" class="mt-1" style="cursor: pointer;">
											<i class="material-icons p-1 ms-2" style="font-size: 1.5rem;">visibility_off</i>
										</span>
									</div>

									<!-- yang berfungsi ini -->
									<?= $this->session->flashdata('message'); ?>

									<div class="text-center">
										<button type="submit" class="btn shadow-lg w-100 my-4 mb-2 text-info">Login</button>
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

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const passwordInput = document.getElementById('password1');
			const togglePassword = document.getElementById('toggle-password');
			const icon = togglePassword.querySelector('i');

			togglePassword.addEventListener('click', function() {
				const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordInput.setAttribute('type', type);

				icon.textContent = type === 'password' ? 'visibility_off' : 'visibility';
			});
		});
	</script>

</body>

</html>
