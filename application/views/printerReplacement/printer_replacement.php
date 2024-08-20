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
			text: 'Printer SN "<?= $this->session->flashdata('notifSuccess') ?>" Replacement Successfuly!',
			confirmButtonText: 'OK'
		});
	}
</script>

<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2 " style="height: 200px;">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $jumPrinter ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Printer Backup</p>
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (empty($dateTimeB->created_at) || $jumPrinter == 0): ?>
							null
						<?php else: ?>
							<?= $dateTimeB->created_at ?>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2" style="height: 200px;">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $jumReplacement ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Pembelian Printer</p>
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (!empty($dateTimeP->date_out)): ?>
							<?= $dateTimeP->date_out ?>
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
<div class="row justify-content-end">
	<div class="col-auto">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalInsert">
			<i class="bi bi-printer-fill me-2"></i>Printer IN
		</button>
	</div>
	<div class="col-auto me-5">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalprinterout">
			<i class="bi bi-printer me-2"></i>Printer Out
		</button>
	</div>
</div>


<!-- Modal printer in -->
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
							<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter printer s/n" aria-describedby="basic-addon1" id="sn" name="printersn" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">TYPE PRINTER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="enter type printer" aria-describedby="basic-addon1" id="typep" name="printertype" style="text-transform: uppercase;" required>
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

<?php $printerselect = $this->session->flashdata('printerselect'); ?>

<!-- menampilan modal ketika buka page -->
<?php if ($printerselect) : ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var myModal = new bootstrap.Modal(document.getElementById('modalselect'), {
				keyboard: false
			});
			myModal.show();
		});
	</script>
<?php endif; ?>

<!-- modal select printer -->
<?php $this->load->view('modalSelectPrinter', ['printerselect' => $printerselect]) ?>

<!-- modal printer out -->
<?php $this->load->view('modalPrinterOut')  ?>


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
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">Printer Replacement</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table table-sm align-items-center custom-table-padding" id="datatable-search">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">No</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">origin</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">date in</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">type printer</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">printer sn</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">cust id</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">agen name</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">type cust</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">pic it</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">pic user</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">no ref</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">date out</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0">Detail</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($replacement as $rp) : ?>
								<tr>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-bold"><?= $i; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->origin ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->date_in ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->type_printer ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->printer_sn ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->cust_id ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal text-wrap"><?= $rp->agen_name ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->type_cust ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->pic_it ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->pic_user ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->no_ref ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->date_out ?></h6>
									</td>
									<td class="text-center">
										<a class="mb-0 text-sm fw-normal text-info text-decoration-underline" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $rp->id_replacement ?>">
											DET.
										</a>
									</td>
								</tr>
								<?php $i++; ?>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal detail -->
<?php foreach ($replacement as $rp) : ?>
	<div class="modal fade" id="modalDetail<?= $rp->id_replacement ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="text-center">
						<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Detail Kelengkapan Printer</h5>
					</div>
				</div>
				<div class="modal-body">

					<div class="mx-3 mt-2">
						<h5 class="font-weight-normal text-info text-gradient">Printer SN <?= $rp->printer_sn ?></h5>
						<blockquote class="blockquote text-white mb-0">
							<p class="text-dark ms-3"><?= $rp->kelengkapan ?></p>
						</blockquote>
					</div>


					<div class="text-end mt-3">
						<button type="button" class="btn bg-white shadow" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>

<?php $this->load->view('components/footer') ?>
