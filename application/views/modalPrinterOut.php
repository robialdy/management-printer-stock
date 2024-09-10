<!-- Modal -->
<div class="modal fade" id="modalprinterout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-center">
					<h5 class="modal-title font-weight-normal" id="exampleModalLabel">Printer Out</h5>
				</div>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?= site_url() ?>printerreplacement/insert">

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">PRINTER S/N <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-3">
								<select class="choices form-select" id="exampleFormControlSelect1" name="printersn" required>
									<option value="" selected disabled>ENTER PRINTER S/N</option>
									<?php foreach ($printer as $pr) : ?>
										<option value="<?= $pr['id_printer']; ?>"><?= $pr['printer_sn']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">CUST NAME <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-3">
								<select class="choices form-select" id="exampleFormControlSelect1" name="agenname" required>
									<option value="" selected disabled>ENTER cust NAME</option>
									<?php foreach ($cust as $ag) : ?>
										<option value="<?= $ag->id_cust; ?>"><?= $ag->cust_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC IT <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic it" aria-describedby="basic-addon1" id="typep" name="picit" style="text-transform: uppercase;" required minlength="3">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC USER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-4">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic user" aria-describedby="basic-addon1" id="typep" name="picuser" style="text-transform: uppercase;" required minlength="3">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">KELENGKAPAN</label>
						</div>
						<div class="col mt-2">

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="dus" value="DUS">
									<label class="form-check-label" for="dus">
										DUS
									</label>
								</div>
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="usb" value="KABEL USB">
									<label class="form-check-label" for="usb">
										KABEL USB
									</label>
								</div>
							</div>

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="corelabel" value="CORE LABEL 1">
									<label class="form-check-label" for="corelabel">
										CORE LABEL 1
									</label>
								</div>
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="adaptor" value="ADAPTOR">
									<label class="form-check-label" for="adaptor">
										ADAPTOR
									</label>
								</div>
							</div>

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="coreribbon" value="CORE RIBBON 2">
									<label class="form-check-label" for="coreribbon">
										CORE RIBBON 2
									</label>
								</div>
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="kuping" value="KUPING CORE 2">
									<label class="form-check-label" for="kuping">
										KUPING CORE 2
									</label>
								</div>
							</div>

							<div class="row mb-1">
								<div class="form-check col">
									<input class="childCheckbox" type="checkbox" name="kelengkapan[]" id="power" value="KABEL POWER">
									<label class="form-check-label" for="power">
										KABEL POWER
									</label>
								</div>
							</div>

							<!-- Checkbox untuk memilih semua -->
							<div class="row mt-1">
								<div class="form-check col">
									<input class="" type="checkbox" id="masterCheckbox">
									<label class="form-check-label" for="masterCheckbox">
										PILIH SEMUA
										<i class="material-icons text-info">done_all</i>
									</label>
								</div>
							</div>
						</div>
					</div>



					<script>
						// Ambil checkbox utama
						var masterCheckbox = document.getElementById('masterCheckbox');

						// Tambahkan event listener untuk checkbox utama
						masterCheckbox.addEventListener('click', function() {
							// Ambil semua checkbox dengan class 'childCheckbox'
							var checkboxes = document.querySelectorAll('.childCheckbox');

							checkboxes.forEach(function(checkbox) {
								checkbox.checked = masterCheckbox.checked;
							});
						});
					</script>


					<div class="text-end mt-3">
						<button type="button" class="btn bg-white" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn bg-gradient-info text-white border-radius-sm">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

