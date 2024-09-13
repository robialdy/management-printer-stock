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

<!-- belum jalan date range nya -->
<!-- tidak kekirim value dari inputnya -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		var dataTable;

		function fetchData() {
			var from_date = $('#from_date').val();
			var until_date = $('#until_date').val();

			$.ajax({
				url: "<?= base_url('users/view_user_log') ?>",
				method: "POST",
				data: {
					from_date: from_date,
					until_date: until_date
				},
				success: function(data) {
					// Destroy DataTable if it exists
					if (dataTable) {
						dataTable.destroy();
					}

					// Update table body with new data
					$('#log_table_body').html(data);

					// Re-initialize DataTable
					dataTable = new simpleDatatables.DataTable("#datatable", {
						sortable: false,
					});
				}
			});
		}

		$('#from_date, #until_date').on('change', function() {
			fetchData();
		});

		// Fetch data on page load
		fetchData();
	});
</script>




<?php $this->load->view('components/footer') ?>
