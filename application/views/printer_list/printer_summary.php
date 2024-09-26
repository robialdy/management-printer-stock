<?php $this->load->view('components/header') ?>

<style>
	/* css di file sistem material-dashboard.css */
	/* .dataTable-wrapper .dataTable-container .table tbody tr td {
		padding: .75rem 1.5rem
	} */
</style>

<div class="row">
	<div class="col-12">
		<div class="card my-4 border-radius-md">
			<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				<div class="bg-gradient-info shadow-info border-radius-md pt-4 pb-3">
					<h6 class="text-white ps-3 fw-light">Printer List Summary</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable-search">
						<thead>
							<tr>
								<td class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">NO</td>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">CUST.ID</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">TYPE CUST</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">CUST NAME</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">SYSTEM</th>
								<?php foreach ($type_printer as $tp): ?>
									<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2"><?= $tp->name_type; ?></th>
								<?php endforeach; ?>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">TOTAL</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">CN LABEL STATUS</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">ORIGIN ID</th>
								<th class="text-center text-uppercase text-info text-sm font-weight-bolder opacity-7 p-0 pb-2">ORIGIN NAME</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($printer_summary as $pd) : ?>
								<tr>
									<td class="text-center text-uppercase py-3">
										<h6 class="mb-0 text-md fw-normal"><?= $i++ ?></h6>
									</td>
									<td class="text-center text-uppercase py-3">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->cust_id; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->type_cust; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->cust_name; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->system; ?></h6>
									</td>
									<?php foreach ($type_printer as $tp): ?>
										<?php
										$name_type_alias = 'total_' . str_replace('-', '_', $tp->name_type);
										?>
										<td class="text-center text-uppercase">
											<h6 class="mb-0 text-md fw-normal"><?= $pd->$name_type_alias; ?></h6>
										</td>
									<?php endforeach; ?>
									<td class="text-center text-uppercase py-3">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->total_printer ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->cn_label_status; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->origin_id; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-md fw-normal"><?= $pd->origin_name; ?></h6>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('components/footer') ?>
