<?php
	session_start();
	
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
			$istruzioneSQL = $connection->prepare("SELECT CodUtente, Nome, Cognome FROM utenti
												WHERE Email='" . $datiDaConfrontare[0] . "'" . 
												"AND Password='" . $datiDaConfrontare[1] . "'");
			
			$istruzioneSQL->execute();
			$recordTrovato = $istruzioneSQL->fetch();
			
		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}
		
		unset($datiDaConfrontare);
		$connection = null;
		
		echo "<center>";
		if ($recordTrovato) {
			$_SESSION['CodUtente'] = $recordTrovato[0];
			echo "LOGIN EFFETTUATO! Utente numero: " . $_SESSION['CodUtente'] . "<br>";
			echo "BENTORNATO ".$recordTrovato[1] . " " . $recordTrovato[2] . "!<br/>";
			echo '<a href="veicoli.php">Gestisci veicoli</a><br/>';
			echo '<a href="abitazioni.php">Gestisci abitazioni</a><br/>';
			echo '<a href="scuole.php">Gestisci scuole</a><br/>';
		} else {
			echo "NESSUN UTENTE REGISTRATO TROVATO!";
		}
		echo "</center>";
	
	} else {
		echo '<center>ACCESSO NON AUTORIZZATO</center>';
	}
?>