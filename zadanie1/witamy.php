<?php

	session_start();
	
	if (!isset($_SESSION['udanarejestracja']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanarejestracja']);
	}
	
	if (isset($_SESSION['fr_first_name'])) unset($_SESSION['fr_first_name']);
	if (isset($_SESSION['fr_last_name'])) unset($_SESSION['fr_last_name']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['radio'])) unset($_SESSION['radio']);
	if (isset($_SESSION['fr_password'])) unset($_SESSION['fr_password']);
	
	if (isset($_SESSION['e_first_name'])) unset($_SESSION['e_first_name']);
	if (isset($_SESSION['e_last_name'])) unset($_SESSION['e_last_name']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Zadanie1</title>
</head>

<body>
	
	Rejestracja udana!<br /><br />
	
	<a href="index.php">Zaloguj się na swoje konto!</a>
	<br /><br />

</body>
</html>