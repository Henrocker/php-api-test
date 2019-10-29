<!DOCTYPE HTML>
<?php
$request_method = $_SERVER['REQUEST_METHOD'];
switch($request_method)
	{
		case 'GET':
			$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//			echo $actual_link;
			$query_str = parse_url($actual_link, PHP_URL_QUERY);
			parse_str($query_str, $query_params);
			if(isset($query_params['image']) && is_numeric($query_params['image'])) {
//				echo "Url beinhaltet Parameter \"image\". Nice!<br>";
//				echo json_encode($query_params);
//				echo "<br>";
				$i = $query_params['image'];
				if($i > 3 || $i <= 0) {
					echo 'Nope! Bild No. '.$i.' existiert nicht!<br>';
					break;
				}

				echo '<img src="images/'.$i.'.jpg">';
				break;
			}
			echo 'Nope! Keine Bildnummer angegeben!<br>';
			break;

		default:
			// Nur GET erlaubt!
			echo "Nope! Try \"GET\" instead.";
			break;
	}
//	echo "<p>Ende!</p>";
?>
