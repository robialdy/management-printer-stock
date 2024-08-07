</main>

</div>

<script src="<?= base_url() ?>/public/datatables/datatables.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url() ?>public/js/material-dashboard.min.js?v=3.1.0"></script>

<!-- modal -->
<script src="<?= base_url() ?>public/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>public/js/core/popper.min.js"></script>

<script>
	const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
		searchable: true,
		fixedHeight: true,
		sortable: true,
	});
</script>

</body>

</html>
