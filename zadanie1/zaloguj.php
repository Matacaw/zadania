<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = $polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE email='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if ($haslo==$wiersz['password'])
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['user_id'] = $wiersz['user_id'];
					$_SESSION['first_name'] = $wiersz['first_name'];
					$_SESSION['last_name'] = $wiersz['last_name'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['gender'] = $wiersz['gender'];
					$_SESSION['is_active'] = $wiersz['is_active'];
					$_SESSION['created_at'] = $wiersz['created_at'];
					$_SESSION['updated_at'] = $wiersz['updated_at'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: salon.php');
				}
				else 
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>