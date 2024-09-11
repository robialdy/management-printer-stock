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
			text: '"<?= $this->session->flashdata('notifSuccess') ?>"',
			confirmButtonText: 'OK'
		});
	}
</script>

<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2" style="height: 200px;">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $jumdamage ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Printer Damage</p>
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (!empty($timedate->created_at) || $jumdamage == 0): ?>
							<?= date('d/m/Y H:i:s') ?>
						<?php else: ?>
							<?= $timedate->created_at ?> 
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="text-end me-5">
	<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalInsert">
		<i class="bi bi-pencil-square"></i> BIAYA PERBAIKAN
	</button>
</div>
<!-- Modal update -->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-center">
					<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Biaya Perbaikan</h5>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?= site_url('PrinterDamage/update') ?>">
					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">SELECT S/N</label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="exampleFormControlSelect1" name="id" required>
									<option value="" selected disabled>Enter Printer S/N</option>
									<?php foreach ($damage as $dm) : ?>
										<option value="<?= $dm->id_damage; ?>"><?= $dm->printer_sn; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="biayaper">BIAYA PERBAIKAN</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="number" class="form-control" aria-label="Biaya Perbaikan" placeholder="Enter biaya perbaikan" id="biayaper" name="biayaper" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>
                    
					
					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">KELENGKAPAN</label>
						</div>
						<div class="col mt-2">

							<div class="row">
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

							<div class="row">
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

							<div class="row">
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

							<div class="row">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="power" value="KABEL POWER">
									<label class="form-check-label" for="power">
										KABEL POWER
									</label>
								</div>
							</div>

							<!-- Checkbox untuk memilih semua -->
							<div class="row">
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


					<div class="row">
						<div class="col-4 mt-2">
							<label>Status Pembayaran</label>
						</div>
						<div class="col">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status_pembayaran" id="belumBayar" value="belum Bayar" checked>
								<label class="form-check-label" for="belumBayar">Belum Bayar</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status_pembayaran" id="sudahBayar" value="sudah Bayar">
								<label class="form-check-label" for="SudahBayar">Sudah Bayar</label>
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


<div class="col-12">
	<div class="card my-4">
		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
			<h6 class="text-white ps-3 fw-light">Printer Damage</h6>
			</div>
		</div>
		<div class="card-body px-0 pb-2">
			<div class="table-responsive p-0">
				<table class="table table-sm table-hover align-items-center" id="datatable-search">
					<thead>
						<tr>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">No</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Origin</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Date In</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Type Printer</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Printer SN</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">CDK Jakarta</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Cust ID</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Agen Name</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Type cust</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Pic IT</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Date Perbaikan</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Biaya Perbaikan </th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Note</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Status Pembayaran</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Kelengkapan</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">File Transaksi</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Edit</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; ?>
						<?php foreach ($damage as $dm) : ?>
							<tr class="text-center text-uppercase">
								<th>
									<h6 class="mb-0 text-sm fw-normal"><?= $i; ?></h6>
								</th>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->origin ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->date_in ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->type_printer ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->printer_sn ?></h6>	
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->cdk_jakarta ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->cust_id ?></h6>
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
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->date_perbaikan ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->biaya_perbaikan ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->note ?></h6>
								</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->status_pembayaran ?></h6>
								</td>
								<td class="text-center">
										<a class="mb-0 text-sm fw-normal text-info text-decoration-underline" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $dm->id_damage ?>">
											DET.
										</a>
									</td>
								<td class="text-center text-uppercase">
									<h6 class="mb-0 text-sm fw-normal"> <button type="button" class="btn btn-link mb-0" data-bs-toggle="modal" data-bs-target="#modalfile-<?= $dm->id_damage ?>">
											file
										</button></h6>

								</td>
								<td>

									<a class="mb-0 text-sm fw-normal text-info text-decoration-underline" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalaja-<?= $dm->id_damage ?>">
										<i class="material-icons text-secondary">edit</i>
									</a>
								</td>
								
								<?php $i++; ?>
							<?php endforeach; ?>
					</tbody>


				</table>
			</div>
		</div>
	</div>
