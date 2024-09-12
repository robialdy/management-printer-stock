<?php $this->load->view('components/header') ?>



<div class="row">
	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		<div class="card border-radius-lg">
			<div class="card-header p-3 pt-2">
				<a href="<?= site_url('printer') ?>" class="icon icon-xl icon-shape bg-gradient-warning shadow-warning text-right border-radius-sm mt-n4 position-absolute">
					<p class="text-white p-3">Total Printer</p>
				</a>
				<div class="text-end pt-1">
					<p class="text-sm mb-0 text-capitalize">Total</p>
					<h4 class="mb-0"><?= $jumPrinter ?></h4>
				</div>
			</div>
			<hr class="dark horizontal">
		</div>
	</div>

	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		<div class="card border-radius-lg">
			<div class="card-header p-3 pt-2">
				<a href="<?= site_url('printer') ?>" class="icon icon-xl icon-shape bg-gradient-primary shadow-primary text-right border-radius-sm mt-n4 position-absolute">
					<p class="text-white p-3">Total Backup</p>
				</a>
				<div class="text-end pt-1">
					<p class="text-sm mb-0 text-capitalize">Total</p>
					<h4 class="mb-0"><?= $jumBackup ?></h4>
				</div>
			</div>
			<hr class="dark horizontal">
		</div>
	</div>

	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		<div class="card border-radius-lg">
			<div class="card-header p-3 pt-2">
				<a href="<?= site_url('damage') ?>" class="icon icon-xl icon-shape bg-gradient-success shadow-success text-right border-radius-sm mt-n4 position-absolute">
					<p class="text-white p-3">Total Damage</p>
				</a>
				<div class="text-end pt-1">
					<p class="text-sm mb-0 text-capitalize">Total</p>
					<h4 class="mb-0"><?= $jumdamage ?></h4>
				</div>
			</div>
			<hr class="dark horizontal">
		</div>
	</div>

	<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
		<div class="card border-radius-lg">
			<div class="card-header p-3 pt-2">
				<a href="<?= site_url('replacement') ?>" class="icon icon-xl icon-shape bg-gradient-info shadow-info text-right border-radius-sm mt-n4 position-absolute">
					<p class="text-white p-3">Peminjaman Printer</p>
				</a>
				<div class="text-end pt-1">
					<p class="text-sm mb-0 text-capitalize">Total</p>
					<h4 class="mb-0"><?= $jumPembelian ?></h4>
				</div>
			</div>
			<hr class="dark horizontal">
		</div>
	</div>
</div>


<?php $this->load->view('components/footer') ?>
