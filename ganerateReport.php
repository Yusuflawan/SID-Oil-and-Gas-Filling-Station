<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';
// include "includes/header.php";

$db_conn = new Database();
$db = $db_conn->connect();

$admin = new Admin($db);

// $report = "";

?>



<?php

$dailySalesResult = $admin->getDailySalesTransaction();

$dailySale = "";
// $monthlySale = "";
if ($dailySalesResult->num_rows > 0) {
    
    $index = 1;

    while ($row = $dailySalesResult->fetch_assoc()) {
        $dailySale .= '<tr>
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
    $dailySale = '<tr>
                <td>No record found</td>
            </tr>';
}

?>




<?php

$weeklySalesResult = $admin->getWeeklySalesTransaction();

$weeklySale = "";

if ($weeklySalesResult->num_rows > 0) {

    $index = 1;

    while ($row = $weeklySalesResult->fetch_assoc()) {
        $weeklySale .= '<tr>
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
    $weeklySale = '<tr>
                        <td>No record found</td>
                    </tr>';
}

?>




<?php

$monthlySalesResult = $admin->getMonthlySalesTransaction();

$monthlySale = "";

if ($monthlySalesResult->num_rows > 0) {

    $index = 1;

    while ($row = $monthlySalesResult->fetch_assoc()) {
        $monthlySale .= '<tr>
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
    $monthlySale = '<tr>
                        <td>No record found</td>
                    </tr>';
}

?>



<?php

$dailyExpensesResult = $admin->getDailyExpensesTransaction();

$dailyExpenses = "";

if ($dailyExpensesResult->num_rows > 0) {
    
    $index = 1;

    while ($row = $dailyExpensesResult->fetch_assoc()) {
        $dailyExpenses .= '<tr>
                        <td>' .$index.'</td>
                        <td>' .$row['date'].'</td>
                        <td>' .$row['category'].'</td>
                        <td>' .$row['amount'].'</td>
                        <td>' .$row['description'].'</td>
                        <td>' .$row['firstName']. " " .$row['lastName'].'</td>
                    </tr>';
        $index++;
    }
}
else {
    $dailyExpenses = '<tr>
                        <td>No record found</td>
                    </tr>';
}

?>



<?php

$weeklyExpensesResult = $admin->getWeeklyExpensesTransaction();

$weeklyExpenses = "";

if ($weeklyExpensesResult->num_rows > 0) {
    
    $index = 1;

    while ($row = $weeklyExpensesResult->fetch_assoc()) {
        $weeklyExpenses .= '<tr>
                        <td>' .$index.'</td>
                        <td>' .$row['date'].'</td>
                        <td>' .$row['category'].'</td>
                        <td>' .$row['amount'].'</td>
                        <td>' .$row['description'].'</td>
                        <td>' .$row['firstName']. " " .$row['lastName'].'</td>
                    </tr>';
        $index++;
    }
}
else {
    $weeklyExpenses = '<tr>
                        <td>No record found</td>
                    </tr>';
}

?>




<?php

$monthlyExpensesResult = $admin->getMonthlyExpensesTransaction();

$monthlyExpenses = "";

if ($monthlyExpensesResult->num_rows > 0) {
    
    $index = 1;

    while ($row = $monthlyExpensesResult->fetch_assoc()) {
        $monthlyExpenses .= '<tr>
                        <td>' .$index.'</td>
                        <td>' .$row['date'].'</td>
                        <td>' .$row['category'].'</td>
                        <td>' .$row['amount'].'</td>
                        <td>' .$row['description'].'</td>
                        <td>' .$row['firstName']. " " .$row['lastName'].'</td>
                    </tr>';
        $index++;
    }
}
else {
    $monthlyExpenses = '<tr>
                        <td>No record found</td>
                    </tr>';
}

?>




<?php

if (isset($_GET['type'])) {
    $reportType = $_GET['type'];

    switch ($reportType) {
        case 'dailySales':
            // $report = getDailySaleReport();

            echo '
                <div class="all-transactions" id="all-transactions">
                    <div class="all-transaction-print-container">
                        <h3>Daily Sales Transactions</h3>
                        <div class="print-button" onclick="print()"><button>print</button></div>
                    </div>
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
                                '. $dailySale .' 
                            </tbody>
                    </table>
                </div>
            ';
            break;

        case 'weeklySales':
            // echo getDailyReport();
            echo '
                <div class="all-transactions" id="all-transactions">
                    <div class="all-transaction-print-container">
                        <h3>Weekly Sales Transactions</h3>
                        <div class="print-button" onclick="print()"><button>print</button></div>
                    </div>
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
                                '. $weeklySale .' 
                            </tbody>
                    </table>
                </div>';
            break;

        case 'monthlySales':
            // echo getDailyReport();

            echo '
                <div class="all-transactions" id="all-transactions">
                    <div class="all-transaction-print-container">
                        <h3>Monthly Sales Transactions</h3>
                        <div class="print-button" onclick="print()"><button>print</button></div>
                    </div>
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
                                '. $monthlySale .' 
                            </tbody>
                    </table>
                </div>';
            break;

        case 'dailyExpenses':
            // echo getDailyReport();

            echo '
                <div class="all-transactions" id="all-transactions">
                    <div class="all-transaction-print-container">
                        <h3>Daily Expenses Transactions</h3>
                        <div class="print-button" onclick="print()"><button>print</button></div>
                    </div>
                    <table>
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Expense Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Approved By</th>
                                </tr>
                            </thead>
                            <tbody>
                                '. $dailyExpenses .' 
                            </tbody>
                    </table>
                </div>
            ';
            break;

        case 'weeklyExpenses':
            // echo getDailyReport();

            echo '
                <div class="all-transactions" id="all-transactions">
                    <div class="all-transaction-print-container">
                        <h3>Weekly Expenses Transactions</h3>
                        <div class="print-button" onclick="print()"><button>print</button></div>
                    </div>
                    <table>
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Expense Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Approved By</th>
                                </tr>
                            </thead>
                            <tbody>
                                '. $weeklyExpenses .' 
                            </tbody>
                    </table>
                </div>
            ';
            break;

        case 'monthlyExpenses':
            // echo getDailyReport();

            echo '
                <div class="all-transactions" id="all-transactions">
                    <div class="all-transaction-print-container">
                        <h3>Monthly Expenses Transactions</h3>
                        <div class="print-button" onclick="print()"><button>print</button></div>
                    </div>
                    <table>
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Expense Category</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Approved By</th>
                                </tr>
                            </thead>
                            <tbody>
                                '. $monthlyExpenses .' 
                            </tbody>
                    </table>
                </div>
            ';
            break;
        
        default:
            echo "Invalid report type";
            break;
    }
}
else{
    echo "No report type specified";
}

?>


<?php

function getDailySaleReport(){

    return ;
}

?>





            
<script>
    function print(){
        window.print(document.querySelector(".all-transactions"));
    }
</script>
    