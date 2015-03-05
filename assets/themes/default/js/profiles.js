/*!
 * Application 1.0
 * Copyright 2014 Andrew Kustes
 */
 
$(document).ready(function(){

    
    /* ===================== Modals ==================== */  
    
    $('#send-message').click(function(e){
	     
	      e.preventDefault();
	      
	      var datastring = $("#composeForm").serialize();

		  $.ajax({
		     type: 'POST',
		     url: base_url + 'messages/send_message',
		     data: datastring,
			 cache: false,
		     success: function(result) {
				$('#confirm-message').modal('hide');
		     },
             error: function(){
                  alert('There was an Error Sending Your Message.. Try Again');
             }
		  });
    });
    
    $('#favorite').click(function(e){
        
	    e.preventDefault();
	      
	      var datastring = $("#favoriteForm").serialize();

		  $.ajax({
		     type: 'POST',
		     url: base_url + 'profiles/favorite',
		     data: datastring,
			 cache: false,
		     success: function(result) {
				$('#confirm-favorite').modal('hide');
		     },
             error: function(){
                  alert('There was an Error Saving your Favorite.. Try Again');
             }
		  });
    });
    
    $('#blocked').click(function(e){
        
	     e.preventDefault();
	      
	      var datastring = $("#blockedForm").serialize();

		  $.ajax({
		     type: 'POST',
		     url: base_url + 'profiles/blocked',
		     data: datastring,
			 cache: false,
		     success: function(result) {
				$('#confirm-blocked').modal('hide');
		     },
             error: function(){
                  alert('There was an Error Blocking the Member.. Try Again'); 
             }
		  });
    });
    
    
     $('.owl-carousel-images').owlCarousel({
            items: 6,
            loop: false,
            center: true,
            margin: 10,
            callbacks: true,
            URLhashListener: true,
            autoplayHoverPause: true,
            startPosition: 'URLHash',
            autoHeight: false,
            dots: false
    });
    
    
     $('.open').on('click',function(){
            var src = $(this).attr('data-image-source');
            var img = '<img src="' + src + '" class="img-responsive"/>';
            
            $('#myModal').modal();
            $('#myModal').on('shown.bs.modal', function(){
                $('#myModal .modal-body').html(img);
            });
            $('#myModal').on('hidden.bs.modal', function(){
                $('#myModal .modal-body').html('');
            });
    });  
    
});