<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Zadanie1</title>
</head>

<body>
	
<?php

	echo '<p>[ <a href="logout.php">Wyloguj się</a> ]</p>';
	echo "<p><b>Imie</b> ".$_SESSION['first_name'].' | <b>nazwisko</b>: '.$_SESSION['last_name'];
	echo " | <b>email</b>: ".$_SESSION['email'];
	echo " | <b>gender</b>: ".$_SESSION['gender'];
	echo " | <b>isactive</b>: ".$_SESSION['is_active'];
	echo " | <b>created</b>: ".$_SESSION['created_at']."</p>";
	
	$dataczas = new DateTime('');
	echo '<a href="post.php">Nowy News</a><br>';
	
	echo "Data i czas serwera: ".$dataczas->format('Y-m-d H:i:s')."<br><br>";
	
	require "connect.php";

	$polaczenie2 = new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie2->connect_errno!=0)
	{
		echo "Error: ".$polaczenie2->connect_errno;
	}
	else
	{
		if ($rezultat2 = $polaczenie2->query("SELECT * FROM news"))
		{
			$ile_news = $rezultat2->num_rows;
			if($ile_news>0)
			{

				echo "<br>";
					echo "<br>";
				while($i = mysqli_fetch_array($rezultat2))
				{

				
	
					echo "<br>";

					echo "<br>";
					echo "<br>tytuł:".$i['name']."<br>";
					echo "<br>".$i['description']."<br>";
					echo '<a href=edit.php?link=' . $i['news_id'] . '>edytuj</a>';
					echo "<br>";
					
	
				}
				
			}
			else
			{
				echo 'no news';
				$polaczenie2->close();
			}
		}
		else
		{
			echo'bład newsów';
			$polaczenie2->close();
		}
	}
	

?>

</body>
</html>