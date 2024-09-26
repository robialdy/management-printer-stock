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
			text: '<?= $this->session->flashdata('notifSuccess') ?>!',
			confirmButtonText: 'OK'
		});
	}
</script>

<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2 " style="height: 200px;">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $sum_damage ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Damage Backup</p>
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (empty($date_time->created_at) || $sum_damage == 0): ?>
							null
						<?php else: ?>
							<?= $date_time->created_at ?>
						<?php endif; ?>
					</p>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row justify-content-end">
	<div class="col-auto">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#add_nodummy">
			<i class="material-icons me-2">build</i>ADD NO DUMMY
		</button>
	</div>
	<div class="col-auto me-5">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#add_perbaikan">
			<i class="material-icons me-2">build</i>ADD PERBAIKAN
		</button>
	</div>
</div>

<div class="modal fade" id="add_nodummy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">ADD NO DUMMY</h5>
					<small>Silahkan Menginput Data Untuk No Dummy</small>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?= site_url('printerdamage/add_nodummy') ?>">

					<label for="sn" class="text-dark">PRINTER S/N <span class="text-danger">*</span></label>
					<div class="input-group">
						<select class="form-select" id="printersn" name="idprinter[]" multiple required>
							<option value="" disabled>Select Printer Sn *</option>
							<?php foreach ($damage_perbaikan as $dm) : ?>
								<option value="<?= $dm->id_printer; ?>"><?= $dm->printer_sn; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<script>
						document.addEventListener('DOMContentLoaded', function() {
							const choices = new Choices('#printersn', {
								removeItemButton: true, // Tombol untuk menghapus item yang dipilih
								searchEnabled: true, // Aktifkan pencarian
								shouldSort: false, // Nonaktifkan pengurutan
								placeholder: true, // Menampilkan placeholder
								placeholderValue: 'SELECT PRINTER SN', // Teks placeholder
							});
						});
					</script>

					<label for="sn" class="text-dark">NO DUMMY <span class="text-danger">*</span></label>
					<div class="input-group input-group-dynamic mb-3">
						<input type="int" class="form-control" name="nodummy" placeholder="ENTER NO DUMMY" required>
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

<!-- Modal -->
<div class="modal fade" id="add_perbaikan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">ADD PERBAIKAN</h5>
					<small>Silahkan Menginput Data Untuk Perbaikan Printer</small>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?= site_url('printerdamage/add_perbaikan') ?>">

					<div class="row align-items-center mb-2">
						<div class="col-4">
							<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic">
								<select class="form-select" id="printersn" name="printersn[]" multiple required>
									<option value="" disabled>Select Printer SN</option>
									<?php foreach ($damage_perbaikan as $dm) : ?>
										<option value="<?= $dm->id_printer; ?>"><?= $dm->printer_sn; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>



					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">PIC IT <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-3">
								<input type="text" class="form-control" name="pic_it" placeholder="ENTER PIC IT" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">KELENGKAPAN</label>
						</div>
						<div class="col mt-2">

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="dus" value="DUS">
									<label class="form-check-label" for="dus">
										DUS
									</label>
								</div>
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="usb" value="KABEL USB">
									<label class="form-check-label" for="usb">
										KABEL USB
									</label>
								</div>
							</div>

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="corelabel" value="CORE LABEL 1">
									<label class="form-check-label" for="corelabel">
										CORE LABEL 1
									</label>
								</div>
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="adaptor" value="ADAPTOR">
									<label class="form-check-label" for="adaptor">
										ADAPTOR
									</label>
								</div>
							</div>

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="coreribbon" value="CORE RIBBON 2">
									<label class="form-check-label" for="coreribbon">
										CORE RIBBON 2
									</label>
								</div>
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="kuping" value="KUPING CORE 2">
									<label class="form-check-label" for="kuping">
										KUPING CORE 2
									</label>
								</div>
							</div>

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="power" value="KABEL POWER">
									<label class="form-check-label" for="power">
										KABEL POWER
									</label>
								</div>
							</div>

							<!-- Checkbox untuk memilih semua -->
							<div class="row mt-1">
								<div class="form-check col">
									<input class="" type="checkbox" id="masterCheckbox">
									<label class="form-check-label" for="masterCheckbox">
										PILIH SEMUA
										<i class="material-icons text-info">done_all</i>
									</label>
								</div>
							</div>
						</div>
					</div>

					<script>
						// Ambil checkbox utama
						var masterCheckbox = document.getElementById('masterCheckbox');

						// Tambahkan event listener untuk checkbox utama
						masterCheckbox.addEventListener('click', function() {
							// Ambil semua checkbox dengan class 'childCheckbox'
							var checkboxes = document.querySelectorAll('.childCheckbox');

							checkboxes.forEach(function(checkbox) {
								checkbox.checked = masterCheckbox.checked;
							});
						});
					</script>

					<div class="text-end mt-3">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- style td lebih lebar -->
