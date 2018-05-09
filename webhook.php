<?php

    function setupDB($paper){
        
        $servername = "localhost"; //Sets up settings for Database link
    	$username = "user";
    	$password = "12345";
    	$dbname = "id5450297_testdb1";
					
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM SECHAT WHERE papername LIKE '%$paper%'"; //Gets data to match search query
		$result = mysqli_query($conn,$sql) ; //Executes set Query
					
		if(mysqli_num_rows($result) > 0) 
		{    
			while($row=mysqli_fetch_assoc($result))   
			{
			    $prereq = $row["prereq"];
			}
		}
        return $prereq;
    }
	
    function processMessage($update) {
        //$pre = setupDB($paper);
        if($update["result"]["action"] == "sayHello" ){
            $paper = $update["result"]["parameters"]["paperName1"];
            
            
            sendMessage(array(
                "source" => $update["result"]["source"],
                "speech" => "Hello from webhook " . $paper,
                "displayText" => "Hello from webhook "  . $paper,
                "contextOut" => array()
            ));
        }
    }
    
    function sendMessage($parameters) {
        echo json_encode($parameters);
    }
    
    $update_response = file_get_contents("php://input");
    $update = json_decode($update_response, true);
    if (isset($update["result"]["action"])) {
        processMessage($update);
    }
?>