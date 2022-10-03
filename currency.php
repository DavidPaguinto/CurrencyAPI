<?php
    $code= isset($_GET['code']) ? $_GET['code'] : ''; 

    if(isset($code) && !empty($code)){
        $conn = new mysqli("localhost", "root", "", "currency");
        $response = array();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT rate,date FROM currency WHERE code='$code' ";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // $response['code'] = $row['code'];
                $response['rate'] = $row['rate'];
                $response['date_updated'] = $row['date'];
            }

            echo json_encode($response, JSON_PRETTY_PRINT);
        } 
        else{
            $response = "Invalid Code";
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
        $conn->close();
    }
    else{
        $response = "Please enter a Code";
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

?>