<style>
	.table-sm td {
		padding-top: 15px !important;
		padding-bottom: 15px !important;
	}
</style>

<div class=" row">
	<div class="col-12">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-3 pb-1 d-flex justify-content-between align-items-center">
					<h6 class="text-white ps-3 fw-light pb-2">Printer Replacement</h6>
					<a href="<?= base_url('printerdamage/export_excel') ?>" class="btn bg-white shadow me-3">
						<i class="material-icons pe-2">assignment</i>EXCEL
					</a>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table table-sm align-items-center table-hover" id="datatable-search">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">No</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">origin</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">date in</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">type printer</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">printer sn</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">return cgk</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">cust id</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">cust name</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">type cust</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">pic it</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">biaya</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">no dummy</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">note</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">status</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2"></th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2"></th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2"></th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($damage as $dm): ?>
								<tr>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-bold"><?= $i++; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->origin ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->date_in ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->name_type ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->printer_sn ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->return_cgk ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal text-wrap"><?= $dm->cust_id ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->cust_name ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->type_cust ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->pic_it ?></h6>
									</td>
									<td class="text-center">
										<h6 class="mb-0 text-sm fw-normal">
											<?php if ($dm->biaya_perbaikan != null) : ?>
												Rp.<?= number_format($dm->biaya_perbaikan, 2, ',', '.') ?>
											<?php else : ?>
												-
											<?php endif; ?>
										</h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->no_dummy ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->note ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $dm->status_pembayaran ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<a class="mb-0 text-sm fw-normal" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#kelengkapan-<?= $dm->id_damage ?>">
											<i class="material-icons">assignment</i>
										</a>
									</td>
									<td class="text-center">
										<a class="mb-0 text-sm fw-normal" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#file-<?= $dm->id_damage ?>">
											<i class="material-icons">cloud_upload</i>
										</a>
									</td>
									<td class="text-center">
										<a class="mb-0 text-sm fw-normal" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#edit-<?= $dm->id_damage ?>">
											<i class="material-icons">edit</i>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal edit-->
<?php foreach ($damage as $dm) : ?>
	<div class="modal fade" id="edit-<?= $dm->id_damage ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">EDIT</h5>
					<small>Silahkan Edit Data Untuk Perbaikan Printer</small>
				</div>
				<div class="modal-body">
					<form method="POST" action="<?= site_url('printerdamage/edit') ?>">

						<input type="hidden" name="id_damage" value="<?= $dm->id_damage ?>">

						<div class="row">
							<div class="col-4 mt-2">
								<label for="biaya">BIAYA PERBAIKAN <span class="text-danger">*</span></label>
							</div>
							<div class="col">
								<div class="input-group input-group-dynamic mb-3">
									<input type="number" class="form-control" name="biaya" value="<?= $dm->biaya_perbaikan ?>" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-4 mt-2">
								<label for="status_pembayaran">STATUS PEMBAYARAN <span class="text-danger">*</span></label>
							</div>
							<div class="col mt-3">
								<div class="row">
									<div class="form-check col">
										<input type="radio" name="status_pembayaran" id="ssbayar" value="SUDAH BAYAR" <?= $dm->status_pembayaran == "SUDAH BAYAR" ? 'checked' : '' ?> required>
										<label class="form-check-label" for="ssbayar">
											SUDAH BAYAR
										</label>
									</div>
									<div class="form-check col">
										<input type="radio" name="status_pembayaran" id="bbbayar" value="BELUM BAYAR" <?= $dm->status_pembayaran == "BELUM BAYAR" ? 'checked' : '' ?>>
										<label class="form-check-label" for="bbbayar">
											BELUM BAYAR
										</label>
									</div>
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
<?php endforeach; ?>

