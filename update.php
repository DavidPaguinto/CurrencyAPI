<?php
    //fetch  all codes in local db using SELECT query
    // Create connection
    $conn = new mysqli("localhost", "root", "", "currency");
    $response = array();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT code FROM currency";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $i=0;
        while($row = $result->fetch_assoc()) {
            $response[$i] = $row['code'];
            $i++;    
        }
        
        // foreach statement for all of currency codes in the MYSQL Currency Table
        foreach($response as $currencyCode)
        {
            // fetch updated currencies via API
            // store it in variable json
            $currencyApi = file_get_contents('https://api.currencyapi.com/v3/latest?apikey=k4jkpRH8YzSAKrpqAAYHqdQiINN92aNpwUMKLKhI');
            $currencyApi = json_decode($currencyApi);

            // pinpoint the updated currency from stored API variable 
            $currencyCodeApi = $currencyApi->data->$currencyCode;

            // update the values for that specific currency code
            // save as the current date and time

            $date = new DateTime();
            $currentDate = $date->format('Y-m-d H:i:s');


            $sql = "UPDATE currency
                    SET rate = '$currencyCodeApi->value', date= '$currentDate'
                    WHERE code = '$currencyCode';";

            $result = $conn->query($sql);
        }
        
    } 
    
    $conn->close();
    echo 'Currencies Successfully Updated';
?>

