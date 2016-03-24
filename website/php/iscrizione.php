<?php
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
		
		unset($datiDaCaricare);
		$connection = null;
		
		echo 'DATI CARICATI NEL DB!!!';
	
	} else {
		echo 'ACCESSO NON AUTORIZZATO';
	}
?>