<?php
//give me city name i will show the data
            require('../views/header.php');
            if (empty($_SESSION["city"]))
            {
                http_response_code(400);
                exit;
            }
    
            $conn =dbconnect();
	        if($conn->connect_error){
		    	die("Connection Failed".$conn->conncet_error);
		    	echo "db connect fail";
        	}
	        else{
	            $_POST["city"]=mysqli_real_escape_string($conn,$_SESSION["city"]);
			    $query = "SELECT * FROM cities WHERE city='".$_SESSION["city"]."'";
			    $result = $conn->query($query);
			    $row= $result->fetch_assoc();
			    $_SESSION['id']=$row['city_id'];
		  	    $query = "SELECT * FROM college WHERE city='".$_SESSION["city"];
			    $city_data = $conn->query($query);
			
		    	$nc = $city_data->num_rows;//no. of colleges
			
		    	//iterate through each college
		    	for($i=0;$i<$n;$i++){
			        $college_id = $city_data[$i]['id'];
			        $college_name = $city_data[$i]['college'];
	   		        $college_location = $city_data[$i]['location'];
			        $college_reviews = $city_data[$i]['reviews'];
?>
                    <table class="table table-striped">
                    <tr align="left">
                        <td>College Name</td>
                        <td><?= $college_name?></td>
                    </tr>
                    <tr align="left">
                        <td>College Location</td>
                        <td><?= $college_location?></td>
                    </tr>
                    <tr align="left">
                        <td>Reviews</td>
                        <td><?= $college_reviews?></td>
                    </tr>
                    
<?php
			        $query = "SELECT facility FROM facilities WHERE college_id='".$college_id;
			        $college_facilities = $conn->query($query);
			        if($college_facilities->num_rows>0){
			            $nf=$college_facilities->num_rows;
			            
?>
                    <tr align="left">
                    <td rowspan="<?=$nf?>">Facilities</td>
<?php
                        for($j=0;$j<$nf;$j++){
?>                            <?if($j!=0)echo "<tr>";?><td><?=$college_facilities[$j]?></td></tr>
                    
<?php
                        }//for college
			        }//if college facilities exist
			        else{
?>
			        <td>-</td>
			        </tr>
<?php			    }//college facilities zero
?>
                    </table>
                    <br><br>
<?php
     
	    		}//for
	        }//else db
	    require('../views/footer.php');
?>
