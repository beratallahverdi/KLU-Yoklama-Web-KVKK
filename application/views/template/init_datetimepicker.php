
<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo base_url();?>/assets/js/bootstrap-datetimepicker.min.js"></script>

<script>
$(document).ready(function () {
	$("input[type='text'][inputDateTime='true']").each(function(){
		if($(this).attr("name") === "BASLANGIC"){
			$(this).datetimepicker	(
										{
											defaultDate:<?php echo (isset($ongorulen_ders["ZAMAN_BASLANGIC"]))? "moment('".$ongorulen_ders["ZAMAN_BASLANGIC"]."')": "moment.now()";?>,
											locale:"tr",
											format: 'YYYY-MM-DD HH:mm',
											minDate:moment.now(),
											sideBySide:true	
										}
									);
		}
		else if($(this).attr("name") === "BITIS"){
			$(this).datetimepicker	(
										{
											defaultDate:<?php echo (isset($ongorulen_ders["ZAMAN_BITIS"]))? "moment('".$ongorulen_ders["ZAMAN_BITIS"]."')": "moment.now()";?>,
											locale:"tr",
											format: 'YYYY-MM-DD HH:mm',
											minDate:moment.now(),
											sideBySide:true
										}
									);
		}
		else{
			$(this).datetimepicker	(
										{
											defaultDate:moment.now(),
											locale:"tr",
											format: 'YYYY-MM-DD HH:mm',
											minDate:moment.now(),
											sideBySide:true
										}
									);
		}
  	})
});
</script>
