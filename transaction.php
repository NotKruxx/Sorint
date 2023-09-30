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
    <link rel="stylesheet" href="style/style.css">
    <title>Create transaction</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"> Pennywise</a></p>
        </div>

        <div class="right-links">
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php
               $id = $_SESSION['id'];
               $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$id ");
               while($result = mysqli_fetch_assoc($query)){
                   $res_Imports = $result['Imports'];
                   $res_Type = $result['Type'];
               }

               if(isset($_POST['submit'])){
                   $imports = $_POST['imports'];
                   $type = $_POST['type'];

                   if(is_null($res_Imports) || empty($res_Imports)){
                       $imports = $imports;
                   }else{
                       $imports = $res_Imports . ";" . $imports;
                   }

                   if(is_null($res_Type) || empty($res_Type)){
                       $type = $type;
                   }else{
                       $type = $res_Type . ";" . $type;
                   }

                   $id = $_SESSION['id'];

                   $edit_query = mysqli_query($con, "UPDATE users SET Imports='$imports', Type='$type' WHERE Id=$id ") or die("error occurred");

                   if($edit_query){
                       echo "<div class='message'>
                            <p>Profile Updated!</p>
                       </div> <br>";
                       echo "<a href='home.php'><button class='btn'>Go Home</button>";
                   }
               }else{
            ?>
            <header>Add a transaction</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Imports</label>
                    <input type="number" name="imports" id="imports" value="" autocomplete="off" required step="0.01">
                </div>

                <div class="field input">
                    <label for="email">Type</label>
                    <input type="text" name="type" id="type" value="" autocomplete="off" required>
                </div>
                
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
                
                <?php
                if(is_null($res_Imports) || empty($res_Imports)){
                    echo "The imports field is empty.";
                }else{
                    echo "The imports field is not empty.";
                }
                ?>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
