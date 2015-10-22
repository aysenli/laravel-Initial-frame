
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

	

	$('[rel="preloader"]').bind('submit',function(){
		var invalid = true;
		for(var i = 0; i < this.elements.length; i++)
        {
        	var e = this.elements[i];
        	if((e.type == "text" || e.type == "password" || e.type == "select-one" || e.type == "textarea") && e.getAttribute("pattern") && e.style.display!='none' && e.offsetWidth > 0)
            {
            	if (e.className.indexOf(" invalid-text")==-1)
				{
					invalid = false;
				}
            }
        }
			
        if(invalid){
        	$("#preloader").preloader('open');
        }
		// console.log(this.elements);	
	});


	

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
