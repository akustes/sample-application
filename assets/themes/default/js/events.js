/*!
 * Application 1.0
 * Copyright 2014 Andrew Kustes
 */
 
$(document).ready(function(){

  /* ===================== Modals ==================== */  
  
  /* Confirmation Modals */
  $('#confirm-delete').on('show.bs.modal', function(e) {
	 $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
	 $('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
  });
  
  $('#confirm-active').on('show.bs.modal', function(e) {
	 $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
	 $('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
  });
  
  $('#confirm-deactive').on('show.bs.modal', function(e) {
	 $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
	 $('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
  });
  
  $('#confirm-completed').on('show.bs.modal', function(e) {
	 $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
	 $('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
  });
  
  $('#confirm-not-completed').on('show.bs.modal', function(e) {
	 $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
	 $('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
  });

  
  $('#confirm-restore').on('show.bs.modal', function(e) {
	 $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));
	 $('.debug-url').html('Delete URL: <strong>' + $(this).find('.danger').attr('href') + '</strong>');
  });
  
    
  /* ===================== Utilities ==================== */ 
  
  /* Print Button */
  $('#print').click(function() {		
		window.print();
		$('#confirm-print').modal('hide');
  });
  
  $('#start_date').datetimepicker({
	 format:'Y-m-d h:i A',
	 formatTime:'h:i A'
  });
  
   $('#end_date').datetimepicker({
	format:'Y-m-d h:i A',
	formatTime:'h:i A'
  });

     
});