</div>



<!-- Modal edit-->
<?php foreach ($damage as $dm) : ?>
	<div class="modal fade" id="modalaja-<?= $dm->id_damage ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-center">
					<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Edit Perbaikan</h5>
				</div>
				<div class="modal-body">
					<?php echo form_open_multipart('PrinterDamage/edit'); ?>
					<input type="hidden" name="id_damage" value="<?= $dm->id_damage ?>">


					<!-- Pic IT -->
					<div class="row mb-2">
						<div class="col-4 mt-2">
							<label for="">Pic IT</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic">
								<input type="text" class="form-control" placeholder="Enter Pic IT" id="picit" name="picit" style="text-transform: uppercase;" value="<?= $dm->pic_it ?>">
							</div>
						</div>
					</div>

					<!-- Note -->
					<div class="row mb-2">
						<div class="col-4 mt-2">
							<label for="note">Note</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic">
								<input type="text" class="form-control" placeholder="Enter Note" id="note" name="note" style="text-transform: uppercase;" value="<?= $dm->note ?>">
							</div>
						</div>
					</div>

					<!-- Biaya Perbaikan -->
					<div class="row mb-2">
						<div class="col-4 mt-2">
							<label for="biayaper">Biaya Perbaikan</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic">
								<input type="number" class="form-control" placeholder="Enter Biaya Perbaikan" id="biayaper" name="biayaper" style="text-transform: uppercase;" value="<?= $dm->biaya_perbaikan ?>">
							</div>
						</div>
					</div>

					<!-- Status Pembayaran -->
					<div class="row mb-2">
						<div class="col-4 mt-2">
							<label>Status Pembayaran</label>
						</div>
						<div class="col">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status_pembayaran" id="BelumBayar" value="Belum Bayar"
									<?= ($dm->status_pembayaran == 'Belum Bayar') ? 'checked' : ''; ?>>
								<label class="form-check-label" for="belumBayar">Belum Bayar</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="status_pembayaran" id="SudahBayar" value="Sudah Bayar"
									<?= ($dm->status_pembayaran == 'Sudah Bayar') ? 'checked' : ''; ?>>
								<label class="form-check-label" for="sudahBayar">Sudah Bayar</label>
							</div>
						</div>
					</div>

					<div class="row mb-2">
						<div class="col-4 mt-2">
							<label for="biayaper">Upload File</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic">
								<input type="file" class="form-control" placeholder="Enter Biaya Perbaikan" id="file" name="file" accept=".pdf">
							</div>
						</div>
					</div>

					<!-- Buttons -->
					<div class="text-end mt-3">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save Changes</button>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<!-- Modal file -->
<?php foreach ($damage as $dm) : ?>
	<div class="modal fade" id="modalfile-<?= htmlspecialchars($dm->id_damage) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content" style="background-color: #f8f9fa; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
				<div class="modal-header">
					<h5 class="modal-title" id="pdfModalLabel">Report Perbaikan</h5>
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<?php if (!empty($dm->file)): ?>
						<iframe src="<?= base_url('public/img/file_uploaded/' . htmlspecialchars($dm->file)); ?>" width="100%" height="730px" style="border: none; border-radius: 8px;"></iframe>
					<?php else: ?>
						<div class="d-flex align-items-center justify-content-center" style="height: 730px;">
							<div class="text-center">
								<i class="bi bi-exclamation-circle" style="font-size: 3rem; color: #dc3545;"></i>
								<p class="mt-3 fs-4 text-danger">File tidak ditemukan.</p>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<!-- Modal detail -->
<?php foreach ($damage as $dm) : ?>
	<div class="modal fade" id="modalDetail<?= $dm->id_damage ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Detail Kelengkapan Printer</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mx-3 mt-2">
						<h5 class="font-weight-normal text-info text-gradient">Printer SN <?= $dm->printer_sn ?></h5>
						<blockquote class="blockquote mb-0">
							<p class="text-dark ms-3"><?= $dm->kelengkapan ?></p>
						</blockquote>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php $this->load->view('components/footer') ?>