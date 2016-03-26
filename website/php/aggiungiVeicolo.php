<?php
	session_start();
	
	if (isset($_POST['marca']) &&
		isset($_POST['modello']) &&
		isset($_POST['categoria']) ) {
		
		$datiDaCaricare = array(
			$_POST['categoria'],
			$_POST['modello'],
			$_SESSION['CodUtente']
		);
		$marca = $_POST['marca'];

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
			$istruzioneSQL = $connection->prepare("SELECT CodModello FROM modelliveicoli
												WHERE Nome='" . $datiDaCaricare[1] . "'" . 
												" AND CodMarca=(SELECT CodMarca FROM marcheveicoli WHERE Nome='".$marca."')");
			
			$istruzioneSQL->execute();
			$recordTrovato = $istruzioneSQL->fetch();
		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}
		$datiDaCaricare[1] = $recordTrovato[0];
		
		try{
			$istruzioneSQL = $connection->prepare("SELECT CodCategoria FROM categorieveicoli
												WHERE Nome='" . $datiDaCaricare[0] . "'");
			$istruzioneSQL->execute();
			$recordTrovato = $istruzioneSQL->fetch();
		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}
		$datiDaCaricare[0] = $recordTrovato[0];
		
		try{
			$istruzioneSQL = $connection->prepare("INSERT INTO veicoli
												(CodCategoria, CodModello, CodUtente)
												VALUES (?,?,?)");								
			for($i = 0; $i <= 2; $i++){
				$istruzioneSQL->bindParam($i+1, $datiDaCaricare[$i]);
			}		
			$istruzioneSQL->execute();
		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}
		
		unset($datiDaCaricare);
		$connection = null;
		
	} else {
		echo 'ACCESSO NON AUTORIZZATO';
	}
?>