<!-- Modal file-->
<?php foreach ($damage as $dm) : ?>
	<div class="modal fade" id="file-<?= $dm->id_damage ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">LAPORAN DARI JAKARTA</h5>
					<small>Lampiran Terkait Dari Jakarta</small>
				</div>
				<div class="modal-body">

					<div class="mx-1 mb-4">
						<blockquote class="blockquote" style="max-width: 100%; margin: auto;">
							<form action="<?= site_url('printerdamage/upload_file') ?>" method="POST" enctype="multipart/form-data" class="d-flex w-100 gap-2 align-items-center">
								<input type="hidden" name="id_damage" value="<?= $dm->id_damage ?>">
								<input type="hidden" name="name_file_indb" value="<?= $dm->file ?>">

								<!-- Custom file input -->
								<div class="d-flex align-items-center gap-3 w-30 file-wrapper" style="cursor:pointer;">
									<span class="form-text ms-2 file-name">Click! untuk upload file</span>
									<input type="file" class="d-none custom-file" name="file" required>
								</div>

								<!-- Tombol Upload -->
								<div>
									<button class="btn btn-info px-4 py-2 mb-0" type="submit" id="inputGroupFileAddon04">Upload</button>
								</div>
							</form>
						</blockquote>
					</div>

					<?php if ($dm->file != null): ?>
						<?php if (substr($dm->file, -4) === '.pdf') : ?>
							<iframe src="<?= base_url('public/file_damage/' . $dm->file) ?>" width="100%" height="750px">
							</iframe>
						<?php else : ?>
							<div style="max-width: 100%; max-height: 750px; overflow: auto;">
								<img src="<?= base_url('public/file_damage/' . $dm->file) ?>" alt="Bukti Transaksi" class="img-fluid">
							</div>
						<?php endif; ?>
					<?php else : ?>
						<div class="d-flex align-items-center justify-content-center" style="height: 600px;">
							<div class="text-center">
								<i class="bi bi-exclamation-circle" style="font-size: 3rem; color: #dc3545;"></i>
								<p class="mt-3 fs-4 text-danger">File belum diupload.</p>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<script>
	// Event Delegation: Mengikat event listener secara dinamis ke elemen parent
	document.addEventListener('click', function(event) {
		// Mengecek apakah elemen yang di-klik memiliki class 'file-wrapper'
		if (event.target.closest('.file-wrapper')) {
			const fileWrapper = event.target.closest('.file-wrapper');
			const customFileInput = fileWrapper.querySelector('.custom-file');
			customFileInput.click();
		}
	});

	document.addEventListener('change', function(event) {
		// Mengecek apakah elemen yang berubah adalah file input
		if (event.target.classList.contains('custom-file')) {
			const fileWrapper = event.target.closest('.file-wrapper');
			const fileNameDisplay = fileWrapper.querySelector('.file-name');
			fileNameDisplay.textContent = event.target.files[0] ? event.target.files[0].name : 'No file chosen';
		}
	});
</script>



<!-- Modal kelengkapan-->
<?php foreach ($damage as $dm) : ?>
	<div class="modal fade" id="kelengkapan-<?= $dm->id_damage ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">KELENGKAPAN</h5>
					<small>Detail Kelengkapan Printer Yang Dibawa Ke Jakarta</small>
				</div>
				<div class="modal-body">
					<div class="mx-3 mt-2">
						<h5 class="font-weight-normal text-info text-gradient">Printer SN <?= $dm->printer_sn; ?></h5>
						<blockquote class="blockquote mb-0">
							<p class="text-dark ms-3"><?= $dm->kelengkapan; ?></p>
						</blockquote>
					</div>

					<div class="text-end mt-3">
						<button type="button" class="btn bg-white shadow" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>



<?php $this->load->view('components/footer') ?>
