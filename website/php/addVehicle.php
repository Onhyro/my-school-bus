<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"/>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<style type="text/css">
		   form {
				width: 200px;
			}
		</style>
		<script>
			$(document).ready(function(){

				$("#vehicleBrand").change(function(){

					$.ajax({
						  url:"extractModel.php",
						  type: "GET",
						  data: { marcaVeicolo: $("#vehicleBrand > option:selected").val()},
						  success:function(result){
							$("#vehicleBrand").html(result);
						  },
						  error: function(richiesta,stato,errori){
							$("#vehicleBrand").html("<strong>Chiamata fallita:</strong>" + stato + " " + errori);
						  }
					});

				});

			});
		</script>
	</head>
	<body>
		<form role="form" width="100px">
			<div class="form-group">
				<label for="vehicleBrand">Marca:</label>
				<select id="vehicleBrand" class="form-control">
					<?php
						/*script PHP che carica la combobox delle marche dei veicoli con
						le marche memorizzate all'interno del database del progetto*/

						/*TO DO: definire il nome del database*/
						$usr="root";$pwd="";
						try{
							$conn = new PDO("mysql:host=localhost;dbname=comuni", $usr, $pwd);
							$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						}catch(PDOException $ex){
							die("Errore connessione: ".$ex->getMessage());
						}

						/*TO DO: definire i campi corretti del database del progetto per estrarre i dati necessari*/
						try{
							$stmSql = $conn->prepare("SELECT regione FROM regioni");
							$result = $stmSql->execute();
						}catch(PDOException $ex){
							die("Query errata: ".$ex->getMessage());
						}

						/*istruzioni per visualizzare i dati ricavati dalla query all'interno di tag preimpostati*/
						while($row = $stmSql->fetch()){
							echo "<option>".$row[0]."</option>";
						}

						/*chiusura della connessione*/
						$conn = null;
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="vehicleModel">Modello:</label>
				<select id="vehicleModel" class="form-control"></select>
			</div>
			<div class="form-group">
				<label for="vehicleCategory">Categoria:</label>
				<select id="vehicleCategory" class="form-control">
					<?php
						/*script PHP che carica la combobox delle categorie dei veicoli con
						le marche memorizzate all'interno del database del progetto*/

						/*TO DO: definire il nome del database*/
						$usr="root";$pwd="";
						try{
							$conn = new PDO("mysql:host=localhost;dbname=comuni", $usr, $pwd);
							$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						}catch(PDOException $ex){
							die("Errore connessione: ".$ex->getMessage());
						}

						/*TO DO: definire i campi corretti del database del progetto per estrarre i dati necessari*/
						try{
							$stmSql = $conn->prepare("SELECT regione FROM regioni");
							$result = $stmSql->execute();
						}catch(PDOException $ex){
							die("Query errata: ".$ex->getMessage());
						}

						/*istruzioni per visualizzare i dati ricavati dalla query all'interno di tag preimpostati*/
						while($row = $stmSql->fetch()){
							echo "<option>".$row[0]."</option>";
						}

						/*chiusura della connessione*/
						$conn = null;
					?>
				</select>
			</div>
		</form>
	</body>
</html>
