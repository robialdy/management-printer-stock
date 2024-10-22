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
			<h1 class="text-gradient text-info"><span id="status1" countto="<?= $jumReplacement ?>"><?= $jumReplacement ?></span> <span class="text-lg ms-n2">Pcs</span></h1>
			<h6 class="mb-0 font-weight-bolder">Printer Replacement</h6>
			<p class="opacity-8 mb-0 text-sm">
				<?php if (!empty($dateTimeP->created_at)): ?>
					<?= $dateTimeP->created_at ?>
				<?php else: ?>
					null
				<?php endif; ?>
			</p>
		</div>
	</div>

	<div class="card w-30">
		<div class="card-body text-center">
			<h1 class="text-gradient text-info"><span id="status2" countto="<?= $jumPrinter ?>"><?= $jumPrinter ?></span> <span class="text-lg ms-n2">Pcs</span></h1>
			<h6 class="mb-0 font-weight-bolder">Printer Backup</h6>
			<p class="opacity-8 mb-0 text-sm">
				<?php if (empty($dateTimeB->date_in) || $jumPrinter == 0): ?>
					null
				<?php else: ?>
					<?= $dateTimeB->date_in ?>
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

<div id="loading" style="display: none; position: absolute; top: 120%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
	<div class="spinner-border text-info" role="status">
	</div>
</div>

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
					<table class="table table-sm align-items-center table-hover" id="datatable">
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

<div id="modal-container">
	<!-- modal dimuat -->
</div>

<script>
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerreplacement/view_data_table') ?>",
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

<!-- modal edit -->
<style>
	.bi-plus-lg:hover {
		text-decoration: underline;
	}
</style>






<script>
	$(document).ready(function() {

		$(document).on('hidden.bs.modal', '#modaldamageselect', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-edit', function() {
			var custID = $(this).data('id'); //milih berdasarkan custiomer
			var modalID = $(this).data('bs-target');
			var showModal = '#modaldamageselect';
			var id_list = $(this).data('idlist'); // Ambil ID Replacement
			var snDamage = $(this).data('sndamage'); //dipake untuk pengecekan jika udh punya sn = kosong
			var idRep = $(this).data('idreplacement');
			var prinSn = $(this).data('prinsn');

			// AJAX request
			$.ajax({
				url: '<?= base_url('printerreplacement/modal_damage_select') ?>',
				type: 'POST',
				data: {
					custID: custID, //kirim ke serve
					id_list: id_list,
					snDamage: snDamage,
					idRep: idRep,
					prinSn: prinSn
				},
				success: function(response) {
					$('#modal-container').html(response);
					$(modalID).modal('show');
				}
			});
		});
	});
</script>



<?php $this->load->view('components/footer') ?>
