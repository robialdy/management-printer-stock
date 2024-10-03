<?php $this->load->view('components/header') ?>

<!-- success -->
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


<?php if ($this->session->flashdata('notifError')) :  ?>
	<script>
		window.onload = function() {
			showErrorMessage();
		};
	</script>
<?php endif; ?>

<script>
	function showErrorMessage() {
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: '<?= $this->session->flashdata('notifError') ?>',
			confirmButtonText: 'OK'
		});
	}
</script>


<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2" style="height: 200px;">
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
					<p class="mb-0 text-sm">
						<?php if (empty($dateTime->created_at) || $totalPrinter == 0): ?>
							null
						<?php else: ?>
							<?= $dateTime->created_at ?>
						<?php endif; ?>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="col-5 mt-3">
		<div class="card p-3">
			<div class="card-header p-3 pt-2">
				<p class="fs-5">Type Printer</p>
				<div class="text-start pt-1">
					<div class="row">
						<?php foreach ($printerList as $printer): ?>
							<div class="col">
								<p class="text-sm mb-0 text-capitalize"><?= $printer['name_type'] ?></p>
								<h5 class="mb-0"><?= $printer["total_" . str_replace('-', '_', $printer['name_type'])] ?> Pcs</h5>
							</div>
						<?php endforeach; ?>
					</div>
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

<!-- Modal -->
<div class="modal fade" id="modalInsert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">PRINTER IN</h5>
					<small>Silahkan Menginput Data Printer</small>
				</div>
			</div>
			<div class="modal-body">
				<?= form_open('printerbackup/insert') ?>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-3">
							<input type="text" class="form-control" aria-label="Username" placeholder="Enter printer s/n" aria-describedby="basic-addon1" id="sn" name="printersn" style="text-transform: uppercase;" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">TYPE PRINTER<span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-static mb-2">
							<select class="choices form-select" id="exampleFormControlSelect1" name="typeprinter" required>
								<option value="" selected disabled>ENTER TYPE PRINTER</option>
								<?php foreach ($type_printer as $tp) : ?>
									<option value="<?= $tp->id_type; ?>"><?= $tp->name_type; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">SN DAMAGE <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-static mb-2">
							<select class="choices form-select" id="exampleFormControlSelect1" name="return_cgk">
								<option value="" selected disabled>ENTER SN DAMAGE</option>
								<?php foreach ($sndamage as $sg) : ?>
									<option value="<?= $sg->id_printer; ?>"><?= $sg->printer_sn; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

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

<div id="loading" style="display: none; position: absolute; top: 120%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
	<div class="spinner-border text-info" role="status">
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
					<table class="table align-items-center table-hover" id="datatable">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">No</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">Origin</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">date in</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">type printer</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">printer sn</th>
							</tr>
						</thead>
						<tbody>
							<!-- lewat json boss biar ketika data banyak ga ada delay gaje -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<script>
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerbackup/view_data_table') ?>",
				type: "POST",
				dataType: "json",
				success: function(response) {
					const tableBody = $('#datatable tbody');
					tableBody.empty(); // Kosongkan tabel 
					tableBody.append(response.html);

					const dataTable = new simpleDatatables.DataTable("#datatable", {
						sortable: false,
						perPage: 10,
					});
				},
				error: function() {
					alert('Terjadi kesalahan saat memuat data.');
				},
				complete: function() {
					// Sembunyikan loading setelah selesai
					$('#loading').hide();
				}
			});
		}
	});
</script>

<?php $this->load->view('components/footer') ?>
