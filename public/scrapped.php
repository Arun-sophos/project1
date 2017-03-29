<?php
		//give me city name i will show the data SESSION city and id
		require('../includes/config.php');
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
	        	$query = "SELECT * FROM cities WHERE city_id='".$_SESSION['id']."'";
		        $cm = $conn->query($query);
		        $row= $cm->fetch_assoc();
	  	        $query = "SELECT * FROM college WHERE city_id='".$_SESSION['id']."'";
		        $city_data = $conn->query($query);
		        $nc = $city_data->num_rows;//no. of colleges
		        
		    	//iterate through each college
		    	while($row=$city_data->fetch_assoc()){
			        $college_id = $row['id'];
			        $college_name = $row['college'];
	   		        $college_location = $row['location'];
			        $college_reviews = $row['reviews'];
?>
                    <table class="table table-striped" style="border:5px outset #ff99ff;background-color:#e6ccff">
                    <tr align="left">
                        <td width="30%">College Name</td>
                        <td width="70%"><?php echo $college_name;?></td>
                    </tr>
                    <tr align="left">
                        <td width="30%">College Location</td>
                        <td width="70%"><?php echo $college_location;?></td>
                    </tr>
                    <tr align="left">
                        <td width="30%">Reviews</td>
                        <td width="70%"><?php echo $college_reviews;?></td>
                    </tr>
                    
<?php
			        $query = "SELECT facility FROM facilities WHERE college_id='".$college_id."'";
			        $college_facilities = $conn->query($query);
			        if($college_facilities->num_rows>0){
			        $nf=$college_facilities->num_rows;//no. of college facilities
			            
?>
                    <tr align='left'>
                    <td rowspan='<?php echo $nf;?>' width="30%">Facilities</td>
<?php
                        $j=0;
                        while($row=$college_facilities->fetch_assoc()){
                        	
?>                            <?php if($j!=0)echo "<tr align='left'>";?><td width="70%"><?php echo $row['facility'];?></td></tr>
                    
<?php
                        
                        	$j++;
                        }//for college
			        }//if college facilities exist
			        else{
?>
			        <td width="70%">-</td>
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
