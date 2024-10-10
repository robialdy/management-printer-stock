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
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#add_damage">
			<i class="material-icons me-2">warning</i>ADD DAMAGE
		</button>
	</div>
	<div class="col-auto">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#add_nodummy">
			<i class="material-icons me-2">confirmation_number</i>ADD NO DUMMY
		</button>
	</div>
	<div class="col-auto">
		<div class="col-auto me-5">
			<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#excel">
				<i class="material-icons me-2">assignment</i>DOWNLOAD EXCEL
			</button>
		</div>
	</div>
</div>

<!-- modal download excel -->
<div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">DOWNLOAD EXCEL</h5>
					<small>Pilih Range Tanggal</small>
				</div>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('printerdamage/export_excel') ?>" method="POST">

					<div class="input-group input-group-static">
						<label for="from">From</label>
						<input type="date" class="form-control" id="from" name="from" required>
					</div>

					<div class="input-group input-group-static mt-2">
						<label for="until">Until</label>
						<input type="date" class="form-control" id="until" name="until" required>
					</div>

					<div class="text-end mt-4">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- modal add damage -->
<div class="modal fade" id="add_damage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">ADD DAMAGE</h5>
					<small>Silahkan Input No SN Printer List</small>
				</div>
			</div>
			<div class="modal-body">
				<form action="<?= base_url('printerdamage/add_damage') ?>" method="POST">

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-3">
								<select class="choices form-select" id="exampleFormControlSelect1" name="idprinter" required>
									<option value="" selected disabled>ENTER PRINTER S/N</option>
									<?php foreach ($printer_list as $pl) : ?>
										<option value="<?= $pl->id_printer . '|' . $pl->id_cust; ?>"><?= $pl->printer_sn . ' - ' . $pl->cust_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<?php foreach ($printer_list as $pl) : ?>
						<input type="hidden" value="<?= $pl->printer_sn ?>" name="_printer_sn">
						<input type="hidden" value="<?= $pl->cust_id ?>" name="_cust_id">
						<input type="hidden" value="<?= $pl->cust_name ?>" name="_cust_name">
						<input type="hidden" value="<?= $pl->date_out ?>" name="_date_out">
					<?php endforeach; ?>


					<div class="row mb-2">
						<div class="col-4 mt-2">
							<label for="typep">DESKRIPSI</label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter Deskripsi kerusakan" id="typep" name="deskripsi" style="text-transform: uppercase;" required>
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

						</div>
					</div>

					<div class="text-end mt-4">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
					</div>
				</form>
			</div>
		</div>
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
				<?= form_open('printerdamage/add_nodummy'); ?>

				<label for="sn" class="text-dark">PRINTER S/N <span class="text-danger">*</span></label>
				<div class="input-group">
					<select class="form-select" id="printersn" name="idprinter[]" multiple required>
						<option value="" disabled>Select Printer Sn</option>
						<?php foreach ($no_dummy as $nd) : ?>
							<option value="<?= $nd->id_printer; ?>"><?= $nd->printer_sn; ?></option>
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
				<?= form_close(); ?>
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

<div id="loading" style="display: none; position: absolute; top: 120%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
	<div class="spinner-border text-info" role="status">

	</div>
</div>

<div class=" row">
	<div class="col-12">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">Printer Damage</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table table-sm align-items-center table-hover" id="datatable">
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
							<!-- lewat json boss biar ketika data banyak ga ada delay gaje -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal-container-edit">
	<!-- modal edit -->
</div>

<div id="modal-container-file">
	<!-- modal file -->
</div>

<div id="modal-container-kelengkapan">
	<!-- modal kelengkapan -->
</div>

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<!-- Script untuk mengambil dan menampilkan data -->
<script>
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerdamage/view_data_table') ?>",
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

	// menjalankan modal edit
	$(document).ready(function() {
		$(document).on('hidden.bs.modal', '#edit', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-edit', function() {
			var modalID = '#edit';

			// AJAX request
			$.ajax({
				url: '<?= site_url('printerdamage/modal_edit') ?>',
				type: 'POST',
				data: {
					modal: $(this).data('modal'),
				},
				success: function(response) {
					$('#modal-container-edit').html(response);
					$(modalID).modal('show');
					// Inisialisasi choices
					const choices = new Choices($(modalID + ' .choices')[0]);
				},
			});
		});
	});

	$(document).ready(function() {
		$(document).on('hidden.bs.modal', '#file', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-file', function() {
			var modalID = '#file';

			// AJAX request
			$.ajax({
				url: '<?= site_url('printerdamage/modal_file') ?>',
				type: 'POST',
				data: {
					modal: $(this).data('modal'),
				},
				success: function(response) {
					$('#modal-container-file').html(response);
					$(modalID).modal('show');
					// Inisialisasi choices
					const choices = new Choices($(modalID + ' .choices')[0]);
				},
			});
		});
	});

	$(document).ready(function() {
		$(document).on('hidden.bs.modal', '#kelengkapan', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-kelengkapan', function() {
			var modalID = '#kelengkapan';

			// AJAX request
			$.ajax({
				url: '<?= site_url('printerdamage/modal_kelengkapan') ?>',
				type: 'POST',
				data: {
					modal: $(this).data('modal'),
				},
				success: function(response) {
					$('#modal-container-kelengkapan').html(response);
					$(modalID).modal('show');
					// Inisialisasi choices
					const choices = new Choices($(modalID + ' .choices')[0]);
				},
			});
		});
	});
</script>


<!-- script file -->
<script>
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




<?php $this->load->view('components/footer') ?>
