$('#login_btn').live('click', function(event) {
	event.preventDefault();
	var serialized_data = jQuery("#login_form").serialize();
	$.ajax({
	  type: 'POST',
	  data: serialized_data,
	  dataType: 'json',
	  url: 'listeners/check_login.php',
	  success: function(msg) {
	  	if(msg.code=='0') {
	  		$('#login_notification').html(msg.display);
	  	}
	  	else {
	  		window.location = './home.php';
	  	}
	  }
	});
});

/*
Back to posting definition
*/
jQuery('#cancel_publish_btn').live('click', function(event) {
	event.preventDefault();
	jQuery("input[type='checkbox']").removeAttr("disabled");
	jQuery('#post_btn').removeAttr("disabled");
	$('#posting_box').show();
	$('#preview_posting_box').hide();
});

/*
Status updates publishing
*/
jQuery('#publish_btn').live('click', function(event) {
	event.preventDefault();
	var obj = $('body').data('status_obj');
	var twt_status = $('#twt_status').html();
	jQuery('#publish_btn').attr("disabled", "disabled");
	
	jQuery.ajax({
	  type: 'POST',
	  url: 'listeners/publish_status.php',
	  data: 'twt_ids='+obj.twt_ids+'&fb_ids='+obj.fb_ids+'&status='+obj.status+'&link='+obj.link+'&image='+obj.image+'&twt_status='+twt_status,
	  success: function(msg){
	  	alert(msg);
	  	window.location.reload();
	  }
	});
});

/*
Preview
*/
jQuery('#post_btn').live('click', function(event) {
	event.preventDefault();
	
	var status = jQuery('#status').val();
	var link = jQuery('#link').val();
	var image = jQuery('#image').val();
	
	var twt_ids = '';
	jQuery.each(jQuery("input[name='twt_accounts[]']:checked"), function() {
		twt_ids += (twt_ids?',':'') + jQuery(this).attr('data-user-id');
	});
	
	var fb_ids = '';
	jQuery.each(jQuery("input[name='fb_accounts[]']:checked"), function() {
		fb_ids += (fb_ids?',':'') + jQuery(this).attr('data-user-id');
	});
	
	var obj = {};
	obj.status = status;
	obj.link = link;
	obj.image = image;
	obj.twt_ids = twt_ids;
	obj.fb_ids = fb_ids;
	$('body').data('status_obj', obj);
	
	if(twt_ids=='' && fb_ids=='') {
		alert('At least an account needs to be selected');
		exit();
	}
	if(status=='') {
		alert('A message / status is required');
		exit();
	}
	
	jQuery('#post_btn').attr("disabled", "disabled");
	jQuery("input[type='checkbox']").attr("disabled", "disabled");
	
	jQuery.ajax({
	  type: 'POST',
	  url: 'listeners/preview_posting.php',
	  data: 'twt_ids='+twt_ids+'&fb_ids='+fb_ids+'&status='+status+'&link='+link+'&image='+image,
	  success: function(msg){
	  	$('#preview_posting_box').html(msg).show();
	  	$('#posting_box').hide();
	  }
	});
});
