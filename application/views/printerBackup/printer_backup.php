<?php $this->load->view('components/header') ?>


<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2 ">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $totalPrinter ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Printer Backup</p>
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm"> 08 Agustus 2024 / 02:59.38</p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Button trigger modal -->
<div class="text-end me-5">
	<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalInsert">
		<i class="bi bi-printer-fill me-2"></i>Printer IN
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
					<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Printer In</h5>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?= site_url() ?>printerbackup/insert">

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">PRINTER S/N*</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter printer s/n" aria-describedby="basic-addon1" id="sn" name="printersn" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">TYPE PRINTER</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="enter type printer" aria-describedby="basic-addon1" id="typep" name="printertype" required>
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

<div class="row">
	<div class="col-12">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">Printer IT</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table table-sm align-items-center" id="datatable-search">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7">No</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7">Origin</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7">date in</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7">type printer</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7">printer sn</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7">note</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($printerList as $pl) : ?>
								<tr class="text-center">
									<td class="">
										<h6 class="mb-0 text-sm fw-normal"><?= $i; ?></h6>
									</td>
									<td class="text-center">
										<h6 class="mb-0 text-sm fw-normal"><?= $pl['origin']; ?></h6>
									</td>
									<td class="text-center">
										<h6 class="mb-0 text-sm fw-normal"><?= $pl['date_in']; ?></h6>
									</td>
									<td class="text-center">
										<h6 class="mb-0 text-sm fw-normal"><?= $pl['type_printer']; ?></h6>
									</td>
									<td class="text-center">
										<h6 class="mb-0 text-sm fw-normal"><?= $pl['printer_sn']; ?></h6>
									</td>
									<td class="text-center">
										<h6 class="mb-0 text-sm fw-normal"><?= $pl['note']; ?></h6>
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
