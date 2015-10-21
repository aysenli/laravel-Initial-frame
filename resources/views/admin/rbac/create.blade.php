@extends('admin.main')

@section('content')
	{{-- expr --}}
<div class="headbar">
	<ul class="tab" name="menu1">
		<li><a href="#tab-1" hidefocus="true" class="selected">{{ trans('common.basic_information') }}</a></li>
		<li><a href="#tab-2" hidefocus="true">{{ trans('rbac.role_permissions') }}</a></li>
		<li><a href="#tab-3" hidefocus="true">{{ trans('rbac.role_navigation') }}</a></li>
	</ul>

</div>

<div class="content_box">
	<div class="content form_content">
		<form method="post" action="{{ route('admin.rbac.roles.store') }}" rel="submit">
			<table class="form_table" cellpadding="0" cellspacing="0" id="tab-1">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				<tr>
					<th>{{ trans('rbac.role_name') }}</th>
					<td>
						<input type="text" name="name" value="{{ old('name') }}" class="small" pattern="code" />
						<label>*{{ trans('rbac.role_name') }}({{ trans('common.required') }})</label>
					</td>
				</tr>
				<tr>
					<th>{{ trans('rbac.role_display_name') }}</th>
					<td>
						<input type="text" name="display_name" value="{{ old('display_name') }}" pattern="required" class="normal"   />
						<label>*{{ trans('rbac.role_display_name') }}({{ trans('common.required') }})</label>
					</td>
				</tr>
				<tr>
					<th>{{ trans('common.description') }}</th>
					<td>
						<textarea name="description" class="normal">{{ old('description') }}</textarea>
					</td>
				</tr>					
				
			</table>
			<table class="form_table" cellpadding="0" cellspacing="0" id="tab-2">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				@foreach ($permissionRows as $element)
				<tr>
					<th>{{ $element->display_name }}</th>						
					<td>
						@if (isset($element->children) && $element->children)	
						@foreach ($element->children as $el)
							<label class="attr">
								<input type="checkbox" name="permission_id[]" value="{{ $el->id }}">
								{{ $el->display_name }}
							</label>
						@endforeach				
						@endif					
					</td>	
				</tr>							
				@endforeach									
			</table>

			<table class="form_table" cellpadding="0" cellspacing="0" id="tab-3">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				@foreach ($navigationRows as $element)
				<tr>
					<th style="font-size: 14px; text-align: center;">
						<label class="attr">
							<input type="checkbox" name="navigation_id[]" class="jquerycheckbox" data-id="navigationRows_{{ $element->id }}" value="{{ $element->id }}"/>
							{{ $element->name }}
						</label>
					</th>					
					<td>											
					</td>	
				</tr>
				@if(isset($element->children) && $element->children)	
				@foreach ($element->children as $el)
				<tr>
					<th>
						<label class="attr">
							<input type="checkbox" class="jquerycheckbox" name="navigation_id[]" data-pid="navigationRows_{{ $el->pid }}" data-id="navigationRows_{{ $el->id }}" value="{{ $el->id }}"/>
							{{ $el->name }}
						</label>
					</th>						
					<td>	
						@if(isset($el->children) && $el->children)	
						@foreach ($el->children as $vo)
						<label class="attr">
							<input type="checkbox" class="jquerycheckbox" data-pid="navigationRows_{{ $vo->pid }}" name="navigation_id[]" value="{{ $vo->id }}"/>
							{{ $vo->name }}
						</label>
						@endforeach				
						@endif	
					</td>	
				</tr>
				@endforeach				
				@endif						
				@endforeach									
			</table>

			<table class="form_table" cellpadding="0" cellspacing="0">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				<tr>
					<td> <input type="hidden" name="_token"  value="{{ csrf_token() }}"/> </td>
					<td>
						<button class="submit" type="submit"><span>{{ trans('common.submit') }}</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@stop