<?php
    
    require("../includes/config.php");
    
    if (empty($_POST["city"]))
    {
        http_response_code(400);
        exit(1);
    }
    
    $url = $_POST['city'];
    
    $conn =dbconnect();
	if($conn->connect_error){
			die("Connection Failed".$conn->conncet_error);
	}
	else{
	        $_POST["city"]=mysqli_real_escape_string($conn,$_POST["city"]);
			$query = "SELECT * FROM cities WHERE city='".$_POST["city"]."'";
			$result = $conn->query($query);

			if ($result->num_rows > 0) {
				$row= $result->fetch_assoc();
				$_SESSION['id']=$row['city_id'];
                return true;
			}
			else {
				return false;
			}		
	}


?>