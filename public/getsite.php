<?php
    
    require("../includes/config.php");
    
    if (empty($_POST["url"]))
    {
        http_response_code(400);
        exit;
    }
    $url = 'http://www.shiksha.com/b-tech/colleges/b-tech-colleges-chennai';
    $_POST['id']='1';
    //$url = $_POST['url'];
    //get file http
    $results= file_get_contents($url);
    
    //Get College individual sets -30
    preg_match_all('/<div class="clg-tpl-parent">[^\b]+?(<p class="clr">)/',$results,$colleges);
    $n=count($colleges[0]); //number of colleges
    
    //loop through each set
    for($i=0;$i<$n;$i++){
        //initialize variables
        $cname="$1";
        $location="$1";
        $facilities="$1";
        $reviews="$1";
        
        preg_match('/target="_blank">([^<]+)<\/a>/',$colleges[0][$i],$cname); //college name
        preg_match('/<p>\| *([^<]+)<\/p>/',$colleges[0][$i],$location); //location
        
        //echo $cname[1]."<br>".$location[1]."<br>";
        
        //facilites
        if(preg_match('/<ul class="facility-icons">/',$colleges[0][$i])!=0){
        
            preg_match_all('/<h3>([^<]+)<\/h3>/',$colleges[0][$i],$facilities);
            $ft=count($facilities[0]);
            //for($j=0;$j<$ft;$j++)
            //    echo $facilities[1][$j]."<br>";
        }
        else{
            $ft=0;
            $facilities="-";
        }
        
        //reviews
        
        if(preg_match('/<span><b>[^<]+<\/b><a target="_blank" type="reviews"/',$colleges[0][$i],$reviews)!=0){
            $reviews = $reviews[0];
        }
        else{
            $reviews="-";
        }
    }
    
    $conn =dbconnect();
		if($conn->connect_error){
				die("Connection Failed".$conn->conncet_error);
		}
		else{
			//INSERT CNAME,LOCATION,AND FACILITIES
			$query = "INSERT INTO college(city_id,college,location,reviews) VALUES(".$_POST['id'].",'".$cname."','".$location."',".$reviews.")";
		    $conn->query($query);
		    $query = "SELECT id FROM college WHERE college='".$cname."'";
		    $c_id=$conn->query($query);
		    $c_id=$c_id[0]['id'];
		    //ADD FACILITIES
		    if($ft==0){
		        $query = "INSERT INTO facilities(city_id,college_id,facility) VALUES(".$_POST['id'].",".$c_id.","."'-')";
		    }
		    else{
		        for($k=0;$k<$ft;$k++){
		            $query = "INSERT INTO facilties(city_id,college_id,facility) VALUES(".$_POST['id'].",".$c_id.",'".$facilities[1][$k]."')";
		        }
		    $conn->query($query);
		    }
		}
?>