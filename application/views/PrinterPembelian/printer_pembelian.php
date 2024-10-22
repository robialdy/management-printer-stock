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

<div class="row mb-3 ms-5">
	<div class="card w-30">
		<div class="card-body text-center">
			<h1 class="text-gradient text-info"><span id="status1" countto="<?= $sum_data ?>"><?= $sum_data ?></span> <span class="text-lg ms-n2">Pcs</span></h1>
			<h6 class="mb-0 font-weight-bolder">Printer Pembelian</h6>
			<p class="opacity-8 mb-0 text-sm">
				<?php if (empty($date_time->date_out) || $sum_data == 0): ?>
					null
				<?php else: ?>
					<?= $date_time->date_out ?>
				<?php endif; ?>
			</p>
		</div>
	</div>
</div>
<!-- animasi count -->
<script src="<?= base_url() ?>public/js/plugins/countup.min.js"></script>
<script>
	if (document.getElementById('status1')) {
		const countUp = new CountUp('status1', document.getElementById("status1").getAttribute("countTo"));
		if (!countUp.error) {
			countUp.start();
		} else {
			console.error(countUp.error);
		}
	}
</script>


<!-- Button trigger modal -->
<div class="row justify-content-end">
	<div class="col-auto">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#printerrusak">
			<i class="material-icons me-2">warning</i>PRINTER RUSAK
		</button>
	</div>
	<div class="col-auto me-5">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#buyprinter">
			<i class="bi bi-printer-fill me-2"></i>Buy Printer
		</button>
	</div>
</div>

<!-- Modal buy printer -->
<div class="modal fade" id="buyprinter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">BUY PRINTER</h5>
					<small>Silahkan Mengisi Form!</small>
				</div>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('printerpembelian/insert') ?>" method="POST">

					<!-- CUSTOMERS -->
					<div class="row">
						<div class="col-4 mt-2">
							<label for="cust">CUSTOMER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="cust" name="customer" required>
									<option value="" selected disabled>ENTER TYPE PRINTER</option>
									<?php foreach ($customers as $customer) : ?>
										<option value="<?= $customer->id_cust; ?>"><?= $customer->cust_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<!-- PRINTER S/N -->
					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-3">
								<input type="text" class="form-control" id="sn" name="printer_sn" style="text-transform: uppercase;" placeholder="Enter printer s/n" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="cust">TYPE PRINTER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="cust" name="type_printer" required>
									<option value="" selected disabled>ENTER TYPE PRINTER</option>
									<?php foreach ($type_printers as $type_printer) : ?>
										<option value="<?= $type_printer->id_type; ?>"><?= $type_printer->name_type; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC IT <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic it" aria-describedby="basic-addon1" id="typep" name="picit" style="text-transform: uppercase;" required minlength="3">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC USER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic user" aria-describedby="basic-addon1" id="typep" name="picuser" style="text-transform: uppercase;" required minlength="3">
							</div>
						</div>
					</div>

					<div class="text-end mt-3">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm" id="saveButton">Save changes</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="printerrusak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">PRINTER RUSAK</h5>
					<small>Silahkan Mengisi Form!</small>
				</div>
			</div>
			<div class="modal-body">
				<form action="<?= site_url('printerpembelian/damage') ?>" method="POST">

					<input type="hidden" name="cust_name" val ue="">

					<div class="row">
						<div class="col-4 mt-2">
							<label for="cust">PRINTER S/N <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="cust" name="id_pembelian" required>
									<option value="" selected disabled>ENTER PRINTER SN</option>
									<?php foreach ($read_data_damage as $pp) : ?>
										<option value="<?= $pp->id_printer_pembelian; ?>"><?= $pp->printer_sn; ?> - <?= $pp->cust_name ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC IT <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic it" aria-describedby="basic-addon1" id="typep" name="picit" style="text-transform: uppercase;" required minlength="3">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC USER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic user" aria-describedby="basic-addon1" id="typep" name="picuser" style="text-transform: uppercase;" required minlength="3">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">DESKIRPSI <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic user" aria-describedby="basic-addon1" id="typep" name="deskripsi" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<a href="#" data-bs-toggle="collapse" data-bs-target="#collapse" class="text-dark">TAMBAH BACKUP <small>(Opsional)</small></a>

					<div class="collapse" id="collapse">
						<div class="row mt-2">
							<div class="col-4 mt-2">
								<label for="cust">SN BACKUP</label>
							</div>
							<div class="col">
								<div class="input-group input-group-static mb-2">
									<select class="choices form-select" id="cust" name="printer_sn_temp">
										<option value="" selected disabled>ENTER SN PENGGANTI</option>
										<?php foreach ($printer_backup as $pb) : ?>
											<option value="<?= $pb['printer_sn']; ?>"><?= $pb['printer_sn']; ?></option>
										<?php endforeach; ?>
									</select>
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
					</div>


					<div class="text-end mt-3">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm" id="saveButton">Save changes</button>
					</div>

				</form>
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
					<h6 class="text-white ps-3 fw-light">Printer Pembelian</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable">
						<thead>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">No</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">CUST ID</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">CUST NAME</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">PIC IT</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">PIC USER</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">SERIAL NUMBER</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">TYPE</th>
							<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">date out</th>
							<th class="text-center text-uppercase text-dark text-sm font-weight-bolder opacity-7 pb-2">status</th>
							<th class="text-center text-uppercase text-dark text-sm font-weight-bolder opacity-7 pb-2">pic it</th>
							<th class="text-center text-uppercase text-dark text-sm font-weight-bolder opacity-7 pb-2">pic user</th>
							<th class="text-center text-uppercase text-dark text-sm font-weight-bolder opacity-7 pb-2">SN BACKUP</th>
							</>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal-container">

</div>

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<!-- Script untuk mengambil dan menampilkan data -->
<script>
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerpembelian/view_data_table') ?>",
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

	// menjalankan modal
	$(document).ready(function() {
		$(document).on('hidden.bs.modal', '#confirm', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-confirm', function() {
			var modalID = '#confirm';

			// AJAX request
			$.ajax({
				url: '<?= site_url('printerpembelian/modal_confirm') ?>',
				type: 'POST',
				data: {
					modal: $(this).data('modal'),
				},
				success: function(response) {
					// console.log(response); // Debug: lihat isi respons
					$('#modal-container').html(response);
					$(modalID).modal('show');
					// // Inisialisasi choices
					const choices = new Choices($(modalID + ' .choices')[0]);
				},
			});
		});
	});
</script>





<?php $this->load->view('components/footer') ?>