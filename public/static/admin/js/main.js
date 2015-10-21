
$(function(){
	//load隐藏
	$("#preloader").preloader('close');
	//table切换
	if(typeof $.fn.idTabs != 'undefined'){
		$(".headbar ul.tab").idTabs(); 
	}
	//checkboxClass
	if(typeof $.fn.checkboxClass != 'undefined'){
		$("[type='checkbox']").checkboxClass();
	}
	

	//隔行换色
	$(".list_table tr:nth-child(even)").addClass('even');
	$(".list_table tr").hover(
		function () {
			$(this).addClass("sel");
		},
		function () {
			$(this).removeClass("sel");
		}
	);

	//checkbox全选
	$(".all_checkbox").click(function(){	
		$(".item_checkbox").attr("checked" , true);		
	});

	
	if(typeof $.fn.ajaxsubmit != 'undefined'){
		$('[rel="submit"]').ajaxsubmit({success : function(json , xhrstatus , exception){
			var errorMessage = '';
			if(xhrstatus == 'success'){

			}else{
				console.log(json);
			    for (var Things in json.response) {
			      for (var i in json.response[Things]){
			        errorMessage += json.response[Things][i];
			      }
			    }
			    $.popstatus(4, errorMessage,true);
			}
		}});
	}

	

	//
	$('.M').hover(
	    function(){
	      $(this).addClass('active');
	    },
	    function(){
	      $(this).removeClass('active');
	    }
    );	

	$("input").bind('blur', function(event) {
	  event.preventDefault();
	  $(this).css({borderColor:'#dcdcdc'});
	});
	$("input").bind('focus', function(event) {
	  event.preventDefault();
	  $(this).css({borderColor:'#fc9938'});
	});


})

function change(id, choose)
{
  document.getElementById(id).value = choose.options[choose.selectedIndex].title;
}
