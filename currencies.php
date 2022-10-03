<?php

    // Create connection
        $conn = new mysqli("localhost", "root", "", "currency");
        $response = array();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM currency";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $i=0;
            while($row = $result->fetch_assoc()) {
                $response[$i]['code'] = $row['code'];
                $i++;    
            }
            echo json_encode($response, JSON_PRETTY_PRINT);
        } 
        $conn->close();
    ?>