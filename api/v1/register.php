<?php
	include("../connectiondb.php");
	$db = new dbObj();
	$connection =  $db->getConnstring();

	$data = json_decode(file_get_contents('php://input'), true);

	$user = $data["user"];
	$passwort = $data["password"];
	$passwortrepeat = $data["passwordrepeat"];

	if(strlen($user) == 0 || strlen($passwort) == 0 || strlen($passwortrepeat) == 0) {
		die("Eines der Felder wurde nicht ausgefüllt.<br><a href=\"index.html\">Zurück</a>");
	}elseif(strlen($user) < 4) {
		die("User muss mind. 4 Zeichen groß sein und darf nur normale Buchstaben und Zahlen beinhalten.<br><a href=\"index.html\">Zurück</a>");
	}elseif(strlen($passwort) < 8) {
		die("Passwort muss mind. 8 Zeichen groß sein.<br><a href=\"index.html\">Zurück</a>");
	}elseif($passwortrepeat != $passwort) {
		die("Passwortwiederholung muss identisch zum Passwort sein.<br><a href=\"index.html\">Zurück</a>");
	}

	insert_data();

	function insert_data()
	{
		global $connection;
		global $user;
		global $passwort;

		$tokenLength = 25;
		$token = bin2hex(random_bytes($tokenLength));
		if (TRUE == $connection->query("INSERT INTO `api-test` (user, password, token) VALUES ('$user','$passwort','$token')"))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Employee Added Successfully.'
			);
			header('Content-Type: application/json');
			echo json_encode($response);
			sleep(10);
			echo "Erfolg! :-)";
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Employee Addition Failed.'
			);
			header('Content-Type: application/json');
			echo json_encode($response);
			sleep(10);
			echo "Nope.. :-(";
		}
	}
?>
