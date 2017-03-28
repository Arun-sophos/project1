<?php

    require("../includes/config.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        require("../views/header.php");
        require("../views/form.php");
        require("../views/footer.php");
    }
    
    //else run js script
    else if($_SERVER["REQUEST_METHOD"] == "POST"){
    	
    	echo '<script src="/js/jquery-1.11.3.min.js"></script>';
        
        $url = $_POST['url'];
        $site = file_get_contents($url);
        //run and check for location 
        preg_match('/<a href="javascript:void\(0\);"\sdata-section="city" data-val="[^"]+">([^<]+)<i>x<\/i><\/a>/',$site,$matches);
        //look whether you found city on that page or not
        
        if(!empty($matches)){
        
        //look for it in db
        $loc = $matches[1];

        $conn =dbconnect();
	        if($conn->connect_error){
			    die("Connection Failed".$conn->conncet_error);
	        }
	        
	        else{

			    $query = "SELECT * FROM cities WHERE city='".$loc."'";
    			$result = $conn->query($query);

                //if found redirect to scrapper.php
	    		if ($result->num_rows > 0) {
		    		//city found Redirect to scrapped.php
		    		redirect("scrapped.php");
			    }
			    //else make ajax request**
			    else{

			    	 //enter that city into sql table
			    	 $query = "INSERT into cities(city) VALUES('".$loc."')";
    			     $result = $conn->query($query);
    			     $city_id = $conn->insert_id;

			         //prepare url
			         $url=preg_replace('/(-[0-9]+.*)/',"",$url);
			         
			         //make ajax request
			         while(true){
?>
<img alt="loading" src="/img/ajax-loader.gif"/>
<script>
	          $.post('getsite.php',
    		  {
        				url: <?php echo $url;?>,
        				id: <?php echo $city_id;?>
    		  });       
</script>
<?php
                         echo '<script>alert('.$url.')</script>';
			             //in that url go and look for pagination
			             $site = file_get_contents($url);
			             if(preg_match('/<li class="next linkpagination"><a.+?href\s*=\s*([^>]+)/',$site,$matches)==0){
			                 break;
			             }
			             else{
			                 $url=$matches[1];
			                 sleep(5);
			             }
                         //if found go and run it again
			             
			         }//while
			    }//ajax script main else
			
	        }//main else dbconnect
        }//if matches
        else{
                echo '<script>alert("WRONG URL FORMAT IT ISNOT GIVING ANY CITY DETAIL")</script>';
        }
    }
?>