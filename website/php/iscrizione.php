<?php
	session_start();
	
	if (isset($_POST['nome']) &&
		isset($_POST['cognome']) &&
		isset($_POST['email']) &&
		isset($_POST['password']) &&
		isset($_POST['telefono']) &&
		isset($_POST['annoNascita']) &&
		isset($_POST['sesso']) ) {
		
		$datiDaCaricare = array(
			$_POST['nome'],
			$_POST['cognome'],
			$_POST['email'],
			$_POST['password'],
			$_POST['telefono'],
			$_POST['annoNascita'],
		);

		switch ($_POST['sesso']) {
			case 'maschio':
				$datiDaCaricare[6] = 0;
				break;
			case 'femmina':
				$datiDaCaricare[6] = 1;
				break;
			default:
				$datiDaCaricare[6] = NULL;
		}

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
			$istruzioneSQL = $connection->prepare("INSERT INTO utenti
												(Nome, Cognome, Email, Password, Telefono, AnnoNascita, Sesso)
												VALUES (?,?,?,?,?,?,?)");
												
			for($i = 0; $i <= 6; $i++){
				$istruzioneSQL->bindParam($i+1, $datiDaCaricare[$i]);
			}		
			
			$istruzioneSQL->execute();
		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}
		
		try{
			$istruzioneSQL = $connection->prepare("SELECT CodUtente FROM utenti
												WHERE Email='" . $datiDaCaricare[2] . "'" . 
												"AND Password='" . $datiDaCaricare[3] . "'");
			
			$istruzioneSQL->execute();
			
			$recordTrovato = $istruzioneSQL->fetch();

		}catch(PDOException $ex){
			die('Query errata: '.$ex->getMessage());
		}
		
		unset($datiDaCaricare);
		$connection = null;
		
		$_SESSION['CodUtente'] = $recordTrovato[0];
		echo "<center>";
		echo "REGISTRAZIONE EFFETTUATA! Utente numero: " . $_SESSION['CodUtente'] . "<br>";
		echo '<a href="veicoli.php">Gestisci veicoli</a><br/>';
		echo '<a href="abitazioni.php">Gestisci abitazioni</a><br/>';
		echo '<a href="scuole.php">Gestisci scuole</a><br/>';
		echo "</center>";
	
	} else {
		echo 'ACCESSO NON AUTORIZZATO';
	}
?>