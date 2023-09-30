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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/style.css">
        <title>Home</title>
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
        <main>
            <div class="main-box top">
                <div class="top">
                    <div class="left-box">
                        <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
                    </div>
                    <div class="right-box">
                        <p>Here you can see your transactions and other useful data!</p>
                    </div>
                </div>
            <div class="botton">
                <div class="box">
                    <p>Your have made <b><?php echo $amount_imports ?> transactions</b> so far.</p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>Your budget amounts to <b><?php echo $balance ?> $</b> or <b><?php echo number_format($balance*getExchangeRate(),2) ?> </b> euro.</p>
                </div>
            </div>

            <div>
                <div class="box">
                    <table class="table">
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Amount ($)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($imports_array as $key => $import) { ?>
            <tr>
                <td style="text-align: center;"><?php echo $types_array[$key]; ?></td>
                <td style="text-align: center;"><?php echo $import; ?></td>
            </tr>
        <?php } ?>
    </tbody>

</table>
                </div>
                <div class="bottom">
                <div class="box">
                <?php

function getExchangeRate() {
    $ecb_url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    $xml = simplexml_load_file($ecb_url);
    if ($xml === false) {
        return false;
    }

    foreach ($xml->Cube->Cube->Cube as $rate) {
        if ($rate['currency'] == 'USD') {
            return (float) $rate['rate'];
        }
    }

    return false;
}

$total_income = 0;
foreach ($imports_array as $import) {
    if ($import >= 0) {
        $total_income += $import;
    }
}

$exchange_rate = getExchangeRate();
if ($exchange_rate !== false) {
    $total_income_euro = $total_income * $exchange_rate;
    echo "<p>Your total income is <b> $total_income $ </b> (approximately €$total_income_euro).</p>";
} else {
    echo "<p>Unable to fetch the exchange rate. Your total income is <b>$total_income $</b>.</p>";
}
?>



                    <?php
$total_expense = 0;
foreach($imports_array as $import){
    $import = (int)$import; 
    if($import < 0){
        $total_expense += $import;
    }
}
                        $total_expense_euro = $total_expense * $exchange_rate;
                        echo "<p>Your total expense is <b>$total_expense $ </b> (approximately $total_expense_euro €)</b>.</p>";
                        if ($total_expense*-1 > $total_income) {
                            echo "<p>You are in <b>debt</b>.</p>";
                        } else {
                            echo "<p>You are <b>not in debt</b>.</p>";
                        }
                    ?>
            </div>

            <div class="bottom">
                <div class="box">
  <div class="row">
    <div class="col-sm">
    <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <div class="col-sm">
    <canvas id="myChart2" width="400" height="400"></canvas>
    </div>
    <div class="col-sm">
      <canvas id="myChart3" width="400" height="400"></canvas>
    </div>
  </div>
</div>
                </div>
            </div>

                            <script>
        var myChart = new Chart(document.getElementById("myChart"), {
            type: "pie",
            data: {
                labels: ["Income", "Expense"],
                datasets: [{
                    data: [<?php echo $total_income ?> , <?php echo $total_expense ?>],
                    backgroundColor: ["rgba(0, 128, 0, 0.5)", "rgba(255, 0, 0, 0.5)"]
                }]
            },
            options: {
                title: "Income vs Expense"
            }
        });
    </script>

    <script>
        var myChart = new Chart(document.getElementById("myChart2"), {
            type: "pie",
            data: {
                labels: [<?php foreach ($imports_array as $key => $import) { ?>
                    <?php if ($import >= 0) { ?>
                        "Transaction number <?php echo $key + 1; ?>",
                    <?php } ?>
                <?php } ?>],
                datasets: [{
                    data: [<?php foreach ($imports_array as $key => $import) { ?>
                        <?php if ($import >= 0) { ?>
                            <?php echo $import; ?>,
                        <?php } ?>
                    <?php } ?>],
                    backgroundColor: ["rgba(0, 128, 0, 0.5)"]
                }]
            },
            options: {
                title: "Income"
            }
        });
    </script>

    <script>
        var myChart = new Chart(document.getElementById("myChart3"), {
            type: "pie",
            data: {
                labels: [<?php foreach ($imports_array as $key => $import) { ?>
                    <?php if ($import < 0) { ?>
                        "Transaction number <?php echo $key + 1; ?>",
                    <?php } ?>
                <?php } ?>],
                datasets: [{
                    data: [<?php foreach ($imports_array as $key => $import) { ?>
                        <?php if ($import < 0) { ?>
                            <?php echo $import; ?>,
                        <?php } ?>
                    <?php } ?>],
                    backgroundColor: ["rgba(255, 0, 0, 0.5)"]
                }]
            },
            options: {
                title: "Expense"
            }
        });
    </script>
</body>
</html>