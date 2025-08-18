<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Erreur 404</title>
	<style>
		body { font-family: Arial, sans-serif; background: #ad0816; margin: 0; padding: 0; }
		.container { max-width: 500px; margin: 100px auto; background: #d4d4e4; padding: 32px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center; }
		h1 { color: #721c24; }
		p { color: #721c24; }
		.btn {
			display: inline-block;
			margin-top: 24px;
			padding: 12px 28px;
			background: #721c24;
			color: #fff;
			border: none;
			border-radius: 4px;
			text-decoration: none;
			font-size: 16px;
			cursor: pointer;
			transition: background 0.2s;
		}
		.btn:hover { background: #a94442; }
	</style>
</head>
<body>
	<div class="container">
		<h1>Erreur 404</h1>
		<p>La page que vous recherchez n'existe pas.</p>
		<a href="{{route('index')}}" class="btn">Retour à l'accueil</a>
	</div>
</body>
</html>
