<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{ trans('common.common_title') }}</title>
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_style.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/css/admin_right.css" />
	<script src="/static/admin/js/jquery-1.4.4.min.js"></script>
	<script src="/static/admin/js/artTemplate/artTemplate.js" type="text/javascript"></script>
	<script src="/static/admin/js/artTemplate/artTemplate-plugin.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/static/admin/js/artdialog/skins/idialog.css" type="text/css" />
	<script src="/static/admin/js/jquery.idTabs.min.js" type="text/javascript"></script>	
	<script src="/static/admin/js/artdialog/artDialog.js?skin=idialog" type="text/javascript"></script>

	<script src="/static/admin/js/artdialog/plugins/iframeTools.js" type="text/javascript"></script>
	<script src="/static/admin/js/validate.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/static/admin/js/validate/style.css">	
	<script src="/static/admin/js/jquery.stonecms.js" type="text/javascript"></script>
	<script src="/static/admin/js/main.js"></script>
</head>
<body>
	<div class="right_body">
		<div class="top_subnav">{{ trans('common.common_title') }} ＞ {{ $userIndex }}</div>

		@yield('content')
	</div>
</body>
</html>