<?php
	$marca = $_GET['marca'];		
	
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
		$stmSql = $connection->prepare("SELECT CodMarca FROM marcheveicoli WHERE Nome = '".$marca."'");
		$result = $stmSql->execute();
	}catch(PDOException $ex){
		die("Query errata: ".$ex->getMessage());
	}
	
	while($row = $stmSql->fetch()){
		$codMarca = $row[0];
	}
	
	try{
		$stmSql = $connection->prepare("SELECT Nome FROM modelliveicoli WHERE CodMarca = '$codMarca'");
		$result = $stmSql->execute();
	}catch(PDOException $ex){
		die("Query errata: ".$ex->getMessage());
	}
	
	$risposta .= "<option disabled selected value> -- seleziona un modello -- </option>";
	
	while($row = $stmSql->fetch()){
		/*$provincia = $row[0];
		$provincia = str_replace("'", "&#39;", $provincia);*/
		$risposta.="<option>".$row[0]."</option>";
	}
	
	$connection = null;
	
	echo $risposta;
?>