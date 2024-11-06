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
			<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
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

<div id="modal-container">

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
				data: {
					'<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
				},
				dataType: "json",
				success: function(response) {
					const tableBody = $('#datatable tbody');
					tableBody.empty(); // Kosongkan tabel 
					tableBody.append(response.html);

					// Update CSRF token setelah data dimuat
					$('input[name="<?= $this->security->get_csrf_token_name() ?>"]').val(response.token);

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

	$(document).ready(function() {
		$(document).on('hidden.bs.modal', '#detail', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-detail', function() {
			var modalID = '#detail';

			// AJAX request
			$.ajax({
				url: '<?= site_url('printerlist/modal_detail_summary') ?>',
				type: 'POST',
				data: {
					modal: $(this).data('modal'),
					'<?= $this->security->get_csrf_token_name() ?>': $('input[name="<?= $this->security->get_csrf_token_name() ?>"]').val()
				},
				dataType: "json",
				success: function(response) {
					// Update CSRF token dan tampilkan modal
					if (response.token) {
						$('input[name="<?= $this->security->get_csrf_token_name() ?>"]').val(response.token);
					}
					$('#modal-container').html(response.html);
					$(modalID).modal('show');
					// Inisialisasi choices
					const choices = new Choices($(modalID + ' .choices')[0]);
				},
			});
		});
	});
</script>

<?php $this->load->view('components/footer') ?>
