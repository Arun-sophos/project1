<?php
    //REQUIRE POST url and id
    require("../includes/config.php");
    
    if (empty($_POST["link"]))
    {
        http_response_code(400);
        exit;
    }
    
    //$_POST['url']="http://www.shiksha.com/b-tech/colleges/b-tech-colleges-chennai";
    $url=$_POST['link'];
    //$_POST['id']=1;
    
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
        $cname=$cname[1];
        $location=$location[1];
        
        //facilites
        if(preg_match('/<ul class="facility-icons">/',$colleges[0][$i])!=0){
            preg_match_all('/<h3>([^<]+)<\/h3>/',$colleges[0][$i],$facilities);
            $ft=count($facilities[0]);
        }
        else{
            $ft=0;
            $facilities="-";
        }
        
        //reviews
        
        if(preg_match('/<span><b>([^<]+)<\/b><a target="_blank" type="reviews"/',$colleges[0][$i],$reviews)!=0){
            $reviews=$reviews[1];
        }
        else{
            $reviews=0;
        }
        //UPLOAD TO DB
        
        
    $conn =dbconnect();
		if($conn->connect_error){
				die("Connection Failed".$conn->conncet_error);
		}
		else{
			
			//INSERT CNAME,LOCATION,AND FACILITIES
			$query = "INSERT INTO college(city_id,college,location,reviews) VALUES(".$_POST['id'].",'".$cname."','".$location."',".$reviews.")";
		    $conn->query($query);
		    $c_id = $conn->insert_id;
		    
		    //ADD FACILITIES
		    if($ft==0){
		        $query = "INSERT INTO facilities(city_id,college_id,facility) VALUES(".$_POST['id'].",".$c_id.","."'-'".")";
		        $conn->query($query);
		    }
		    else{
		        for($k=0;$k<$ft;$k++){
		            $query = "INSERT INTO facilities(city_id,college_id,facility) VALUES(".$_POST['id'].",".$c_id.",'".$facilities[1][$k]."')";
		            $conn->query($query);
		        }
		    }
		}
    }
    $query="UPDATE cities SET results = results + ".$n." WHERE city_id = ".$_POST['id'];
    $conn->query($query);
    exit(1);
?>