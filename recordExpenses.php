<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';
include "includes/header-div.php";

$db_conn = new Database();
$db = $db_conn->connect();

$admin = new Admin($db);

?>


<?php
    

if (isset($_POST['recordExpensesBtn'])) {
    $accountant = $_SESSION['adminId'];

    $date = $_POST['date'];
    $expenseCategory = $_POST['expenseCategory'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    // $CarryOutBy = $_POST['CarryOutBy'];
    $recordedBy = $accountant;
    
    $result = $admin->recordExpenses($date, $expenseCategory, $amount, $description, $recordedBy);
    
    if ($result['success']) {
        echo "<script>alert('Record has been added successfully');
                    window.location.href='recordExpenses.php'
                </script>";
    } else {
        echo "Error adding record: " . $result['error'];
    }

}

?>



<?php

$categoryResult = $admin->getExpenseCategory();

if ($categoryResult->num_rows > 0) {
    $categoryOptions = "";
    while ($row = $categoryResult->fetch_assoc()) {
        $categoryOptions .= '<option value="' . $row['id'] . '">'.$row['category'].'</option>';
    }
} else {
    $categoryOptions = '<option value="">No Expense category found</option>';
}

?>


<?php

// $employeeResult = $admin->getEmployees();

// if ($employeeResult->num_rows > 0) {
//     $employeeOptions = "";
//     while ($row = $employeeResult->fetch_assoc()) {
//         $employeeOptions .= '<option value="' . $row['id'] . '">'.$row['firstName']." ".$row['lastName'].'</option>';
//     }
// } else {
//     $employeeOptions = '<option value="">No employees found</option>';
// }

?>



<?php include "includes/header.php"; ?>

    <div class="expenses-form-container">
        <?php include "includes/side-nav-bar.php" ?>
        <div class="form">
            <form action="" method="post">
                <h2>Record Expenses</h2>
                <div class="input-container">
                    <input type="date" id="date" name="date" required placeholder="Date">
                    <label for="">Date</label>
                </div>
                <div class="input-container" id="productList">
                    <select name="expenseCategory" id="">
                        <option value="" selected disabled>Select expense category</option>
                        <?php echo $categoryOptions; ?>
                    </select>
                </div>
                <div class="input-container">
                    <input type="text" id="amount" name="amount" required placeholder="Amount">
                    <label for="">Amount</label>
                </div>
                <div class="input-container">
                    <input type="text" id="description" name="description" required placeholder="Description">
                    <label for="description">Description</label>
                </div>
                <button class="saveRecordBtn" type="submit" name="recordExpensesBtn">save record</button>
            </form>
        </div>
    </div>
</body>
</html>