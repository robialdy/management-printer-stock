<!-- Modal detail -->
<?php foreach ($replacement as $rp) : ?>
	<div class="modal fade" id="modalDetail<?= $rp->id_replacement ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="text-end me-1">
					<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="text-start ms-3">
						<h5 class="modal-title fw-bold" id="exampleModalLabel">DETAIL KELENGKAPAN PRINTER</h5>
						<small>Informasi Terkait Kelengkapan Printer</small>
					</div>
				</div>
				<div class="modal-body">

					<div class="mx-3 mt-2">
						<h5 class="font-weight-normal text-info text-gradient">Printer SN <?= $rp->printer_sn ?></h5>
						<blockquote class="blockquote text-white mb-0">
							<p class="text-dark ms-3"><?= $rp->kelengkapan ?></p>
						</blockquote>
					</div>


					<div class="text-end mt-3">
						<button type="button" class="btn bg-white shadow" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>
