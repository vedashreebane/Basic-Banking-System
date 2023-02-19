<?php
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "Spark Bank"; 
    $conn = new mysqli($servername, $username, $password, $dbname); 
    if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
    } 
    $sql = "SELECT * FROM Transactions" ;
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="style.css" />      
    <script src="https://kit.fontawesome.com/e37ebd7d1b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.php" id="navbar__logo"><i class="fa-solid fa-building-columns"></i>    Bank of Sparks</a>
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
            <h1>Transaction Details</h2>
        </div>
        <br>  
        <div class="table__container">
            <table class="table table-bordered border-dark-subtle">
                <thead>
                    <tr>
                        <th scope="col">Sr No.</th>
                        <th scope="col">Payer</th>
                        <th scope="col">Payer Acc No.</th>
                        <th scope="col">Payee</th>
                        <th scope="col">Payee Acc No.</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date & Time</th>
                    </tr>
                </thead>                  
                <?php
                    while($row = $result->fetch_assoc()) { 
                    ?> 
                    <tr>
                        <td><?php echo $row['SrNo']; ?></td>
                        <td><?php echo $row['Payer']; ?></td>
                        <td><?php echo $row['PayerAcc']; ?></td>
                        <td><?php echo $row['Payee']; ?></td>
                        <td><?php echo $row['PayeeAcc']; ?></td>
                        <td><?php echo $row['Amount']; ?></td>
                        <td><?php echo $row['Time']; ?></td>        
                    </tr>
                <?php
                }
                $conn->close();
                ?> 
            </table>
        </div>        
    </div>
</body>
</html>