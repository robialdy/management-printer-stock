<?php $this->load->view('components/header') ?>

<?php if ($this->session->flashdata('notifSuccess')) :  ?>
	<script>
		window.onload = function() {
			showSuccessMessage();
		};
	</script>
<?php endif; ?>

<script>
	function showSuccessMessage() {
		Swal.fire({
			icon: 'success',
			text: '<?= $this->session->flashdata('notifSuccess') ?>',
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3500,
			timerProgressBar: true,
			width: 450,
			padding: '1em',
			iconColor: '#4CAF50', // Warna ikon success yang lebih menonjol
			didOpen: (toast) => {
				toast.style.borderRadius = '8px'; // Membuat sudut lebih halus
				toast.style.boxShadow = '0px 4px 15px rgba(0, 0, 0, 0.2)'; // Efek shadow untuk floating
				document.querySelector('.swal2-container').style.pointerEvents = 'none'; // Menghindari block area di luar toast
			}
		});
	}
</script>


<div class="row">
	<div class="card w-30 ms-5">
		<div class="card-body text-center">
			<h1 class="text-gradient text-info"><span id="status1" countto="<?= $jumUsers ?>"><?= $jumUsers ?></span> <span class="text-lg ms-n2">Pcs</span></h1>
			<h6 class="mb-0 font-weight-bolder">Users</h6>
			<p class="opacity-8 mb-0 text-sm">
				<?php if (!empty($dateTime->created_at)): ?>
					<?= $dateTime->created_at ?>
				<?php else: ?>
					null
				<?php endif; ?>
			</p>
		</div>
	</div>
</div>

<!-- animasi count -->
<script src="<?= base_url() ?>public/js/plugins/countup.min.js"></script>
<script>
	if (document.getElementById('status1')) {
		const countUp = new CountUp('status1', document.getElementById("status1").getAttribute("countTo"));
		if (!countUp.error) {
			countUp.start();
		} else {
			console.error(countUp.error);
		}
	}
</script>

<!-- Button trigger modal -->
<div class="text-end me-5">
	<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalInsert">
		<i class="bi bi-people me-2"></i>ADD USER
	</button>
</div>

<!-- Modal -->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">USER</h5>
					<small>Silahkan Menginput Data User</small>
				</div>
			</div>
			<div class="modal-body">
				<?= form_open('users') ?>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">USERNAME <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-2">
							<input type="text" class="form-control" aria-label="Username" placeholder="Enter username" aria-describedby="basic-addon1" id="sn" name="username" style="text-transform: uppercase;" onkeypress="return event.charCode != 32" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">ROLE <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-static mb-1">
							<select class="choices form-select" id="exampleFormControlSelect1" name="role" required>
								<option value="" selected disabled>SELECT ROLE ACCOUNT</option>
								<option value="ADMIN"></option>ADMIN</option>
								<option value="SUPER ADMIN"></option>SUPER ADMIN</option>
							</select>
						</div>
					</div>
				</div>


				<div class="row position-relative">
					<div class="col-4 mt-2">
						<label for="sn">PASSWORD <span class="text-danger">*</span></label>
					</div>
					<div class="col-7">
						<div class="input-group input-group-dynamic mb-2">
							<input type="password" class="form-control" aria-label="Password" placeholder="Enter Password" id="password" name="password1" minlength="8" required>
						</div>
						<span id="toggle-password" style="cursor: pointer; position: absolute; right: 15px; top: 50%; transform: translateY(-50%);">
							<i class="material-icons" style="font-size: 1.5rem;">visibility_off</i>
						</span>
					</div>
				</div>

				<script>
					document.addEventListener('DOMContentLoaded', function() {
						const passwordInput = document.getElementById('password');
						const togglePassword = document.getElementById('toggle-password');
						const icon = togglePassword.querySelector('i');

						togglePassword.addEventListener('click', function() {
							// Toggle the type attribute
							const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
							passwordInput.setAttribute('type', type);

							// Toggle the icon
							icon.textContent = type === 'password' ? 'visibility_off' : 'visibility';
						});
					});
				</script>



				<div class="text-end mt-3">
					<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
				</div>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div>

<style>
	/* css di file sistem material-dashboard.css */
	.dataTable-wrapper .dataTable-container .table tbody tr td {
		padding: .75rem 1.5rem
	}
</style>

<div class="row">
	<div class="col-6">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">User Account Admin</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable-search">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">No</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">Username</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">Created At</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7"></th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($read_data_a as $rd) : ?>
								<tr>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-bold"><?= $i; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rd['username'] ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rd['created_at'] ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<?php if ($data_user['username'] != $rd['username']) : ?>
											<form action="<?= site_url('delete/') . $rd['username'] ?>" method="post">
												<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
												<button type="submit" class="btn p-0 mb-1" onclick="return confirm('Yakin ingin menghapus user ini?')">
													<i class="material-icons text-secondary">delete</i>
												</button>
											</form>
										<?php endif; ?>
									</td>
								</tr>
								<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-6">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">User Account Super Admin</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable-search2">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">No</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">Username</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">Created At</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7"></th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($read_data_m as $rd) : ?>
								<tr>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-bold"><?= $i; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rd['username'] ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rd['created_at'] ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<?php if ($data_user['username'] != $rd['username']) : ?>
											<form action="<?= site_url('delete/') . $rd['username'] ?>" method="post">
												<button type="submit" class="btn p-0 mb-1" onclick="return confirm('Yakin ingin menghapus user ini?')">
													<i class="material-icons text-secondary">delete</i>
												</button>
											</form>
										<?php endif; ?>
									</td>
								</tr>
								<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('components/footer') ?>
