@extends('admin.main')


@section('content')
<div class="operating">
	<div class="search f_r">		
	</div>
	<a href="{{route('admin.rbac.permission.create')}}">
		<button type="button" class="operating_btn">
			<span class="addition">{{ trans('common.add') }}{{ trans('rbac.permission') }}</span>
		</button>
	</a>		
</div>

<div class="field">
	<table class="list_table">
		<colgroup>
			<col width="40px">
			<col>
			<col>
			<col>
			<col width="180px">
			<col width="180px">
			<col width="180px">
		</colgroup>

		<thead>
			<tr class="">
				<th>{{ trans('common.choice') }}</th>
				<th>{{ trans('rbac.permission_name') }}</th>
				<th>{{ trans('rbac.permission_display_name') }}</th>
				<th>{{ trans('common.description') }}</th>
				<th>{{ trans('common.created_at') }}</th>
				<th>{{ trans('common.updated_at') }}</th>				
				<th>{{ trans('common.operate') }}</th>
			</tr>
		</thead>
	</table>
</div>

<div class="content" style="height: 326px;">		
	<form name="groupFrom" method="post" action="{{ route('admin.rbac.permission.destroy') }}">
		<table class="list_table">
			<colgroup>
				<col width="40px">
				<col>
				<col>
				<col>
				<col width="180px">
				<col width="180px">
				<col width="180px">
			</colgroup>
			<tbody>	
			@foreach ($permissionRows as $element)			
				<tr  data-id="{{$element['id']}}" data-parent="{{$element['pid']}}">
					<td><input type="checkbox" value="{{$element['id']}}" class="item_checkbox" name="id[]"></td>
					<td>
						<img class="operator" src="/static/admin/images/close.gif"  alt="关闭">						
						{{$element['name']}}
					</td>
					<td>{{$element['display_name']}}</td>
					<td>{{$element['description']}}</td>
					<td>{{$element['created_at']}}</td>
					<td>{{$element['updated_at']}}</td>
					<td></td>
				</tr>
				@if(isset($element['children']))
					@foreach ($element['children'] as $el)					
					<tr data-id="{{$el['id']}}" data-parent="{{$el['pid']}}">
						<td><input type="checkbox" value="{{$el['id']}}" class="item_checkbox" name="id[]"></td>
						<td>							
							<img class="operator"  style="margin-left:30px" src="/static/admin/images/close.gif"  alt="关闭">							
							{{$el['name']}}
						</td>
						<td>{{$el['display_name']}}</td>
						<td>{{$el['description']}}</td>
						<td>{{$el['created_at']}}</td>
						<td>{{$el['updated_at']}}</td>
						<td></td>
					</tr>
					@endforeach
				@endif
			@endforeach
			</tbody>

		</table>
	</form>
</div>


<script type="text/javascript">
	$('.list_table .operator').click(function(){
		var src = ['/static/admin/images/close.gif' , '/static/admin/images/open.gif'];
		var operatorTR = $(this).parent().parent();
		var pid = operatorTR.data('id');

		if($(this).attr('src') == src[0]){
			$(this).attr('src',src[1]);
			$("[data-parent='"+pid+"']").hide();
		}else{
			$(this).attr('src',src[0]);
			$("[data-parent='"+pid+"']").show();
		}
		
	});
</script>


@endsection