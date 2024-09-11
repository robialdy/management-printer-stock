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
						<?php if (!empty($dateTimeP->created_at)): ?>
							<?= $dateTimeP->created_at ?>
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
	<div class="col-auto me-5">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalprinterout">
			<i class="bi bi-printer me-2"></i>Printer Out
		</button>
	</div>
</div>


<!-- untuk ajax -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
					<table class="table table-sm align-items-center table-hover" id="datatable-search">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">No</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">origin</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">date in</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">type printer</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">printer sn</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">cust id</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">cust name</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">type cust</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">sn damage</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">pic it</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">pic user</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">no ref</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">date out</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">Detail</th>
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
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->name_type ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->printer_sn ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->cust_id ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal text-wrap"><?= $rp->cust_name ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->type_cust ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $rp->sn_damage ?></h6>
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
									<td>
										<a class="mb-0 text-sm fw-normal text-decoration-underline btn-edit" style="cursor: pointer;"
											data-bs-toggle="modal"
											data-bs-target="#modaldamageselect<?= $rp->id_replacement ?>"
											data-id="<?= $rp->id_cust ?>"
											data-idreplacement="<?= $rp->id_replacement ?>"
											data-sndamage="<?= $rp->sn_damage ?>">
											<i class="material-icons">edit</i>
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

<!-- modal edit -->
<style>
	.bi-plus-lg:hover {
		text-decoration: underline;
	}
</style>

<?php foreach ($replacement as $rp):  ?>
	<!-- Modal Select Printer -->
	<div class="modal fade" id="modaldamageselect<?= $rp->id_replacement ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="text-start ms-3">
						<h5 class="modal-title fw-bold" id="exampleModalLabel">SN DAMAGE</h5>
						<small>Pilih Untuk Menambahkan SN Damage</small> <br>
					</div>
				</div>
				<div class="modal-body">
					<small>~ Printer SN <?= $rp->printer_sn ?></small>
					<div class="overflow-auto" style="max-height: 600px" id="printerContainer">

					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach;  ?>



<script>
	$(document).ready(function() {
		$(document).on('click', '.btn-edit', function() {
			var custID = $(this).data('id'); //milih berdasarkan custiomer
			var modalID = $(this).data('bs-target');
			var idReplacement = $(this).data('idreplacement'); // Ambil ID Replacement
			var snDamage = $(this).data('sndamage'); //dipake untuk pengecekan jika udh punya sn = kosong

			// AJAX request
			$.ajax({
				url: 'PrinterReplacement/show_row_printer',
				type: 'POST',
				data: {
					custID: custID, //kirim ke serve
					idRep: idReplacement,
					snDamage: snDamage
				},
				success: function(response) {
					$(modalID + ' #printerContainer').html(response);

					// Setelah respons dimasukkan, set idreplacement2 dengan nilai idReplacement
					$(modalID + ' input[name="idreplacement2"]').val(idReplacement);
				}
			});
		});
	});
</script>


<!-- modal detail -->
<?php $this->load->view('printerreplacement/modal_detail'); ?>



<?php $this->load->view('components/footer') ?>
