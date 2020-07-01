<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../support/css/style.css">
	<link rel="stylesheet" type="text/css" href="../support/css/main.css">
	<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
	<title>Главная</title>
</head>
<body>
	<div class="container">
		<div class="left">
			<ui>
				<li class="menu">Menu</li>
				<li<? if ($checkURL == "main") echo ' class="activ"'; ?>><a href="/main">Main page</a></li>
                <li<? if ($checkURL == "send") echo ' class="activ"'; ?>><a href="/send">Send file</a></li>
                <li<? if ($checkURL == "my") echo ' class="activ"'; ?>><a href="/my">My files</a></li>
                <li<? if ($checkURL == "received") echo ' class="activ"'; ?>><a href="/received">Received file</a></li>
				<li class="end"><a href="/logout">Log out</a></li>
			</ui>
		</div>
		<div class="right">
            <?php echo $viewTable; ?>
		</div>
	</div>
</body>
</html>
