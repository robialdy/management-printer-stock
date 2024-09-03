<style>
	.bi-plus-lg:hover {
		text-decoration: underline;
	}
</style>

<!-- Modal Select Printer -->
<div class="modal fade" id="modaldamageselect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="text-end me-1">
				<button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="text-center">
					<h5 class="modal-title font-weight-normal" id="exampleModalLabel">SELECT PRINTER TO DAMAGE</h5>
				</div>
			</div>
			<div class="modal-body">
				<small class="ms-2 py-1">Printer Pembelian <?= $damageselect['cust_name'] ?><i class="ps-1 bi bi-arrow-down"></i>
				</small>
				<?php foreach ($damageselect['printerdamageselect'] as $sp) : ?>
					<form method="POST" action="<?= site_url() ?>printerreplacement/insertDamage">
						<div class="card mb-3">
							<div class="d-flex align-items-center p-3 border-radius-md">
								<span class="avatar text-bg-info avatar-lg fs-5">
									<i class="bi bi-printer"></i>
								</span>
								<div class="ms-3">
									<h6 class="mb-0 fs-sm">Printer SN <?= $sp->printer_sn ?></h6>
									<span class="text-muted fs-sm">Type <?= $sp->type_printer ?></span>
								</div>
								<input type="hidden" value="<?= $sp->id_printer ?>" name="idprinter">
								<input type="hidden" value="<?= $sp->id_cust ?>" name="idagen">
								<input type="hidden" value="<?= $sp->id_replacement ?>" name="idreplacement">

								<button type="submit" class="btn text-muted fs-3 ms-auto my-auto" type="button">
									<i class="bi bi-plus-lg"></i>
								</button>
							</div>
						</div>
					</form>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
</div>
