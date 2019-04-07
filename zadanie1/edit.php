

<?php
session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	if (isset($_POST["name"])&&isset($_POST["description"]))
{
	$idq = $_GET['link'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	if (ctype_alnum($name)==false)
	{
		echo "Nazwa może składać się tylko z liter";
	}
	else
	{
		$OK=true;
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
				$rezultat = $polaczenie->query("SELECT name FROM news WHERE name='$name'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nazw = $rezultat->num_rows;
				if($ile_takich_nazw>0)
				{
					$OK=false;
					echo "Istnieje już taki news!";
				}		


				
				if ($OK==true)
				{
					$dataczas = new DateTime('');
					
					$updated_at = $dataczas->format('Y-m-d H:i:s');
					$id=$_SESSION['user_id'];
					echo $name,$description,$idq;
					
					if ($polaczenie->query("UPDATE news SET name = '$name', description = '$description', updated_at = 'updated_at' WHERE news_id = '$idq';"))
					{
						header('Location: salon.php');
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
}
else
{
	echo "Wpisz tytuł i newsa";
}
	
		

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Zadanie1</title>
</head>

<body>
	<form method="post">
	
		name: <br /> <input type="text" value="" name="name" /><br />

		description: <br /> <textarea  name="description" cols="40" rows="4"></textarea> /><br />
		<input type="submit" value="Postuj" />
		
	</form>

</body>
</html>
