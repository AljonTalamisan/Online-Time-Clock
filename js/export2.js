$( document ).ready(function() {
	$(".dataExport").click(function() {
		var exportType = $(this).data('type');		
		$('#dataTable2').tableExport({
			type : exportType,			
			escape : 'false',
			ignoreColumn: []
		});		
	});
});
