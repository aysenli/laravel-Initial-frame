
$(function(){
	
	//table切换
	$(".headbar ul.tab").idTabs(); 

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


})

