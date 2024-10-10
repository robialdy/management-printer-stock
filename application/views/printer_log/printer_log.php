<?php $this->load->view('components/header') ?>


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
					<h6 class="text-white ps-3 fw-light">Printer Log</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table table-hover align-items-center" id="datatable">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-md font-weight-bolder opacity-7">No</th>
								<th class="text-center text-uppercase text-info text-md font-weight-bolder opacity-7">Printer sn</th>
								<th class="text-center text-uppercase text-info text-md font-weight-bolder opacity-7">status saat ini</th>
								<th class="text-center text-uppercase text-info text-md font-weight-bolder opacity-7"></th>
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
	<!-- modal dimuat -->
</div>

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<script>
	$(document).ready(function() {
		loadData(); // Memuat halaman

		function loadData() {

			$('#loading').show();

			$.ajax({
				url: "<?= base_url('printerlog/view_data_table') ?>",
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
		$(document).on('hidden.bs.modal', '#detail', function() {
			$(this).remove();
		});

		$(document).on('click', '.btn-detail', function() {
			var modalID = '#detail';

			// AJAX request
			$.ajax({
				url: '<?= site_url('printerlog/modal_detail') ?>',
				type: 'POST',
				data: {
					modal: $(this).data('modal'),
				},
				success: function(response) {
					$('#modal-container').html(response);
					$(modalID).modal('show');
				},
			});
		});
	});
</script>





<?php $this->load->view('components/footer') ?>
