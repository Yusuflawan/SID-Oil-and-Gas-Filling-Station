<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';
include "includes/header-div.php";

$db_conn = new Database();
$db = $db_conn->connect();

$admin = new Admin($db);

?>


<?php
    

if (isset($_POST['addRecordBtn'])) {
    $accountant = $_SESSION['adminId'];

    $productType = $_POST['productType'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $soldBy = $_POST['soldBy'];
    $recordedBy = $accountant;

    
    if (is_numeric($amount)) {
        
        $result = $admin->recordSales($productType, $amount, $date, $soldBy, $recordedBy);

        if ($result['success']) {
            echo "<script>alert('Record has been added successfully');
                        window.location.href='recordSales.php'
                    </script>";
        } else {
            echo "Error adding record: " . $result['error'];
        }
    }
    else {
        $cleanAmount = str_replace([' ', ','], '',$amount);

        if (!ctype_digit($cleanAmount)) {
            echo "<script>alert('Data not recorded: please enter a valid number amount!');</script>";
        }
        else{
            $result = $admin->recordSales($productType, $cleanAmount, $date, $soldBy, $recordedBy);

            if ($result['success']) {
                echo "<script>alert('Record has been added successfully');
                            window.location.href='recordSales.php'
                        </script>";
            } else {
                echo "Error adding record: " . $result['error'];
            }
        }

    }


}

?>

<?php

$productsResult = $admin->getProducts();

if ($productsResult->num_rows > 0) {
    $productOptions = "";
    while ($row = $productsResult->fetch_assoc()) {
        $productOptions .= '<option value="' . $row['id'] . '">'.$row['productType'].'</option>';
    }
} else {
    $productOptions = '<option value="">No Product found</option>';
}

?>


<?php

$employeeResult = $admin->getEmployees();

if ($employeeResult->num_rows > 0) {
    $employeeOptions = "";
    while ($row = $employeeResult->fetch_assoc()) {
        $employeeOptions .= '<option value="' . $row['id'] . '">'.$row['firstName']." ".$row['lastName'].'</option>';
    }
} else {
    $employeeOptions = '<option value="">No employees found</option>';
}

?>


<?php include "includes/header.php"; ?>

    <div class="sales-form-container">
            <?php include "includes/side-nav-bar.php" ?>
            <div class="form">
                <form action="" method="post">
                    <h2>Record Sales</h2>
                    <div class="input-container">
                        <input type="date" id="date" name="date" required placeholder="Date">
                        <label for="date">Date</label>
                    </div>
                    <div class="input-container" id="productList">
                        <select name="productType" id="">
                            <option value="" selected disabled>Select product</option>
                            <?php echo $productOptions; ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <input type="text" id="amount" name="amount" required placeholder="Amount">
                        <label for="amount">Amount</label>
                    </div>
                    <div class="input-container">
                        <select id="employees"name="soldBy" required>
                            <option value="" selected disabled>Sold by</option>
                            <?php echo $employeeOptions; ?>
                        </select>
                    </div>
                    <button type="submit" name="addRecordBtn">save record</button>
                </form>    
        </div>
    </div>
</body>
</html>


