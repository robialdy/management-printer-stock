<?php $this->load->view('components/header') ?>

<div class="card card-frame mb-4">
	<div class="card-body">
		<div class="row">
			<div class="col-6">
				<div class="input-group input-group-static">
					<label>From</label>
					<input type="date" class="form-control" id="from_date" name="from_date" value="<?= date('Y-m-d') ?>">
				</div>
			</div>
			<div class="col-6">
				<div class="input-group input-group-static">
					<label>Until</label>
					<input type="date" class="form-control" id="until_date" name="until_date" value="<?= date('Y-m-d') ?>">
				</div>
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
					<h6 class="text-white ps-3 fw-light">Users Log</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table table-hover align-items-center" id="datatable">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">No</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">Username</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">Role</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">ip address</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">os</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">browser</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7">login at</th>
							</tr>
						</thead>
						<tbody id="log_table_body">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('public/js/jquery.min.js') ?>"></script>

<script type="text/javascript">
	const processingIndicator = document.getElementById("loading");

	$(document).ready(function() {
		var dataTable;
		// Simpan nama token CSRF dalam variabel
		var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
		var csrfHash = '<?= $this->security->get_csrf_hash() ?>';

		function updateCsrfToken(newToken) {
			// Update token di variabel
			csrfHash = newToken;
			// Update token di form input hidden
			$('input[name="' + csrfName + '"]').val(newToken);
		}

		function fetchData() {
			processingIndicator.style.display = "block";

			var from_date = $('#from_date').val();
			var until_date = $('#until_date').val();

			// Buat object untuk data
			var postData = {
				from_date: from_date,
				until_date: until_date
			};
			// Tambahkan CSRF token ke data
			postData[csrfName] = csrfHash;

			$.ajax({
				url: "<?= base_url('users/view_user_log') ?>",
				method: "POST",
				data: postData,
				dataType: "json",
				success: function(data) {
					// Update CSRF token dengan token baru dari response
					if (data.token) {
						updateCsrfToken(data.token);
					}

					// Destroy DataTable jika sudah ada
					if (dataTable) {
						dataTable.destroy();
					}

					processingIndicator.style.display = "none";

					// Update table body dengan data baru
					$('#log_table_body').html(data.html);

					dataTable = new simpleDatatables.DataTable("#datatable", {
						sortable: false,
					});
				},
				error: function(xhr, status, error) {
					processingIndicator.style.display = "none";
					console.error('Error:', error);
					if (xhr.status === 403) {
						alert('Sesi telah berakhir. Silakan muat ulang halaman.');
					}
				}
			});
		}

		// Event handler untuk perubahan tanggal
		$('#from_date, #until_date').on('change', function() {
			fetchData();
		});

		// Fetch data saat halaman dimuat
		fetchData();
	});
</script>




<?php $this->load->view('components/footer') ?>
