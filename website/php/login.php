<?php
	if (isset($_POST['email']) &&
		isset($_POST['password']) ) {
		
		$datiDaConfrontare = array(
			$_POST['email'],
			$_POST['password'],
		);

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
			$istruzioneSQL = $connection->prepare("SELECT Nome, Cognome FROM utenti
												WHERE Email='" . $datiDaConfrontare[0] . "'" . 
												"AND Password='" . $datiDaConfrontare[1] . "'");
			
			$istruzioneSQL->execute();
			
			$recordTrovato = $istruzioneSQL->fetch();

		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}	
		
		unset($datiDaConfrontare);
		$connection = null;
		
		if ($recordTrovato) {
			echo "BENTORNATO ".$recordTrovato[0] . " " . $recordTrovato[1] . "!";
		} else {
			echo "NESSUN UTENTE REGISTRATO TROVATO!";
		}
	
	} else {
		echo 'ACCESSO NON AUTORIZZATO';
	}
?>