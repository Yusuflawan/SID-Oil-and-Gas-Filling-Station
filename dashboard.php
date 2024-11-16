<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';
include "includes/header-div.php";

$db_conn = new Database();
$db = $db_conn->connect();

$admin = new Admin($db);

?>


<?php

$salesResult = $admin->getRecentSalesTransaction();

if ($salesResult->num_rows > 0) {

    $sales = "";
    $index = 1;

    while ($row = $salesResult->fetch_assoc()) {
        $sales .= '<tr>
                        <td>' .$index.'</td>
                        <td>' .$row['date'].'</td>
                        <td>' .$row['productType'].'</td>
                        <td>' .$row['amount'].'</td>
                        <td>' .$row['firstName']. " " .$row['lastName'].'</td>
                    </tr>';
        $index++;
    }

}
else {
    $sales = '<tr>
                <td>No record found</td>
            </tr>';
}

?>



<?php

$totalPetrolSales = $admin->getTodaysTotalPetrolSale();

if ($totalPetrolSales->num_rows > 0) {

    while ($row = $totalPetrolSales->fetch_assoc()) {
            $totalPSale = $row['totalSales'];
        }
    }

?>


<?php

$totalGasSales = $admin->getTodaysTotalGasSale();

if ($totalGasSales->num_rows > 0) {

    while ($row = $totalGasSales->fetch_assoc()) {
            $totalGSale = $row['totalSales'];
    }
}
    
?>


<?php

$totalExpenses = $admin->getTodaysTotalExpenses();


if ($totalExpenses->num_rows > 0) {

    while ($row = $totalExpenses->fetch_assoc()) {
        $totalExpensesForToday = $row['totalExpenses'];
    }
}


    
?>



<?php include "includes/header.php"; ?>

    <div class="dashboard-container">
        <div class="container">
            <?php include "includes/side-nav-bar.php" ?>
            <div class="dashboard-contents">
                <div class="total-sale">
                    <div class="petrol-sale">
                        <h4>Total Petrol Sales for today: <?php echo " ". number_format($totalPSale, 0); ?> </h4>
                    </div>
                    <div class="gas-sale">
                        <h4>Total Gas Sales for today: <?php echo " ". number_format($totalGSale, 0); ?> </h4>
                    </div>
                    <br>
                    <div class="petrol-sale">
                        <h4>Total Expenses for today:  <?php echo " ". number_format($totalExpensesForToday, 0); ?> </h4>
                    </div>
                </div>
                <div class="recent-transaction">
                    <h3>Recent Sales Transactions</h3>
                    <table>
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Sold by</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php echo $sales; ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>