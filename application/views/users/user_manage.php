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
			title: 'Good job!',
			text: '<?= $this->session->flashdata('notifSuccess') ?>',
			confirmButtonText: 'OK'
		});
	}
</script>


<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2" style="height: 200px;">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $jumUsers ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Users</p>
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (!empty($dateTime->created_at)): ?>
							<?= $dateTime->created_at ?>
						<?php else: ?>
							null
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

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
				<form method="POST" action="<?= site_url() ?>users">

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">USERNAME <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter username" aria-describedby="basic-addon1" id="sn" name="username" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">ROLE <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="exampleFormControlSelect1" name="role" required>
									<option value="" selected disabled>SELECT ROLE ACCOUNT</option>
									<option value="ADMIN"></option>ADMIN</option>
									<option value="SUPER ADMIN"></option>SUPER ADMIN</option>
								</select>
							</div>
						</div>
					</div>


					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">PASSWORD <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="password" class="form-control" aria-label="Username" placeholder="Enter Password" aria-describedby="basic-addon1" id="sn" name="password1" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">RE-PASSWORD <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="password" class="form-control" aria-label="Username" placeholder="Enter Re-Password" aria-describedby="basic-addon1" id="sn" name="password2" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<div class="text-end mt-3">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
					</div>
				</form>
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
										<a href="<?= site_url('delete/') . $rd['username'] ?>" onclick="return confirm('Apakah anda yakin data user akan dihapus?');">
											<i class="material-icons text-secondary position-relative text-lg">delete</i>
										</a>
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
					<h6 class="text-white ps-3 fw-light">User Account Moderator</h6>
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
										<a href="<?= site_url('delete/') . $rd['username'] ?>" onclick="return confirm('Apakah anda yakin data user akan dihapus?');">
											<i class="material-icons text-secondary position-relative text-lg">delete</i>
										</a>
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
