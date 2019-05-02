<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body {
			margin-left: 10%;
			margin-right: 10%;	
		}

		.background {
			position: absolute;
			z-index: -1;  
			width: 40%;
			height: 65%;
			background-image: url({{ asset('/storage/app/public/AsureTotslogo.png') }});
			background-size: cover;
			background-position: center;
			opacity: 0.1;
			top: 15% ;
			left: 30% ;
		}
		h3 {
			text-align: center;
			color: #56D171;  
		}
		a {
			color: #FE8A25;
		}
		.applinks {
			margin-left: 35%;
		}
			
	</style>
</head>
<body>
	<img src="{{ asset('/storage/app/public/AsureTots.png') }}">
	<div class="background"></div>
	<h3>ASURE TOTS SECURITY ALERT</h3>
	<p>Hi <strong>{{$parentName}}</strong>!</p>
	<br>
	<p>You have successfully scanned the QR code of <strong>{{$studentName}}</strong> at {{$schoolName}}.</p>
	<p><strong>Date:</strong> {{$scanDate}}</p>
	<p><strong>Time:</strong> {{$scanTime}}</p>
	<p>Security and  the best child care is the top priority at Asure Tots.Stay Happy &#128522;</p>
	<br>
	<p>Thank You,</p>
	<p>Asure Tots</p>	
	<br><br>
	<div class="applinks">
		<a href="#"><img src="{{ asset('/storage/app/public/google_play_.png') }}"></a>
		<a href="#"><img src="{{ asset('/storage/app/public/apple_store_.png') }}"></a>
	</div>

</body>
</html>