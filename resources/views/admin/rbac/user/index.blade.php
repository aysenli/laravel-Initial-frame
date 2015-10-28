@extends('admin.main')


@section('content')
<div class="operating">
  <div class="search f_r">
    <form method="get" name="searchModForm">      
      <input type="text" value="" name="user_name" placeholder="{{ trans('rbac.user_name') }}" class="small">
      <button type="submit" class="btn"><span class="sch">{{ trans('common.search') }}</span></button>
    </form>
  </div>

  <a href="{{route('admin.rbac.roles.create')}}">
    <button type="button" class="operating_btn">
      <span class="addition">{{ trans('rbac.add_roles') }}</span>
    </button>
  </a>
  <a class="all_checkbox" href="javascript:void(0);">
    <button class="operating_btn">
      <span class="sel_all">{{ trans('common.sel_all') }}</span>
    </button>
  </a>
  <a href="javascript:void(0);">
    <button class="operating_btn">
      <span class="delete">{{ trans('common.sel_delete') }}</span>
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
        <th>{{ trans('rbac.user_name') }}</th>
        <th>{{ trans('common.email') }}</th>
        <th>{{ trans('common.belong_to') }}{{ trans('rbac.role') }}</th>
        <th>{{ trans('common.created_at') }}</th>
        <th>{{ trans('common.updated_at') }}</th>       
        <th>{{ trans('common.operate') }}</th>
      </tr>
    </thead>
  </table>
</div>

<div class="content" style="height: 326px;">    
  <form name="groupFrom" method="post" action="{{ route('admin.rbac.user.destroy') }}">
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
        @foreach ($pages as $page)
        <tr class="">
          <td><input type="checkbox" value="{{ $page->id }}" class="item_checkbox" name="id[]"></td>
          <td>{{ $page->name }}</td>
          <td>{{ $page->email }}</td>
          <td></td>
          <td>{{ $page->created_at }}</td>
          <td>{{ $page->updated_at }}</td>
          <td>              
            <a title="{{ trans('common.delete') }}{{ trans('rbac.user') }}" href="javascript:void(0);" data-msg="{{ trans('common.confirm_delete',['name'=>trans('rbac.user')]) }}" data-href="{{ route('admin.rbac.user.destroy' , ['id'=>$page->id]) }}">
              <img alt="{{ trans('common.delete') }}" src="/static/admin/images/icon_del.gif" class="operator">
            </a>    
            <a title="{{ trans('common.edit') }}{{ trans('rbas.user') }}" href="{{ route('admin.rbac.user.edit' , ['id'=>$page->id]) }}">
              <img alt="{{ trans('common.edit') }}" src="/static/admin/images/icon_edit.gif" class="operator">
            </a>      
          </td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </form>
</div>
@include('admin.common.pages')
@endsection