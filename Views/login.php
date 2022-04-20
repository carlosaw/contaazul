<htmL>
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link href="<?php echo BASE_URL; ?>assets/css/login.css" rel="stylesheet" />
		<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
	</head>
	<body>
	
		<div class="loginarea">		
			<form method="POST">
				<h4 class="login">Login</h4>
				<input type="email" name="email" placeholder="Digite seu e-mail" autofocus />

				<input type="password" name="password" placeholder="Digite sua senha" />

				<input type="submit" value="Entrar" /><br/>
				
				<!--Se erro existir e tiver preenchido-->
				<?php if(isset($error) && !empty($error)): ?>
				<div class="warning"><?php echo $error; ?></div>
				<?php endif; ?>				
			</form>
		</div>

	</body>

</htmL>