<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>跳转</title>
</head>
<style type="text/css">
	*{margin: 0;padding: 0;}
	body{font-size: 12px;}
	div{margin-top: 200px; text-align: center;}
	p{color: #666;padding:5px 0;}
	h1{padding: 10px 0;}
</style>
<body>
	<div>
		@if(isset($type) && $type == 'warning')
		<h1>:-(</h1>
		@else
		<h1>:-)</h1>
		@endif
		@if (!empty($data))
		@foreach ($data as $element)
			<p>{{$element}}</p>
		@endforeach
		@endif
		@if (isset($location))		
		<p>
			@foreach ($location as $element)
			[<a href="{{$element['url']}}">{{$element['name']}}</a>]&nbsp;&nbsp;
			@endforeach
		@endif
		<p>
			<strong id="time">5</strong>
			秒后自动跳转到
			[<a href="javascript:history.back();">上一页</a>]
		</p>
	</div>
</body>
<script type="text/javascript">
	var interval = false;
	interval = setInterval(function(){
		// document.getElementById()
		var time = parseInt(document.getElementById('time').innerHTML);
		time = time - 1;		
		if(time == 0){
			setTimeout(interval);
			history.back();
		}
		document.getElementById('time').innerHTML = time;
	},1000);
	// setInterval()
</script>
</html>