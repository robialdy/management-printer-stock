<style>
	.bi-plus-lg:hover {
		text-decoration: underline;
	}
</style>

<!-- Modal Select Printer -->
<div class="modal fade" id="modalselect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-start ms-3">
					<h5 class="modal-title fw-bold" id="exampleModalLabel">SELECT PRINTER REPLACEMENT</h5>
					<small>Silahkan Memilih Printer Yang Ingin Ditukar</small>
				</div>
			</div>
			<div class="modal-body">
				<div class="overflow-auto" style="max-height: 600px">
					<?php foreach ($printerselect as $index => $sp) : ?>
						<?= form_open('printerreplacement/insertWithDamage') ?>
						<div class="card mb-3">
							<div class="d-flex align-items-center p-3 border-radius-md">
								<span class="avatar text-bg-info avatar-lg fs-5">
									<i class="bi bi-printer"></i>
								</span>
								<div class="ms-3">
									<h6 class="mb-0 fs-sm">Printer SN <?= $sp->printer_sn ?></h6>
									<span class="text-muted fs-sm">Type <?= $sp->name_type ?></span>
								</div>
								<button type="button" class="btn text-muted fs-3 ms-auto my-auto" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $sp->id_printer_list ?>" aria-expanded="false">
									<i class="bi bi-plus-lg"></i>
								</button>
							</div>
							<div class="collapse" id="collapse-<?= $sp->id_printer_list ?>">
								<div class="card card-body">

									<div class="row mb-2">
										<div class="col-3 mt-2">
											<label for="typep">DESKRIPSI:</label>
										</div>
										<div class="col">
											<div class="input-group input-group-dynamic mb-4">
												<input type="text" class="form-control" aria-label="Username" placeholder="Enter Deskripsi kerusakan" id="typep" name="deskripsi" style="text-transform: uppercase;" required>
											</div>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="dus-<?= $index ?>" value="DUS">
											<label class="form-check-label" for="dus-<?= $index ?>">
												DUS
											</label>
										</div>
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="usb-<?= $index ?>" value="KABEL USB">
											<label class="form-check-label" for="usb-<?= $index ?>">
												KABEL USB
											</label>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="corelabel-<?= $index ?>" value="CORE LABEL 1">
											<label class="form-check-label" for="corelabel-<?= $index ?>">
												CORE LABEL 1
											</label>
										</div>
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="adaptor-<?= $index ?>" value="ADAPTOR">
											<label class="form-check-label" for="adaptor-<?= $index ?>">
												ADAPTOR
											</label>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="coreribbon-<?= $index ?>" value="CORE RIBBON 2">
											<label class="form-check-label" for="coreribbon-<?= $index ?>">
												CORE RIBBON 2
											</label>
										</div>
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="kuping-<?= $index ?>" value="KUPING CORE 2">
											<label class="form-check-label" for="kuping-<?= $index ?>">
												KUPING CORE 2
											</label>
										</div>
									</div>

									<div class="row mb-1">
										<div class="form-check col">
											<input class="childCheckbox" type="checkbox" name="kelengkapan_ker[]" id="power-<?= $index ?>" value="KABEL POWER">
											<label class="form-check-label" for="power-<?= $index ?>">
												KABEL POWER
											</label>
										</div>
									</div>

									<div class="row justify-content-center mt-2">
										<small class="col-auto text-danger" style="font-size: 0.75rem;">
											Kelengkapan Kerusakan, Kosongkan Jika Tidak Perlu
										</small>
									</div>

									<input type="hidden" value="<?= $sp->id_cust ?>" name="idcust">
									<input type="hidden" value="<?= $sp->printer_sn ?>" name="printersn">
									<input type="hidden" value="<?= $sp->id_printer ?>" name="idprinter">
									<input type="hidden" value="<?= $sp->proof ?>" name="loan_file">

									<!-- hidden untuk upload history -->
									<input type="hidden" value="<?= $sp->printer_sn ?>" name="_printer_sn">
									<input type="hidden" value="<?= $sp->cust_id ?>" name="_cust_id">
									<input type="hidden" value="<?= $sp->cust_name ?>" name="_cust_name">
									<input type="hidden" value="<?= $sp->date_out ?>" name="_date_out">

									<!-- Submit button -->
									<button type="submit" class="btn btn-info shadow mt-2">Submit</button>
								</div>
							</div>
						</div>
						<?= form_close(); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
