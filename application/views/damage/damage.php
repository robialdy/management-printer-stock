<?php $this->load->view('components/header') ?>



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
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (!empty($timedate->created_at) || $jumdamage == 0): ?>
							null
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
		<i class="bi bi-pencil-square"></i> Damage
	</button>
</div>

<?php if ($this->session->flashdata('notifSuccess')) :  ?>
	<div class="alert alert-success alert-dismissible text-white fade show" role="alert">
		<span class="alert-icon align-middle">
			<i class="bi bi-check"></i>
		</span>
		<span class="alert-text"><strong>Printer</strong> <?= $this->session->flashdata('notifSuccess') ?></span>
		<button type="button" class="btn-close fs-4" data-bs-dismiss="alert" aria-label="Close" style="margin-top: -10px;">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
<?php endif; ?>

<!-- Modal -->
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
							<label for="biayaper">Biaya Perbaikan</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="number" class="form-control" aria-label="Biaya Perbaikan" placeholder="Enter biaya perbaikan" id="biayaper" name="biayaper" required>
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
				<h6 class="text-white text-capitalize ps-3">Printer IT</h6>
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
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Cust ID</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Agen Name</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Type cust</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Pic IT</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Date Perbaikan</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Biaya Perbaikan </th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Note</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Status Pembayaran</th>
							<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 ps-2">Edit</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; ?>
						<?php foreach ($damage as $dm) : ?>
							<tr class="text-center">
								<th>
									<h6 class="mb-0 text-sm fw-normal"><?= $i; ?></h6>
								</th>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->origin ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->date_in ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->type_printer ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->printer_sn ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->cust_id ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->cust_name ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->type_cust ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->pic_it ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->date_perbaikan ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->biaya_perbaikan ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->note ?></h6>
								</td>
								<td>
									<h6 class="mb-0 text-sm fw-normal"><?= $dm->status_pembayaran ?></h6>
								</td>
								<td>
									<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modalaja-<?= $dm->id_damage ?>">
										<i class="material-icons text-secondary">edit</i>
									</button>
								</td>
								<?php $i++; ?>
							<?php endforeach; ?>
					</tbody>

				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
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
								<input type="text" class="form-control" placeholder="Enter Pic IT" id="picit" name="picit" value="<?= $dm->pic_it ?>">
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
								<input type="text" class="form-control" placeholder="Enter Note" id="note" name="note" value="<?= $dm->note ?>" required>
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
								<input type="number" class="form-control" placeholder="Enter Biaya Perbaikan" id="biayaper" name="biayaper" value="<?= $dm->biaya_perbaikan ?>" required>
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
								<input type="file" class="form-control" placeholder="Enter Biaya Perbaikan" id="file" name="file" required>
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

<?php $this->load->view('components/footer') ?>
