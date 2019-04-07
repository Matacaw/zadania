<?php

$polaczenie = mysqli_connect("localhost", "root", "", "baza_zadanie2");

if(!$polaczenie){
  die("Connection failed: " . $polaczenie->error);
}


$result = $polaczenie->query("SELECT country_name FROM kraje");
$result2 = $polaczenie->query("SELECT country_pop FROM kraje");
$string = "";
$string2 = "";
	while ($p = mysqli_fetch_array($result)) 
		{ 

			
			$string .='"' . $p['country_name'] . '",';
		}

	  while ($p = mysqli_fetch_array($result2)) 
		{ 

			$string2 .= '"' . $p['country_pop'] . '",';
			
		}


	
?>
<html>
<head><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script></head>

<body>
<div class="container">
 
  <div>
    <canvas id="myChart"></canvas>
  </div>
</div>

</body>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [<?php echo $string ?>],
    datasets: [{
      label: 'apples',
      data: [<?php echo $string2 ?>],
      backgroundColor: "rgba(153,255,51,0.6)"
    }]
	
  }
  
});

  </script>
</html>
