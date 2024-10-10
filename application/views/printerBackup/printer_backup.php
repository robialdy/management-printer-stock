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

				<!-- PRINTER S/N -->
				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-3">
							<input type="text" class="form-control" id="sn" name="printersn" style="text-transform: uppercase;" placeholder="Enter printer s/n" required>
						</div>
					</div>
				</div>

				<!-- TYPE PRINTER -->
				<div class="row">
					<div class="col-4 mt-2">
						<label for="typePrinter">TYPE PRINTER <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-static mb-2">
							<select class="choices form-select" id="typePrinter" name="typeprinter" required>
								<option value="" selected disabled>ENTER TYPE PRINTER</option>
								<?php foreach ($type_printer as $tp) : ?>
									<option value="<?= $tp->id_type; ?>"><?= $tp->name_type; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<!-- SN DAMAGE -->
				<div class="row">
					<div class="col-4 mt-2">
						<label for="snDamage">SN DAMAGE <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-static mb-2">
							<select class="choices form-select" id="snDamage" name="return_cgk">
								<option value="" selected disabled>ENTER SN DAMAGE</option>
								<?php foreach ($sndamage as $sg) : ?>
									<option value="<?= $sg->printer_sn; ?>"><?= $sg->printer_sn; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="text-end mt-3">
					<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn bg-gradient-info text-white border-radius-sm" id="saveButton">Save changes</button>
				</div>

				<script>
					document.addEventListener('DOMContentLoaded', function() {
						const printerSNInput = document.getElementById('sn');
						const snDamageSelect = document.getElementById('snDamage');
						const saveButton = document.getElementById('saveButton');

						function checkIfSame() {
							const printerSN = printerSNInput.value.trim().toUpperCase();
							const snDamage = snDamageSelect.options[snDamageSelect.selectedIndex].text.trim().toUpperCase();

							if (printerSN === snDamage) {
								saveButton.disabled = true;
							} else {
								saveButton.disabled = false;
							}
						}

						printerSNInput.addEventListener('input', checkIfSame);
						snDamageSelect.addEventListener('change', checkIfSame);
					});
				</script>

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
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">printer sn</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">type printer</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">date in</th>
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

<?php $cek_prin = $this->session->flashdata('confirm'); ?>

<!-- menampilan modal ketika buka page -->
<?php if ($cek_prin) : ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var myModal = new bootstrap.Modal(document.getElementById('modalcek'), {
				keyboard: false
			});
			myModal.show();
		});
	</script>
<?php endif; ?>

<div class="modal fade" id="modalcek" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="text-start ms-3">
				<h5 class="modal-title fw-bold" id="exampleModalLabel">CONFIRM SN PRINTER</h5>
				<small>Serial Number <?= $cek_prin['sn']; ?> Dengan Type Printer <?= $cek_prin['type_prin'] ?> Sudah Pernah Terdaftar, Apakah Anda Yakin Ingin Set Ulang Untuk Backup?</small>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('printerbackup/update_printer_backup'); ?>" method="POST">
					<!-- printer mana yang mau itambahkan -->
					<input type="hidden" name="id_prin_cgk" value="<?= $cek_prin['id_prin_cgk'] ?>">

					<input type="hidden" name="printer_sn" value="<?= $cek_prin['sn'] ?>">
					<input type="hidden" name="id_prin" value="<?= $cek_prin['id_prin'] ?>">

					<div class="text-end">
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save Changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('components/footer') ?>