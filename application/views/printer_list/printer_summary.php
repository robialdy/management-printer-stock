<?php $this->load->view('components/header') ?>

<style>
	/* css di file sistem material-dashboard.css */
	/* .dataTable-wrapper .dataTable-container .table tbody tr td {
		padding: .75rem 1.5rem
	} */
</style>

<div class="row">
	<div class="col-auto ms-auto me-5">
		<form action="<?= site_url('printerlist/export_excel') ?>" method="POST">
			<button type="submit" class="btn bg-gradient-info text-white border-radius-sm" data-bs-toggle="modal" data-bs-target="#modalInsert">
				<i class="material-icons me-1">download</i>Download Report
			</button>
		</form>
	</div>
</div>

<div id="loading" style="display: none; position: absolute; top: 120%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
	<div class="spinner-border text-info" role="status">
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">Printer List Summary</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable">
						<thead>
							<tr>
								<td class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">NO</td>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">CUST.ID</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">TYPE CUST</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">CUST NAME</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">SYSTEM</th>
								<?php foreach ($type_printer as $tp): ?>
									<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2"><?= $tp->name_type; ?></th>
								<?php endforeach; ?>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">TOTAL</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">CN LABEL STATUS</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">ORIGIN ID</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">ORIGIN NAME</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerlist/view_data_table_summary') ?>",
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
