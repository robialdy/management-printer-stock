
	<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content p-1">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="text-center">
						<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Select Cust Name</h5>
					</div>
				</div>
				<div class="modal-body">

					<form method="POST" action="<?= site_url() ?>printerreplacement/modal_edit_damage">

						<div class="row mt-3">
							<div class="col-4 mt-2">
								<label for="sn">CUST NAME <span class="text-danger">*</span></label>
							</div>
							<div class="col">
								<div class="input-group input-group-static mb-3">
									<select class="choices form-select" id="exampleFormControlSelect1" name="agenname" required>
										<option value="" selected disabled>ENTER CUST NAME</option>
										<?php foreach ($cust_name as $a) : ?>
											<option value="<?= $a->id_cust; ?>"><?= $a->cust_name; ?></option>
										<?php endforeach ?>
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
