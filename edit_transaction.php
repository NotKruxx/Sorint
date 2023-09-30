<?php
session_start();

include("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $user_id = $_SESSION['id'];

    $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$user_id");
    $result = mysqli_fetch_assoc($query);
    $imports = explode(';', $result['Imports']);
    $type = explode(';', $result['Type']);

    if (isset($imports[$id]) && isset($type[$id])) {
        unset($imports[$id]);
        unset($type[$id]);

        $new_imports = implode(';', $imports);
        $new_type = implode(';', $type);

        $update_query = mysqli_query($con, "UPDATE users SET Imports='$new_imports', Type='$new_type' WHERE Id=$user_id");
        if ($update_query) {
            echo "<div class='message'>
                <p>Transaction deleted successfully!</p>
            </div> <br>";
        } else {
            echo "<div class='message'>
                <p>Error deleting transaction.</p>
            </div> <br>";
        }
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['edit'];
    $imports = $_POST['imports'];
    $type = $_POST['type'];

    $user_id = $_SESSION['id'];

    $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$user_id");
    $result = mysqli_fetch_assoc($query);
    $current_imports = explode(';', $result['Imports']);
    $current_type = explode(';', $result['Type']);

    if (isset($current_imports[$id]) && isset($current_type[$id])) {
        $current_imports[$id] = $imports;
        $current_type[$id] = $type;

        $new_imports = implode(';', $current_imports);
        $new_type = implode(';', $current_type);

        $update_query = mysqli_query($con, "UPDATE users SET Imports='$new_imports', Type='$new_type' WHERE Id=$user_id");
        if ($update_query) {
            echo "<div class='message'>
                <p>Transaction edited successfully!</p>
            </div> <br>";
        } else {
            echo "<div class='message'>
                <p>Error editing transaction.</p>
            </div> <br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="style/style.css">
</head>
<body>
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

                <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

            </div>
        </div>
    <section>
        <br>
        <br>
    <main>
        <div class="margine">
    <div class="box">
        <h2>Edit or Delete Transactions</h2>
        <?php
        $user_id = $_SESSION['id'];
        $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$user_id ");
        $result = mysqli_fetch_assoc($query);

        $imports = explode(';', $result['Imports']);
        $type = explode(';', $result['Type']);

        if (!empty($imports)) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Import</th>";
            echo "<th>Type</th>";
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
            echo "</tr>";
        
            for ($i = 0; $i < count($imports); $i++) {
                echo "<tr>";
                echo "<td>" . $imports[$i] . "</td>";
                echo "<td>" . $type[$i] . "</td>";
                echo "<td><a href='edit_delete_transactions.php?edit=$i'>Edit</a></td>";
                echo "<td><a href='edit_delete_transactions.php?delete=$i'>Delete</a></td>";
                echo "</tr>";
            }
        
            echo "</table>";
        } else {
            echo "No transactions found.";
        }
        
        ?>
    </div>
    </div>
    </section>
</body>
</html>
