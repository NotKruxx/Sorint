<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Change Profile</title>
</head>
<body style="background: lightgray;">
<style>
                .pulsante{
                    background-color:#0f2ec89d; 
                    color:white;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                }
            </style>
<div class="nav">
            <div class="logo">
                <p><a href="home.php"class="titolo-logo">Pennywise</a> </p>
            </div>

            <div class="right-links">

                <?php

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_id = $result['Id'];
                    $res_Imports = $result['Imports'];
                    $res_Types = $result['Type'];
                }

                $amount_imports = 0;
                $imports_array = array_map('intval', explode(";", $res_Imports));



                $types_array = explode(";",$res_Types);

			$balance = array_sum($imports_array);



               $amount_imports = count($imports_array);

                $postive_imports_array = array();
                $negative_imports_array = array();
                foreach($imports_array as $import){
                    if($import >= 0){
                        array_push($postive_imports_array, $import);
                    } else {
                        array_push($negative_imports_array, $import);
                    }
                }

                echo "<a href='edit_transaction.php'>Edit or Delete Transactions</a>";
                echo "<a href='edit.php?Id=$res_id'>Change Profile</a>";
                echo "<a href='transaction.php?Id=$res_id'>Save a transaction</a>";
                ?>

                <a href="php/logout.php"> <button class="btn" style="background-color:#0f2ec89d;color:white">Log Out</button> </a>

            </div>
        </div>
    <div class="container">
        <div class="box form-box">
            <?php 
               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];

                $id = $_SESSION['id'];

                $edit_query = mysqli_query($con,"UPDATE users SET Username='$username', Email='$email', Age='$age' WHERE Id=$id ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Profile Updated!</p>
                </div> <br>";
              echo "<a href='home.php'><button class='pulsante'>Go Home</button>";
       
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                }

            ?>
            <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>
                
                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Update" style="background-color:#0f2ec89d;color:white" required>
                </div>
                
                    </form>
                </div>
            <?php } ?>
        </div>
    </body>
</html>