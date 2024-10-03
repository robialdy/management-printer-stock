<?php $this->load->view('components/header') ?>

<div class="row">
	<h4 class="pb-3">Jumlah Printer <span class="fs-6 fw-light">(Backup & Peminjaman)</span></h4>

	<div class="col-6 col-md-2">
		<div class="card p-3 position-relative">
			<div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 position-absolute">
				<i class="material-icons opacity-10">print</i>
			</div>
			<div class="text-end pt-1">
				<p class="text-sm mb-0 text-capitalize">Total Printer</p>
				<h4 class="mb-0"><?= $jumPrinter ?></h4>
			</div>
		</div>
	</div>

	<?php foreach ($jumPrinter_type as $jp) : ?>
		<div class="col-6 col-md-2">
			<div class="card p-3 position-relative">
				<div class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 me-3 position-absolute">
					<i class="material-icons opacity-10">print</i>
				</div>
				<div class="text-end pt-1">
					<p class="text-sm mb-0 text-capitalize"><?= $jp['name_type'] ?></p>
					<h4 class="mb-0"><?= $jp['total_printers'] ?></h4>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<div class="row mt-4">
	<h4 class="pb-3">Printer</h4>

	<div class="col-6 col-md-2">
		<div class="card p-3 position-relative">
			<div class="icon icon-lg icon-shape bg-gradient-success shadow text-center border-radius-xl mt-n4 me-3 position-absolute">
				<i class="material-icons opacity-10">print</i>
			</div>
			<div class="text-end pt-1">
				<p class="text-sm mb-0 text-capitalize">Printer Backup</p>
				<h4 class="mb-0"><?= $jumBackup ?></h4>
			</div>
		</div>
	</div>

	<div class="col-6 col-md-2">
		<div class="card p-3 position-relative">
			<div class="icon icon-lg icon-shape bg-gradient-danger shadow text-center border-radius-xl mt-n4 me-3 position-absolute">
				<i class="material-icons opacity-10">print</i>
			</div>
			<div class="text-end pt-1">
				<p class="text-sm mb-0 text-capitalize">Printer Damage</p>
				<h4 class="mb-0">10</h4>
			</div>
		</div>
	</div>

	<div class="col-6 col-md-2">
		<div class="card p-3 position-relative">
			<div class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 me-3 position-absolute">
				<i class="material-icons opacity-10">print</i>
			</div>
			<div class="text-end pt-1">
				<p class="text-sm mb-0 text-capitalize">Printer Peminjaman</p>
				<h4 class="mb-0">10</h4>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('components/footer') ?>
