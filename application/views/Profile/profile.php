<?php $this->load->view('components/header') ?>


<div class="col-lg-7 mt-lg-0 mt-4 mx-auto">
	<div class="card card-body" id="profile">
		<div class="row">
			<div class="col-sm-auto col-4">
				<div class="avatar avatar-xl position-relative">
					<img src="<?= site_url() ?>public/img/jne_profil.png" alt="bruce" class="w-100 rounded-circle shadow-sm" style="object-fit: cover; width: 100%; height: 100%;">
				</div>
			</div>
			<div class="col-sm-auto col-8 my-auto">
				<div class="h-100">
					<h5 class="mb-1 font-weight-bolder">
						<?= $data_user['username'] ?>
					</h5>
					<p class="mb-0 font-weight-normal text-sm">
						<?= $data_user['role'] ?>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="card mt-4" id="basic-info">
		<div class="card-header">
			<h5>Change Username</h5>
		</div>
		<div class="card-body pt-0">
			<div class="row">
				<div class="col">
					<form action="" method="POST">
						<input type="hidden" name="form_type" value="change_username">


						<input type="hidden" value="<?= $data_user['id_user'] ?>" name="id">
						<div class="input-group input-group-static">
							<label>Username</label>
							<input type="text" class="form-control" placeholder="Enter Username" value="<?= $data_user['username'] ?>" name="username">
						</div>
				</div>
				<button type="submit" class="btn bg-gradient-info btn-sm float-end mt-4 mb-0 col-auto">Update Username</button>
				<?= form_error('username', '<small class="text-danger">', '</small>') ?>
				</form>
			</div>

		</div>
	</div>

	<?php if ($this->session->flashdata('notifSuccess')) :  ?>
		<div class="alert alert-success alert-dismissible text-white fade show mt-3" role="alert">
			<span class="alert-icon align-middle">
				<i class="bi bi-check"></i>
			</span>
			<span class="alert-text"><strong>Password</strong> <?= $this->session->flashdata('notifSuccess') ?></span>
			<button type="button" class="btn-close fs-4" data-bs-dismiss="alert" aria-label="Close" style="margin-top: -10px;">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

	<div class="card mt-4">
		<div class="card-header">
			<h5>Change Password</h5>
		</div>
		<div class="card-body pt-0">
			<form action="" method="POST">
				<input type="hidden" name="form_type" value="change_password">

				<div class="input-group input-group-outline">
					<input type="password" class="form-control" placeholder="Current password" name="current_pass">
				</div>
				<?= form_error('current_pass', '<small class="text-danger ms-1">', '</small>') ?>
				<?php if ($this->session->flashdata('current_error')): ?>
					<?= $this->session->flashdata('current_error') ?>
				<?php endif ?>

				<div class="input-group input-group-outline mt-4">
					<input type="password" class="form-control" placeholder="New Password" name="new_pass1">
				</div>
				<?= form_error('new_pass1', '<small class="text-danger ms-1">', '</small>') ?>
				<?php if ($this->session->flashdata('pass_error')): ?>
					<?= $this->session->flashdata('pass_error') ?>
				<?php endif ?>

				<div class="input-group input-group-outline mt-4">
					<input type="password" class="form-control" placeholder="Confirm New password" name="new_pass2">
				</div>
				<?= form_error('new_pass2', '<small class="text-danger ms-1">', '</small>') ?>

				<button type="submit" class="btn bg-gradient-info btn-sm float-end mt-4 mb-0">Update password</button>
			</form>
		</div>
	</div>


</div>

<?php $this->load->view('components/footer') ?>
