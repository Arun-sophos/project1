<?php
    require("../includes/config.php");
?>
    <script src="/js/jquery-1.11.3.min.js"></script>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        require("../views/header.php");
        require("../views/form.php");
        require("../views/footer.php");
    }
    else if($_SERVER["REQUEST_METHOD"] == "POST"){
        $url = $_POST['url'];
        $site = file_get_contents($url);
        //run and check for location 
        preg_match('/<a href="javascript:void\(0\);"\sdata-section="city" data-val="[^"]+">([^<]+)<i>x<\/i><\/a>/',$site,$matches);
        //look whether you found city on that page or not
        if(!empty($matches)){
          //look for it in db
          $loc = $matches[1];
          $_SESSION['city']="$loc";
          $conn =dbconnect();
	        if($conn->connect_error){
			    die("Connection Failed".$conn->conncet_error);
	        }
	        else{
			    $query = "SELECT * FROM cities WHERE city='".$loc."'";
    			$result = $conn->query($query);
	    		if ($result->num_rows > 0){//if found redirect to scrapper.php
	    			$row=$result->fetch_assoc();
	    			$_SESSION['id']=$row['city_id'];
		    		//city found Redirect to scrapped.php
		    		redirect("scrapped.php");
			    }
			    else{//else make ajax request**
			    	 //enter that city into sql table
			    	 $query = "INSERT into cities(city) VALUES('".$loc."')";
    			     $result = $conn->query($query);
    			     $city_id = $conn->insert_id;
                     $_SESSION['id']=$city_id;
			         //prepare url
			         $url=preg_replace('/(-[0-9]+.*)/',"",$url);
			         //make ajax request
?>			         
			         <center><h3 style="margin-top:20%">LOADING......</h3><br><img src ="img/ajax-loader.gif" ></img></center>
<?php		         while(true){
?>

<script>
    		  $.ajax({
				type: "POST",
				url: 'getsite.php',
				data: {
        			link: "<?php echo $url;?>",
        		    id: "<?php echo $city_id;?>"	
    		    },
				async: false
			  });
</script>

<?php           
			             //in that url go and look for pagination
			             $site = file_get_contents($url);
			             if(preg_match('/<li class="next linkpagination"><a.+?href\s*=\s*([^>]+)/',$site,$matches)==0){
			                 break;
			             }
			             else{
			                 $url=$matches[1];
			             }
                         //if found go and run it again
			         }//while
                 
			    }//ajax script main else
?>
<script type="text/javascript" language="JavaScript">
               setTimeout(function () {
                      location.href = 'scrapped.php'; 
               }, 2000);
</script>
<?php
	        }//main else dbconnect
        }//if matches
        else{
                echo '<script>alert("WRONG URL FORMAT IT ISNOT GIVING ANY CITY DETAIL")</script>';
?>
<script type="text/javascript" language="JavaScript">
               setTimeout(function () {
                      location.href = 'index.php'; 
               }, 0);
</script>
<?php                
        }
    }
?>