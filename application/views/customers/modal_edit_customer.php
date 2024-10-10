<div class="modal fade" id="edit-<?= $customer->id_cust; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

					<input type="hidden" name="id_cust" value="<?= $customer->id_cust ?>">
					<input type="hidden" name="cust_name" value="<?= $customer->cust_name ?>">

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">STATUS <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-3">
								<select class="choices form-select" id="exampleFormControlSelect1" name="status" required>
									<option value="ACTIVE" <?= $customer->status == 'ACTIVE' ? 'selected' : '' ?>>ACTIVE</option>
									<option value="IN-ACTIVE" <?= $customer->status == 'IN-ACTIVE' ? 'selected' : '' ?>>IN-ACTIVE</option>
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
