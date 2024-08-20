<footer class="position-fixed bottom-0 end-0 m-2">
	<p class="mb-0">
		© <script>
			document.write(new Date().getFullYear())
		</script>,
		Made with <span style="color: #e25555;">♥</span> by <strong>IT Project & PKL</strong>
	</p>
</footer>

</main>

</div>

<script src="<?= base_url() ?>/public/datatables/datatables.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url() ?>public/js/material-dashboard.min.js?v=3.1.0"></script>
<script src="<?= base_url() ?>public/js/material-dashboard.js"></script>

<!-- modal -->
<script src="<?= base_url() ?>public/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>public/js/core/popper.min.js"></script>

<!-- plugins -->
<script src="<?= base_url() ?>public/js/plugins/sweetalert.min.js"></script>

<!-- select ssearch -->
<script src="<?= base_url() ?>public/select_search/choices.js"></script>
<script src="<?= base_url() ?>public/select_search/form-element-select.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- countup -->
<script src="<?= base_url() ?>public/js/countup.min.js"></script>

<script>
	const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
		searchable: true,
		fixedHeight: true,
		sortable: false,
	});

	const dataTableSearch2 = new simpleDatatables.DataTable("#datatable-search2", {
		searchable: true,
		fixedHeight: true,
		sortable: false,
	});
</script>

</body>

</html>
