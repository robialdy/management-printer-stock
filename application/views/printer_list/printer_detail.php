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

<div class="row justify-content-center gap-4 mb-2">

	<div class="card w-30">
		<div class="card-body text-center">
			<h1 class="text-gradient text-info"><span id="status2" countto="<?= $jum_data ?>"><?= $jum_data ?></span> <span class="text-lg ms-n2">Pcs</span></h1>
			<h6 class="mb-0 font-weight-bolder">Printer List</h6>
			<p class="opacity-8 mb-0 text-sm">
				<?php if (empty($time->date_out) || $jum_data == 0): ?>
					null
				<?php else: ?>
					<?= $time->date_out ?>
				<?php endif; ?>
			</p>
		</div>
	</div>

	<div class="card w-30">
		<div class="card-body text-center">
			<h1 class="text-gradient text-info"><span id="status1" countto="<?= $jum_printer ?>"><?= $jum_printer ?></span> <span class="text-lg ms-n2">Pcs</span></h1>
			<h6 class="mb-0 font-weight-bolder">Printer Backup</h6>
			<p class="opacity-8 mb-0 text-sm">
				<?php if (!empty($dateTimeP->created_at)): ?>
					<?= $dateTimeP->created_at ?>
				<?php else: ?>
					null
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
	if (document.getElementById('status2')) {
		const countUp = new CountUp('status2', document.getElementById("status2").getAttribute("countTo"));
		if (!countUp.error) {
			countUp.start();
		} else {
			console.error(countUp.error);
		}
	}
</script>

<div class="row justify-content-end">
	<div class="col-auto">
		<form action="<?= base_url('printerlist/import_excel') ?>" method="post" enctype="multipart/form-data">
			<label for="file">Pilih File Excel:</label>
			<input type="file" name="excel_file" accept=".xlsx" required>
			<input type="submit" value="Upload">
		</form>
	</div>
	<div class="col-auto me-5">
		<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalprinterout">
			<i class="bi bi-printer me-2"></i>Printer Out
		</button>
	</div>
</div>

<?php $this->load->view('printer_list/printer_out'); ?>

<style>
	/* css di file sistem material-dashboard.css */
	/* .dataTable-wrapper .dataTable-container .table tbody tr td {
		padding: .75rem 1.5rem
	} */
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
					<h6 class="text-white ps-3 fw-light">Printer List Detail</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">NO</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">ORIGIN</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">DATE IN</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">TYPE PRINTER</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">PRINTER SN</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">CUST.ID</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">CUST NAME</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">TYPE CUST</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">PIC IT</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">PIC USER</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">NO REF</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">DATE OUT</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">STATUS</th>
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

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<!-- Script untuk mengambil dan menampilkan data -->
<script>
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerlist/view_data_table') ?>",
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

<!-- Modal kelengkapan-->
<?php foreach ($printer_detail as $pd) : ?>
	<div class="modal fade" id="kelengkapan-<?= $pd->id_printer_list ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">KELENGKAPAN</h5>
					<small>Detail Kelengkapan Printer Peminjaman</small>
				</div>
				<div class="modal-body">
					<div class="mx-3 mt-2">
						<h5 class="font-weight-normal text-info text-gradient">Printer SN <?= $pd->printer_sn; ?></h5>
						<blockquote class="blockquote mb-0">
							<p class="text-dark ms-3"><?= $pd->kelengkapan; ?></p>
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

<!-- Modal send printer-->
<?php foreach ($printer_detail as $pd) : ?>
	<div class="modal fade" id="send-<?= $pd->id_printer_list ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">SEND TO PRINTER BACKUP</h5>
					<small>Apakah Anda Yakin Ingin Memindahkan Printer Dengan SN <?= $pd->printer_sn ?> Ke Backup?</small>
				</div>
				<div class="modal-body">

					<form action="<?= site_url('printerlist/send_to_backup'); ?>" method="POST">

						<input type="hidden" name="id_printer" value="<?= $pd->id_printer; ?>">
						<input type="hidden" name="printer_sn" value="<?= $pd->printer_sn; ?>">

						<div class="text-end">
							<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Send</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>



<?php $this->load->view('components/footer') ?>
