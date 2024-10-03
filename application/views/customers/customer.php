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
			text: '<?= $this->session->flashdata('notifSuccess') ?>',
			confirmButtonText: 'OK'
		});
	}
</script>


<div class="row">
	<div class="col-lg-6 col-md-6 mt-3 mb-3">
		<div class="card border-radius-md z-index-2" style="height: 200px;">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
				<div class="bg-gradient-info shadow-info border-radius-sm py-3 pe-1 text-center">
					<span class="text-white fs-1 fw-light"><?= $jumAgen ?></span>
				</div>
			</div>
			<div class="card-body text-center">
				<p class="text-md fw-normal">Total Master Data Customer</p>
				<hr class="dark horizontal">
				<div class="d-flex ">
					<i class="material-icons text-sm my-auto me-1">schedule</i>
					<p class="mb-0 text-sm">
						<?php if (!empty($dateTime->created_at)): ?>
							<?= $dateTime->created_at ?>
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
<div class="text-end me-5">
	<button type="button" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalInsert">
		<i class="bi bi-plus-lg"></i></i> customer
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
					<h5 class="modal-title fw-bold" id="exampleModalLabel">ADD CUSTOMER</h5>
					<small>Silahkan Menginput Data Customer</small>
				</div>
			</div>
			<div class="modal-body">
				<?= form_open('customers') ?>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="sn">TYPE CUST <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-2">
							<select class="choices form-select" id="typecust" name="typecust" required onchange="custIdAuto()">
								<option value="" selected disabled>ENTER TYPE CUST</option>
								<option value="AGEN">AGEN</option>
								<option value="KP">KP</option>
								<option value="CORPORATE">CORPORATE</option>
								<option value="OPS">OPS</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row" id="custidRow">
					<div class="col-4 mt-2">
						<label for="custid">CUST ID <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-3">
							<input type="text" class="form-control" aria-label="Username" placeholder="Enter cust id" aria-describedby="basic-addon1" id="custid" name="custid" style="text-transform: uppercase;" required>
						</div>
					</div>
				</div>

				<script>
					function custIdAuto() {
						const typecust = document.getElementById('typecust');
						const custid = document.getElementById('custid');
						const custidRow = document.getElementById('custidRow');
						const selectedValue = typecust.value;

						if (selectedValue == 'OPS') {
							custidRow.style.display = 'none'; // Sembunyikan CUST ID row
							custid.value = ''; // Kosongkan CUST ID
							custid.readOnly = true; // Set readOnly
						} else {
							custidRow.style.display = 'flex'; // Tampilkan kembali CUST ID row
							custid.readOnly = false; // Hilangkan readOnly
						}
					}
				</script>


				<div class="row">
					<div class="col-4 mt-2">
						<label for="name">NAME <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-4">
							<input type="text" class="form-control" aria-label="Username" placeholder="Enter customer name" aria-describedby="basic-addon1" id="name" name="name" style="text-transform: uppercase;" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="origin_id">ORIGIN ID <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-4">
							<input type="text" class="form-control" aria-label="Username" placeholder="Enter origin id" aria-describedby="basic-addon1" id="origin_id" name="originid" style="text-transform: uppercase;" required>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-4 mt-2">
						<label for="origin_name">ORIGIN NAME <span class="text-danger">*</span></label>
					</div>
					<div class="col">
						<div class="input-group input-group-dynamic mb-4">
							<input type="text" class="form-control" aria-label="Username" placeholder="terisi otomatis!, silakan masukkan ID" aria-describedby="basic-addon1" id="origin_name" name="originname" style="text-transform: uppercase;" required>
						</div>
					</div>
				</div>

				<script>
					document.getElementById('origin_id').addEventListener('input', function() {
						const originMapping = {
							'bdo10000': 'BANDUNG',
							'bdo10100': 'SOREANG',
							'bdo10129': 'RANCAEKEK',
							'bdo20200': 'SUMEDANG',
							'bdo20700': 'GARUT',
							'bdo21000': 'BANDUNG BARAT KAB',
							'bdo21200': 'CIANJUR',
							'bdo21222': 'CIANJUR SELATAN',
							// Tambahkan lebih banyak mapping sesuai kebutuhan
						};

						let originId = this.value.toLowerCase(); // Mengubah input menjadi huruf kecil agar sesuai dengan key di mapping
						let originName = originMapping[originId] || ''; // Default ke string kosong jika tidak ada ID yang cocok

						document.getElementById('origin_name').value = originName; // Isi Origin Name
					});
				</script>



				<div class="text-end mt-3">
					<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
				</div>
				<?= form_close(); ?>
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
					<h6 class="text-white ps-3 fw-light">Master Data Customer</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">No</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">cust id</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">name</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">type cust</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">origin id</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">origin name</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2">status</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2"></th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 pb-2"></th>
							</tr>
						</thead>
						<tbody>
							<!-- Data akan dimuat melalui JavaScript -->
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
				url: "<?= base_url('customers/view_data_table') ?>",
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





<!-- Modal -->
<?php foreach ($agenList as $al) : ?>
	<div class="modal fade" id="edit-<?= $al->id_cust; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="text-start ms-3">
						<h5 class="modal-title fw-bold" id="exampleModalLabel">EDIT CUSTOMER</h5>
						<small>Edit Status Customer</small>
					</div>
				</div>
				<div class="modal-body">
					<form action="<?= site_url('customers/edit_status') ?>" method="POST">

						<input type="hidden" name="id_cust" value="<?= $al->id_cust ?>">
						<input type="hidden" name="cust_name" value="<?= $al->cust_name ?>">

						<div class="row">
							<div class="col-4 mt-2">
								<label for="sn">STATUS <span class="text-danger">*</span></label>
							</div>
							<div class="col">
								<div class="input-group input-group-static mb-3">
									<select class="choices form-select" id="exampleFormControlSelect1" name="status" required>
										<option value="ACTIVE" <?= $al->status == 'ACTIVE' ? 'selected' : '' ?>>ACTIVE</option>
										<option value="IN-ACTIVE" <?= $al->status == 'IN-ACTIVE' ? 'selected' : '' ?>>IN-ACTIVE</option>
									</select>
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
<?php endforeach; ?>

<?php $this->load->view('components/footer') ?>
