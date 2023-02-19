<?php
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "Spark Bank"; 
    
    $conn = new mysqli($servername, $username, $password, $dbname); 
    
    if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
    echo '<link href="style.css" rel="stylesheet" type="text/css" />';
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer</title>
    <link rel="stylesheet" href="style.css" />      
    <script src="https://kit.fontawesome.com/e37ebd7d1b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.php" id="navbar__logo"><i class="fa-solid fa-building-columns"></i>Bank of Sparks</a>
            <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="index.php" class="navbar__links">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="customers.php" class="navbar__links">Customers</a>
                </li>
                <li class="navbar__item">
                    <a href="transferfunds.php" class="navbar__links">Transfer Funds</a>
                </li>
                <li class="navbar__item">
                    <a href="transactions.php" class="navbar__links">Transaction Details</a>
                </li>
                <li class="navbar__item">
                    <a href="contact.php" class="navbar__links">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main">
        <div class="head__container">
            <h1>Fund Transfer Details</h2>
        </div>
        <br> 
        <?php 
            if(isset($_POST['form-submitted'])) {
            //These variables are collecting form data
            $PAYER_ID = $_POST['PayerID'];
            $PAYEE_ID = $_POST['PayeeID'];
            $AMOUNT = $_POST['Amount'];

            if(empty($PAYER_ID) || empty($PAYER_ID) || empty($AMOUNT)) {        
                echo "<script> alert('Empty Fields.');
                window.location.href='transferfunds.php';
                </script>";  
                exit() ;           
            }

            if($AMOUNT <= 0) {
                echo "<script> alert('Amount must be greater than zero.');
                window.location.href='transferfunds.php';
                </script>";  
                exit() ;  
            }

            if(!ctype_digit($AMOUNT) || !ctype_digit($PAYER_ID) || !ctype_digit($PAYEE_ID)) {
                echo "<script> alert('Entered value can only contain digits.');
                window.location.href='transferfunds.php';
                </script>";  
                exit() ;  
            }

            $sqlcount = "SELECT COUNT(1) FROM Customers where AccNo='$PAYER_ID'";
            $r = $conn->query($sqlcount);
            $d = $r->fetch_row();
            if($d[0]<1) {
                echo "<script> alert('Payer ID does not exist. ');
                window.location.href='transferfunds.php';
                </script>";  
                exit() ;      
            }
            
            $sqlcount = "SELECT COUNT(1) FROM Customers where AccNo='$PAYEE_ID'";
            $r = $conn->query($sqlcount);
            $d = $r->fetch_row();
            if($d[0]<1) {
                echo "<script> alert('Payee ID does not exist. ');
                window.location.href='transferfunds.php';
                </script>";  
                exit() ;      
            }
            
            $sql = "SELECT * FROM Customers where AccNo='$PAYER_ID'";       
            if($result = $conn->query($sql)) {            
                $row1 = $result->fetch_array(); 
                if($row1['Balance']<$AMOUNT){
                    echo "<script> alert('Payer does not have enough balance. ');
                    window.location.href='transferfunds.php';
                    </script>";  
                    exit() ; 
                }  
            }  
                    
            echo "<div class='tf__container'>";
            echo "<div class='tf__text'>";
            echo "             
                <h2>Transaction Completed Successfully.</h2>
                <h3>Details of the Transactions are as follows.</h3>
                </div>
                <table class='tf__table'>
                <tr>
                    <th></th>
                    <th>Account No</th>
                    <th>Name</th>
                    <th>Email</th>               
                </tr>";
          
            $sql = "SELECT * FROM Customers where AccNo='$PAYER_ID'";       
            if($result = $conn->query($sql)) {            
            $row1 = $result->fetch_array(); 
            echo "<tr> 
                    <th> Payer </th>
                    <td>".$row1['AccNo']."</td>
                    <td>".$row1['Name']."</td>
                    <td>".$row1['Email']."</td>
                </tr>";                        
            $PayerCurrentBalance = $row1['Balance'];            
            }
        
            $sql2 = "SELECT * FROM Customers where AccNo='$PAYEE_ID'";
            if($result = $conn->query($sql2)) {            
            $row2 = $result->fetch_array();
            echo "<tr> 
                    <th> Payee </th>
                    <td>".$row2['AccNo']."</td>
                    <td>".$row2['Name']."</td>
                    <td>".$row2['Email']."</td>
                  </tr>"; 
            $PayeeCurrentBalance = $row2['Balance'];                   
            }               
            echo "</table>";

            $PayeeCurrentBalance += $AMOUNT;
            $PayerCurrentBalance -= $AMOUNT;
            echo "<br>";
            echo "<table class='tf__table''>
                    <tr>
                        <th></th>
                        <th>Old Balance</th>
                        <th>New Balance</th>
                    </tr>
                    <tr>
                        <th>Payer</th>
                        <td>".$row1['Balance']."</td>                        
                        <td>".$PayerCurrentBalance."</td>
                    </tr>
                    <tr>
                        <th>Payee</th>
                        <td>".$row2['Balance']."</td>                        
                        <td>".$PayeeCurrentBalance."</td>
                    </tr>";
            echo "</table>";

            $updatepayer ="UPDATE Customers SET Balance ='$PayerCurrentBalance' where AccNo='$PAYER_ID'";
                
            $updatepayee ="UPDATE Customers SET Balance ='$PayeeCurrentBalance' where AccNo='$PAYEE_ID'";
            
            if($conn->query($updatepayer) == true) {
                ?>         
                <script>console.log("Payer details updated.")</script>
                <?php
            }
            else {
                ?>        
                <script>alert("Payer details NOT updated.")</script>
                <?php
            }

            if($conn->query($updatepayee) == true) {
                ?>         
                <script>console.log("Payee details updated.")</script>
                <?php
            }
            else {
                ?>        
                <script>alert("Payee details NOT updated.")</script>
                <?php
            }
                
            date_default_timezone_set('Asia/Kolkata');           
            $date = date('Y-m-d H:i:s',time());
                
            $InsertTransactTable ="INSERT INTO Transactions(Payer, PayerAcc, Payee, PayeeAcc, Amount, Time) values ('$row1[Name]','$row1[AccNo]','$row2[Name]','$row2[AccNo]','$AMOUNT','$date')";
                
            if($conn->query($InsertTransactTable) == true) {
                ?>         
                <script>console.log("Record of this transaction saved.")</script>
                <?php
            }
            else {
                ?>        
                <script>alert("Record of this transaction NOT saved.")</script>
                <?php
            }
            echo "<br>";
            echo "</div>";
            echo "</div>";
        }
        else {
            ?>
            <h4>All transactions are up to date.</h1>
            <?php
        }    
        $conn->close();
        ?>
    </div>
</body>
</html>

