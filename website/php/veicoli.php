<html>
	<head>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			$("#marca").change(function(){
				$.ajax({
					  url:"modelliVeicoli.php",
					  type: "GET",
					  data: { marca: $("#marca > option:selected").val() },
					  success:function(result){
						$("#modello").html(result + "<option>Altro</option>");
					  },
					  error: function(richiesta,stato,errori){
						$("#modello").html("<strong>Chiamata fallita:</strong>" + stato + " " + errori);
					  }
				});
			});
		});
		</script>
	</head>
	<body>
		<center>
			<form action="aggiungiVeicolo.php" method="POST">
				<fieldset>
					<legend>Aggiungi veicolo</legend>

					<label for="marca">Marca</label><br/>
					<select id="marca" name="marca">
						<option disabled selected value> -- seleziona una marca -- </option>
<?php
	session_start();
	
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$database_name = 'myschoolbus';
	try {
			$connection = new PDO("mysql:host=$hostname;dbname=$database_name", $username, $password);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $ex){ 
		die('Errore connessione: '.$ex->getMessage());
	}

	try{
		$istruzioneSQL = $connection->prepare("SELECT Nome FROM marcheveicoli");
			
		$istruzioneSQL->execute();

	}catch(PDOException $ex){
		die('Query errata: '.$ex->getMessage());
	}

	while ($recordTrovati = $istruzioneSQL->fetch()) {
		echo "<option>".$recordTrovati[0]."</option>";
	}
?>
						<option>Altro</option>
					</select><br/><br/>
					
					<label for="modello">Modello</label><br/>
					<select id="modello" name="modello">
						<option disabled selected value> -- seleziona un modello -- </option>
					</select><br/><br/>
					
					<label for="categoria">Categoria</label><br/>
					<select id="categoria" name="categoria">
						<option disabled selected value> -- seleziona una categoria -- </option>
<?php
	try{
		$istruzioneSQL = $connection->prepare("SELECT Nome FROM categorieveicoli");
			
		$istruzioneSQL->execute();

	}catch(PDOException $ex){
		die('Query errata: '.$ex->getMessage());
	}

	while ($recordTrovati = $istruzioneSQL->fetch()) {
		echo "<option>$recordTrovati[0]</option>";
	}
?>
						<option>Altro</option>
					</select><br/><br/>
					
					<input id="aggiungi" name="Aggiungi" value="Aggiungi" type="submit"><br/>
					<input id="cancella" name="Cancella" value="Cancella" type="reset">
				</fieldset>
			</form>
			
			<table id="veicoliRegistrati" style="border-width: 5px; border-color='black';">
<?php
	echo "CodUte --> " . $_SESSION['CodUtente'];
	try{
		$istruzioneSQL = $connection->prepare("SELECT CodCategoria, CodModello FROM veicoli WHERE CodUtente='".$_SESSION['CodUtente']."'");
			
		$istruzioneSQL->execute();

	}catch(PDOException $ex){
		die('Query errata: '.$ex->getMessage());
	}
	
	$i = 1;
	while ($recordTrovati = $istruzioneSQL->fetch()) {
		echo "<tr><td>Veicolo $i:</td><td>CodCat --> $recordTrovati[0]</td>";
		echo "<td>CodMod --> $recordTrovati[1]</td></tr>";
		$i++;
	}
?>
			</table>
			
		</center>
	</body>
</html>