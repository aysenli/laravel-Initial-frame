$(function() {
	//load隐藏
	$("#preloader").preloader('close');

	//
	$('.M').hover(
	    function(){
	      $(this).addClass('active');
	    },
	    function(){
	      $(this).removeClass('active');
	    }
    );


});

function change(id, choose)
{
  document.getElementById(id).value = choose.options[choose.selectedIndex].title;
}

$("input").on('blur', function(event) {
  event.preventDefault();
  $(this).css({borderColor:'#dcdcdc'});
});
$("input").on('focus', function(event) {
  event.preventDefault();
  $(this).css({borderColor:'#fc9938'});
});

if(typeof h != 'undefined'){
	h.init({url:'/Admin/Other/upload'});
	$('.uploadfiledome').bind('change',function(){
	    h.fileHandler(this);
	});
}

$(".uploadINPUT").click(function(){
	var UploadDialog = window.top.art.dialog({      
      width:640,
      height:32,
      cancel: true
    });
    // jQuery ajax   
	$.ajax({
	    url:'/Admin/Other/upload/dome/'+$(this).data('id'),
	    success: function (data) {
	        UploadDialog.content(data);
	    },
	    cache: false
	});
});