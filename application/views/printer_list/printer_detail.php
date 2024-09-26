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
					<h6 class="text-white ps-3 fw-light">Printer List Detail</h6>
				</div>
			</div>
			<div class="card-body px-0 pb-2">
				<div class="table-responsive p-0">
					<table class="table align-items-center table-hover" id="datatable-search">
						<thead>
							<tr>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">NO</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">ORIGIN</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">DATE IN</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">TYPE PRINTER</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">PRINTER SN</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">CUST.ID</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">CUST NAME</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">TYPE CUST</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">PIC IT</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">PIC USER</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">NO REF</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">DATE OUT</th>
								<th class="text-center text-uppercase text-info text-xs font-weight-bolder opacity-7 p-0 pb-2">STATUS</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach ($printer_detail as $pd) : ?>
								<tr>
									<td class="text-center text-uppercase py-3">
										<h6 class="mb-0 text-sm fw-normal"><?= $i++ ?></h6>
									</td>
									<td class="text-center text-uppercase py-3">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->origin; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->date_in; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->name_type; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->printer_sn; ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->cust_id ?></h6>
									</td>
									<td class="text-center text-uppercase py-3">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->cust_name ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->type_cust ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->pic_it ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->pic_user ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->no_ref ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal"><?= $pd->date_out ?></h6>
									</td>
									<td class="text-center text-uppercase">
										<h6 class="mb-0 text-sm fw-normal">ACTIVE</h6>
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
