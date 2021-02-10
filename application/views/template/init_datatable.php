<!-- Page level plugins -->
<script src="<?php echo base_url();?>/assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
	$('#dataTable').DataTable(
		{
			"bPaginate": false,
			"bLengthChange": true,
			"bFilter": false,
			"bInfo": false,
			"bAutoWidth": false,
			"responsive": true
		}
    );
});
</script>
<style>

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}
</style>
