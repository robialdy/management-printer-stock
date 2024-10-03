<?php $this->load->view('components/header') ?>

<!-- success -->
<?php if ($this->session->flashdata('notifSuccess')) :  ?>
	<script>
		window.onload = function() {
			showSuccessMessage();
		};
	</script>
<?php endif; ?>

<script>
	function showSuccessMessage() {
		Swal.fire({
			icon: 'success',
			title: 'Good job!',
			text: '<?= $this->session->flashdata('notifSuccess') ?>',
			confirmButtonText: 'OK'
		});
	}
</script>

<?php if ($this->session->flashdata('notifError')) :  ?>
	<script>
		window.onload = function() {
			showErrorMessage();
		};
	</script>
<?php endif; ?>

<script>
	function showErrorMessage() {
		Swal.fire({
			icon: 'error',
			title: 'Sorry!',
			text: '<?= $this->session->flashdata('notifError') ?>',
			confirmButtonText: 'OK'
		});
	}
</script>

<div class="row">
	<!-- Bagian Kiri: Card Project Details -->
	<div class="col-lg-8 col-12 mx-auto position-relative">
		<div class="card">
			<!-- Card Header -->
			<div class="card-header p-3 pt-2">
				<div class="icon icon-lg icon-shape bg-gradient-info shadow text-center border-radius-xl mt-n4 me-3 float-start">
					<i class="material-icons opacity-10">print</i>
				</div>
				<h5 class="mb-0">Printer Detail</h5>
			</div>

			<!-- Card Body -->
			<div class="card-body pt-2">
				<!-- Project Details Section -->
				<div class="row mt-4">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">ORIGIN</label>
							<p class="form-text text-muted ms-1"><?= $detail->origin_name ?></p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">DATE IN</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->date_in ?>
							</p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">TYPE PRINTER</label>
							<p class="form-text text-muted ms-1"><?= $detail->name_type ?></p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">PRINTER SN</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->printer_sn ?>
							</p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">CUST ID</label>
							<p class="form-text text-muted ms-1"><?= $detail->cust_id ?></p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">TYPE CUST</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->type_cust ?>
							</p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">CUST NAME</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->cust_name ?>
							</p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">PIC IT</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->pic_it ?>
							</p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">PIC USER</label>
							<p class="form-text text-muted ms-1"><?= $detail->pic_user ?></p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">NO REF</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->no_ref ?>
							</p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">DATE OUT</label>
							<p class="form-text text-muted ms-1"><?= $detail->date_out ?></p>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label class="form-label fw-bold fs-6">KELENGKAPAN</label>
							<p class="form-text text-muted ms-1">
								<?= $detail->kelengkapan ?>
							</p>
						</div>
					</div>
				</div>

				<label class="form-label fw-bold fs-6">UPLOAD BUKTI TRANSAKSI</label>
				<div class="input-group">
						<?= form_open('printerlist/uploadProof', ['enctype' => 'multipart/form-data', 'class' => 'd-flex w-100 gap-2 align-items-center']) ?>
						<input type="hidden" name="idrep" value="<?= $detail->id_printer_list ?>">
						<input type="hidden" name="sn" value="<?= $detail->printer_sn ?>">
						<input type="hidden" name="proof" value="<?= $detail->proof ?>">

						<!-- Tombol pilih file -->
						<label class="btn btn-outline-secondary d-flex px-3 py-1" for="customFile">Pilih File</label>

						<!-- Custom file input -->
						<div class="d-flex align-items-center gap-3 w-100" style="cursor:pointer;" id="fileWrapper">
							<span id="fileName" class="form-text mb-3">No file chosen</span>
							<input type="file" class="d-none" id="customFile" name="file_proof">
						</div>

						<!-- Tombol Upload -->
						<div>
							<button class="btn btn-info px-4 py-2" type="submit" id="inputGroupFileAddon04">Upload</button>
						</div>
					<?= form_close(); ?>
				</div>

				<script>
					// klik div "fileWrapper" untuk membuka file dialog
					document.getElementById('fileWrapper').addEventListener('click', function() {
						document.getElementById('customFile').click();
					});

					// Ganti teks file name ketika file dipilih
					document.getElementById('customFile').addEventListener('change', function() {
						var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
						document.getElementById('fileName').textContent = fileName;
					});
				</script>


			</div>
		</div>
	</div>


	<!-- Bagian Kanan: Card Kecil -->
	<div class="col-lg-4 col-12">
		<div class="card">
			<div class="card-body text-center">
				<h6 class="mb-0">Cetak Format Transaksi</h6>
				<p class="text-muted mt-2">
					Pastikan Printer telah terhubung!
				</p>
				<form action="<?= site_url('formatprint/generate_format/' . $detail->printer_sn) ?>" target="_blank" method="POST">
					<button type="submit" class="btn bg-gradient-info">Cetak</button>
				</form>
			</div>
		</div>
		<div class="card mt-4">
			<div class="card-body text-center">
				<h6 class="mb-0">Bukti Transaksi</h6>
				<?php if ($detail->proof) : ?>
					<div class="mt-2">
						<p class="text-muted mt-2">
							Lihat bukti transaksi printer!
						</p>
						<button type="submit" data-bs-toggle="modal" data-bs-target="#proofModal" class="btn btn-link text-info"> <i class="material-icons fs-1">description</i></button>
					</div>
				<?php else : ?>
					<p class="text-muted mt-2">
						Tidak ada bukti transaksi yang tersedia. Upload bukti transaksi untuk menampilkan
					</p>
				<?php endif; ?>
			</div>
		</div>


	</div>
</div>


<!-- Modal untuk menampilkan gambar dalam ukuran besar -->
<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="imageModalLabel">Bukti Transaksi</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<?php if (substr($detail->proof, -4) === '.pdf') : ?>
					<iframe src="<?= base_url('public/proof_replacement/' . $detail->proof) ?>" width="100%" height="700px">
					</iframe>
				<?php else : ?>
					<div style="max-width: 100%; max-height: 700px; overflow: auto;">
						<img src="<?= base_url('public/proof_replacement/' . $detail->proof) ?>" alt="Bukti Transaksi" class="img-fluid">
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('components/footer') ?>
