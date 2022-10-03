<?php
    $getCode= isset($_GET['code']) ? $_GET['code'] : ''; 

    if(isset($getCode) && !empty($getCode)){
        // check api if it exists
        $code = strtoupper($getCode);

        $str = file_get_contents('https://api.currencyapi.com/v3/latest?apikey=k4jkpRH8YzSAKrpqAAYHqdQiINN92aNpwUMKLKhI');
        $decode_json = json_decode($str);
        $apiCurrency = $decode_json->data->$code;

        if($decode_json == NULL){
            $response = "Code does not exist in API";
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
        else{
            $conn = new mysqli("localhost", "root", "", "currency");
            $response = array();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $date = new DateTime();
            $currentDate = $date->format('Y-m-d H:i:s');

            $codeExists = "SELECT * FROM currency WHERE code = '$code' LIMIT 1" ;
                          
            $codeExistsResult = $conn->query($codeExists);

            if(mysqli_num_rows($codeExistsResult) == 0){
                $sql = "INSERT INTO currency (code, rate, date) VALUES ('$apiCurrency->code','$apiCurrency->value','$currentDate')";
                $result = $conn->query($sql);
            
                $conn->close(); 
    
                echo $code . ' currency has been added'; 
            }
            else{
                // die("Connection failed: " . $conn->connect_error);
                $response = "
                <div> 
                    Code exists already. Please try again. <br><br>
                    Example: To add USD to currencies, the format must be '/CurrencyExam/add/USD' 
                </div>
                ";
                echo $response;
            }

        }
    }
    else{
        $response = "
        <div> 
            A code must be entered <br><br>
            Example: To add USD to currencies, the format must be '/CurrencyExam/add/USD' 
        </div>
        ";
        echo $response;
    }

?>