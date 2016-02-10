<?php
	
	/*
	script php che permette di inserire i valori inseriti
	dalla pagina web dall'utente nel database, dopo aver
	effettuato gli opportuni controlli.
	*/

	/*salvataggio, in opportune variabili, dei dati ricevuti
	e inseriti dall'utente nella pagina principale*/
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	$nickname = $_POST['nickname'];
	$email = $_POST['email'];
	$telefono = $_POST['telefono'];
	$password = $_POST['password'];
	
	/*apertura della connessione con il database*/
	$user = 'root';
	$password = '';
	try{
		$connessione = new PDO('mysql:host=localhost;dbname=db', $user, $password);
	} catch (PDOException $exception) {
		die("Errore durante la connessione al database: ".$exception->getMessage());
	}
	
	/*preparazione ed esecuzione del comando di caricamento dei dati inseriti nel database
	TO DO: controllare i campi necessari affinchè non vi siano dati duplicati nel database*/
	try{
		$istruzione = $connessione->prepare("INSERT INTO Utenti (Nome, Cognome, Nickname, Email, Telefono, Password) VALUES (?,?,?,?,?,?)");
		$istruzione->bindParam(1, $nome);
		$istruzione->bindParam(2, $cognome);
		$istruzione->bindParam(3, $nickname);
		$istruzione->bindParam(4, $email);
		$istruzione->bindParam(5, $telefono);
		$istruzione->bindParam(6, $password);
		/*TO DO: da verificare l'effettiva importanza della variabile $risultato*/
		$risultato = $istruzione->execute();
	} catch (PDOException $exception) {
		die("Errore durante l'inserimento di dati nel database: ".$exception->getMessage());
	}
	
	/*chiusura della connessione con il database*/
	$connection = null;

?>