<footer class="position-fixed bottom-0 end-0 m-2">
	<p class="mb-0">
		© <script>
			document.write(new Date().getFullYear())
		</script>,
		Made with <span style="color: #e25555;">♥</span> by <strong>IT Project & PKL</strong> V.1.0.0
	</p>
</footer>

</main>

</div>


<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<!-- <script src="<?= base_url() ?>public/js/material-dashboard.min.js?v=3.1.0"></script> -->
<script src="<?= base_url() ?>public/js/material-dashboard.js"></script>


<!-- plugin -->
<script src="<?= base_url() ?>public/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>public/js/core/popper.min.js"></script>
<script src="<?= base_url() ?>public/js/plugins/sweetalert.min.js"></script>
<script src="<?= base_url() ?>public/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= base_url() ?>public/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?= base_url() ?>/public/datatables/datatables.js"></script>

<!-- select ssearch -->
<script src="<?= base_url() ?>public/select_search/choices.js"></script>
<script src="<?= base_url() ?>public/select_search/form-element-select.js"></script>



<script>
	const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
		sortable: false,
		perPage: 10,
	});



	const dataTableSearch2 = new simpleDatatables.DataTable("#datatable-search2", {
		sortable: false,
		perPage: 30,
	});
</script>




</body>

</html>
