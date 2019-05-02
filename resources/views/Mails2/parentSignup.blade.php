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
	<h3>WELCOME TO ASURE TOTS</h3>
	<p>Hi <strong></strong>!</p>
	<br>
	<p>You have been added as Parent member of {{$schoolName}} by Admin. <a href="http://www.asuretots.com">Asure Tots</a>  is happy to have you on on board and as we are one of the best child care app service aiming to provide security and satisfaction to the users.</p>
	<p>Our team is also looking forward to providing you the best services and as our valuable user,we are pleased to welome you on board.</p>
	<p>You've been given access to {{$schoolName}} parent member account on Asure Tots.</p>
	<p>To access your account,please visit our website and log in to your account using the following credentials:</p>
	<br>
	<p><strong>Username:</strong> {{$email}}</p>
	<p><strong>Password:</strong> {{$password}}</p>
	<br>
	<p>We hope you get the best from us.Stay Happy &#128522;</p>
	<br>
	<p>Thank You,</p>
	<p>Asure Tots</p>	
	<br>
	<div class="applinks">
		<a href="#"><img src="{{ asset('/storage/app/public/google_play_.png') }}"></a>
		<a href="#"><img src="{{ asset('/storage/app/public/apple_store_.png') }}"></a>
	</div>

</body>
</html>