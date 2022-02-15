<?php
class Tranche{
	public $min;
	public $max;
	public $price;

	public function __construct($min,$max,$price){
		$this->min 	  	= $min;
		$this->max 		= $max;
		$this->price 	= $price;
	}
};
$consom = [
	"small" => 22.65,
	"medium" => 37.05,
	"large" => 46.20
];
$timbre = 0.45;

$tranche = [
	new Tranche (0,100,0.794),
	new Tranche (101,150,0.883),
	new Tranche (151,210,0.9451),
	new Tranche (211,310,1.0489),
	new Tranche (311,510,1.2915),
	new Tranche (510,INF,1.4975)
];
if(isset($_POST['send'])){
	$calibre = $_POST["calibre"];
	$firstI = $_POST['firstI'];
	$secondI = $_POST['secondI'];
	$sum = $firstI - $secondI;
	$tva = 14;
	$montantHT = [];
	$montant = [];

	if($sum <= 150){
		if($sum <= $tranche[0]->max){
			$montant[0] = $sum;
			$montantHT[0] = $montant[0] * $tranche[0]->price;
		} else {
			$montant[0] = 100;
			$montant[1] = $sum - $montant[0];
			$montantHT[0] = $montant[0] * $tranche[0]->price;
			$montantHT[1] = $montant[1] * $tranche[1]->price;
		}
	}
	else {
		if($sum <= $tranche[2]->max){
			$montant[2] = $sum;
			$montantHT[2] = $montant[2] * $tranche[2]->price;
		}
		else if($sum <= $tranche[3]->max){
			$montant[3] = $sum;
			$montantHT[3] = $montant[3] * $tranche[3]->price;
		}
		else if($sum <= $tranche[4]->max){
			$montant[4] = $sum;
			$montantHT[4] = $montant[4] * $tranche[4]->price;
		}
		else if($sum <= $tranche[5]->max){
			$montant[5] = $sum;
			$montantHT[5] = $montant[5] * $tranche[5]->price;
		}
	}
};
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>facture</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h3 class="display-4">Facture d'électricité simulée	</h3>
	<table class="table table-striped mt-5">
		  <thead class="thead-dark">
		    <tr>
		      <th scope="col">Montant</th>
		      <th scope="col">Prix unitaire</th>
		      <th scope="col">Montant HT</th>
		      <th scope="col">TVA</th>
		      <th scope="col">Prix Tva</th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php 
		    	if(isset($_POST['send'])){
		    	foreach($montant as $index => $value){
		    		$montantTva = (($montantHT[$index] * $tva) / 100);
		    		$calibreTva = ($consom[$calibre] * $tva) / 100;
		    		$montantTTC = $montantHT[$index] + $montantTva + $consom[$calibre] + $timbre;
			?>
			<tr>
				<td><?php echo $value; ?></td>
				<td><?php echo $tranche[$index]->price ?></td>
				<td><?php echo $montantHT[$index]?>
				<td><?php echo $tva . "%"?>
				<td><?php echo $montantTva; ?>
			</tr>
			<?php
				}
			};
			?>
			<tr>
				<td>Calibre</td>
				<td><?php echo $consom[$calibre] ?></td>
				<td></td>
				<td><?php echo $tva . "%"?></td>
				<td><?php echo $calibreTva?></td>
			</tr>
			<tr>
				<td>Timbre</td>
				<td><?php echo $timbre ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		  </tbody>
	</table>
<div class="containerr">
	<div id="form" class="card border-light mb-3">
	<form method="POST" action="index.php">
		<input type="text" class="box" name="firstI"><br>
		<input type="text" class="box" name="secondI"><br>
		<input type="radio" name="calibre" value="small">5-10
		<input type="radio" name="calibre" value="medium">15-20
		<input type="radio" name="calibre" value="large">30+<br>
		<input class="btn btn-dark" type="submit" name="send" value="send">
	</form>
	</div>

	<div id="card" class="card border-light mb-3">
		  <div class="card-header">
		    Votre total est de : 
		  </div>
		  <div class="card-body">
		   <h5 class="card-title"> <?php echo $montantTTC?></h5>
 	</div>
</div>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

