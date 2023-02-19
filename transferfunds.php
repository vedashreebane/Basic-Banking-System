<?php
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "Spark Bank"; 
    
    $conn = new mysqli($servername, $username, $password, $dbname); 
    //IF CONNECTION IS NOT SUCCESSSFUL
    if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Funds</title>
    <link rel="stylesheet" href="style.css" />      
    <script src="https://kit.fontawesome.com/e37ebd7d1b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script type="text/javascript">    
        if(window.history.replaceState) {            
            window.history.replaceState(null, null, window.location.href); 
        }       
    </script>
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
            <h1>Transfer Funds</h2>
        </div>
    </div>
        <br>  
        <div class="funds__container"> 
            <form name="form" action="transferredfunds.php" onsubmit="return validateForm()" method="post">
                <div class="mb-3">
                  <label for="Payer_Account_No" class="form-label">Payer Account No. </label>
                  <input type="number" name="PayerID" min=10000000 required class="form-control" id="input1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                  <label for="Payee_Account_No" class="form-label">Payee Account No. </label>
                  <input type="number" name="PayeeID" min=10000000 required class="form-control" id="input1">
                </div>
                <div class="mb-3">
                    <label for="Amount" class="form-label">Amount (in Rupees)</label>
                    <input type="number" name="Amount" min=1 required class="form-control" id="input1">
                </div>
                    <input type= "hidden" name= "form-submitted" value="1"></td>
                    <button type="submit" value="PROCEED" class="funds__btn">PROCEED</button>
            </form>
        </div>  
        <script>
        function validateForm() {
            var x = document.forms["form"]["PayerID"].value;
            var y = document.forms["form"]["PayeeID"].value;
            var z = document.forms["form"]["Amount"].value;
            
            var check=/^[0-9]+$/; //Checks whether there is any other digit than 0-9
            //The [^0-9] expression is used to find any character that is NOT a digit.

            if (x == "" || y == "" || z == "") {
                alert("Please Fill the Form!");
                return false;
            }

            if((Math.sign(z) == -1) || (Math.sign(z) == -0) || z == 0) {
                alert("Enter a Valid Amount to do transaction.");
                return false;
            }
            
            if(isNaN(z) || !x.match(check) || !y.match(check) || !z.match(check)){
                alert("Enter correct input.");
                return false;            
            }
        }
    </script>    
</body>
</html>