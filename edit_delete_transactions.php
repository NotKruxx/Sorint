<?php
session_start();

include("php/config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $user_id = $_SESSION['id'];

    $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$user_id");
    $result = mysqli_fetch_assoc($query);
    $imports = explode(';', $result['Imports']);
    $type = explode(';', $result['Type']);

    if (isset($imports[$id]) && isset($type[$id])) {
        $import_to_edit = $imports[$id];
        $type_to_edit = $type[$id];

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="./style/style.css">
            <title>Edit Transaction</title>
        </head>
        <body>
            <main>
            <div class="container-center">
                <div class="box form-box">
                    <header>Edit Transaction</header>
                    <form action="edit_delete_transactions.php" method="post">
                        <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
                        <div class="field input">
                            <label for="imports">Import</label>
                            <input type="number" name="imports" id="imports" value="<?php echo $import_to_edit; ?>" autocomplete="off" required step="0.01">
                        </div>

                        <div class="field input">
                            <label for="type">Type</label>
                            <input type="text" name="type" id="type" value="<?php echo $type_to_edit; ?>" autocomplete="off" required>
                        </div>

                        <div class="field">
                            <input type="submit" class="btn" name="submit" value="Update" required>
                        </div>
                    </form>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $edited_imports = $_POST['imports'];
    $edited_type = $_POST['type'];

    $user_id = $_SESSION['id'];

    $query = mysqli_query($con, "SELECT * FROM users WHERE Id=$user_id");
    $result = mysqli_fetch_assoc($query);
    $imports = explode(';', $result['Imports']);
    $type = explode(';', $result['Type']);

    if (isset($imports[$edit_id]) && isset($type[$edit_id])) {
        $imports[$edit_id] = $edited_imports;
        $type[$edit_id] = $edited_type;

        $new_imports = implode(';', $imports);
        $new_type = implode(';', $type);

        $update_query = mysqli_query($con, "UPDATE users SET Imports='$new_imports', Type='$new_type' WHERE Id=$user_id");
        if ($update_query) {
            header("Location: home.php"); 
            exit;
        } else {
            echo "Error editing transaction.";
        }
    }
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
            header("Location: home.php");
            exit;
        } else {
            echo "Error deleting transaction.";
        }
    }
}
?>
