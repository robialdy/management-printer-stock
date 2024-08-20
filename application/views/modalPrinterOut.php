<!-- Modal -->
<div class="modal fade" id="modalprinterout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
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
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="exampleFormControlSelect1" name="printersn" required>
									<option value="" selected disabled>Enter Printer S/N</option>
									<?php foreach ($printer as $pr) : ?>
										<option value="<?= $pr['id_printer']; ?>"><?= $pr['printer_sn']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="sn">AGEN NAME <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-static mb-2">
								<select class="choices form-select" id="exampleFormControlSelect1" name="agenname" required>
									<option value="" selected disabled>Enter Agen Name</option>
									<?php foreach ($agen as $ag) : ?>
										<option value="<?= $ag['id_agen']; ?>"><?= $ag['agen_name']; ?></option>
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
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic it" aria-describedby="basic-addon1" id="typep" name="picit" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">PIC USER <span class="text-danger">*</span></label>
						</div>
						<div class="col">
							<div class="input-group input-group-dynamic mb-2">
								<input type="text" class="form-control" aria-label="Username" placeholder="Enter pic user" aria-describedby="basic-addon1" id="typep" name="picuser" style="text-transform: uppercase;" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-4 mt-2">
							<label for="typep">KELENGKAPAN</label>
						</div>
						<div class="col mt-2">
							<div class="row">
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="dus" value="DUS">
									<label class="form-check-label" for="dus">
										DUS
									</label>
								</div>
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="usb" value="KABEL USB">
									<label class="form-check-label" for="usb">
										KABEL USB
									</label>
								</div>
							</div>

							<div class="row">
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="corelabel" value="CORE LABEL 1">
									<label class="form-check-label" for="corelabel">
										CORE LABEL 1
									</label>
								</div>
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="adaptor" value="ADAPTOR">
									<label class="form-check-label" for="adaptor">
										ADAPTOR
									</label>
								</div>
							</div>

							<div class="row">
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="coreribbon" value="CORE RIBBON 2">
									<label class="form-check-label" for="coreribbon">
										CORE RIBBON 2
									</label>
								</div>
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="kuping" value="KUPING CORE 2">
									<label class="form-check-label" for="kuping">
										KUPING CORE 2
									</label>
								</div>
							</div>

							<div class="row">
								<div class="form-check col">
									<input class="" type="checkbox" name="kelengkapan[]" id="power" value="KABEL POWER">
									<label class="form-check-label" for="power">
										KABEL POWER
									</label>
								</div>
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
