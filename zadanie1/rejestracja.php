<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		$OK=true;
		
		$first_name = $_POST['first_name'];
		
		if ((strlen($first_name)<3) || (strlen($first_name)>30))
		{
			$OK=false;
			$_SESSION['e_first_name']="Imie od 3 do 30 znaków!";
		}
		
		if (ctype_alnum($first_name)==false)
		{
			$OK=false;
			$_SESSION['e_first_name']="Imie może składać się tylko z liter";
		}
		
		$last_name = $_POST['last_name'];
		if ((strlen($last_name)<3) || (strlen($last_name)>30))
		{
			$OK=false;
			$_SESSION['e_last_name']="Nazwisko od 3 do 30 znaków!";
		}
		
		if (ctype_alnum($last_name)==false)
		{
			$OK=false;
			$_SESSION['e_last_name']="Nazwisko może składać się tylko z liter";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
	
		$password = $_POST['password'];
		
		if ((strlen($password)<8) || (strlen($password)>20))
		{
			$OK=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		$gender = $_POST['gender'];
			if (!isset($_POST['gender']))
		{
			$wszystko_OK=false;
			$_SESSION['e_gender']="Potwierdź płeć";
		}


		$_SESSION['fr_first_name'] = $first_name;
		$_SESSION['fr_last_name'] = $last_name;
		$_SESSION['fr_email'] = $email;
		$_SESSION['gender'] = $gender;
		$_SESSION['fr_password'] = $password;
		
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT user_id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		


				
				if ($OK==true)
				{
					$dataczas = new DateTime('');
					$created_at = $dataczas->format('Y-m-d H:i:s');
					$updated_at = $dataczas->format('Y-m-d H:i:s');
					
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$first_name', '$last_name', '$email', '$gender', true, '$password', '$created_at', '$updated_at')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Nastąpił Błąd</span>';
			echo $e;
		}
		
	}	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Rejestracja</title>	
	<style>
		.error
		{
			color:red;
			margin-top: 20px;
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	
	<form method="post">
	
		first_name: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_first_name']))
			{
				echo $_SESSION['fr_first_name'];
				unset($_SESSION['fr_first_name']);
			}
		?>" name="first_name" /><br />
		
		<?php
			if (isset($_SESSION['e_first_name']))
			{
				echo '<div class="error">'.$_SESSION['e_first_name'].'</div>';
				unset($_SESSION['e_first_name']);
			}
		?>
			
		last_name: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_last_name']))
			{
				echo $_SESSION['fr_last_name'];
				unset($_SESSION['fr_last_name']);
			}
		?>" name="last_name" /><br />
		
		<?php
			if (isset($_SESSION['e_last_name']))
			{
				echo '<div class="error">'.$_SESSION['e_last_name'].'</div>';
				unset($_SESSION['e_last_name']);
			}
		?>
		
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		Hasło: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['fr_password']))
			{
				echo $_SESSION['fr_password'];
				unset($_SESSION['fr_password']);
			}
		?>" name="password" /><br />
		
		<?php
			if (isset($_SESSION['e_password']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>
		<input type="radio" name="gender" value="male">Mężczyzna
		<input type="radio" name="gender" value="female">Kobieta
		

		
		<?php
			if (isset($_SESSION['e_gender']))
			{
				echo '<div class="error">'.$_SESSION['e_gender'].'</div>';
				unset($_SESSION['e_gender']);
			}
		?>	
		<br />
		
		<input type="submit" value="Zarejestruj się" />
		
	</form>

</body>
</html>