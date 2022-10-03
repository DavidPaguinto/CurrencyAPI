<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Currencies</title>
    </head>

    <body>
        <div class="container">
            <div class="">
                <a href="update"><button class="update">Update Currency Rates</button></a>
            </div>
            <div class="currency">
                <div class="table">
                    <?php
                        $conn = new mysqli("localhost", "root", "", "currency");
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM currency";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table><tr><th>Currency Code</th><th>Rate</th></tr>";
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr><td>".$row['code']."</td><td>".$row['rate']."</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "No results ";
                        }
                        $conn->close();
                    ?>
                </div>
            </div>

        </div>
        
    </body>
</html>