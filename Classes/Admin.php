<?php

class Admin{
    private $firstName;
    private $lastName;
    private $phone;
    private $email;    
    private $userName;
    private $password;
    private $conn;
    private $date;
    private $time;
    private $dateId;


    public function __construct($db){
        $this->conn = $db;
    }

    public function getAdmin(){
        $sql = "SELECT * FROM `admin`";
            $result = $this->conn->query($sql);
            return $result;      
    }

    public function getAdminPhoto($adminId){
        $sql = "SELECT `image` FROM `admin` WHERE `id` = $adminId";
            $result = $this->conn->query($sql);
            return $result;      
    }

    public function getEmployees(){
        $sql = "SELECT * FROM `employees`";
            $result = $this->conn->query($sql);
            return $result;      
    }

    public function getProducts(){
        $sql = "SELECT * FROM `products`";
            $result = $this->conn->query($sql);
            return $result;      
    }

    public function getExpenseCategory(){
        $sql = "SELECT * FROM `expenseCategory`";
            $result = $this->conn->query($sql);
            return $result;      
    }

    public function getRecentSalesTransaction(){
        $sql = "SELECT 
                    sales.id,
                    sales.date,
                    sales.amount,
                    products.productType,
                    employees.firstName,
                    employees.lastName
                FROM
                    `sales`
                JOIN
                    `products` ON products.id = sales.productType
                JOIN
                    employees ON employees.id = sales.soldBy
                ORDER BY
                    sales.id DESC
                LIMIT 6";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getDailySalesTransaction(){
        $sql = "SELECT 
                    sales.id,
                    sales.date,
                    sales.amount,
                    products.productType,
                    employees.firstName,
                    employees.lastName
                FROM
                    `sales`
                JOIN
                    `products` ON products.id = sales.productType
                JOIN
                    employees ON employees.id = sales.soldBy
                WHERE DATE(sales.date) = CURDATE()";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getWeeklySalesTransaction(){
        $sql = "SELECT 
                    sales.id,
                    sales.date,
                    sales.amount,
                    products.productType,
                    employees.firstName,
                    employees.lastName
                FROM
                    `sales`
                JOIN
                    `products` ON products.id = sales.productType
                JOIN
                    employees ON employees.id = sales.soldBy
                WHERE WEEK(sales.date) = WEEK(CURDATE())
                AND YEAR(sales.date) = YEAR(CURDATE())";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getMonthlySalesTransaction(){
        $sql = "SELECT 
                    sales.id,
                    sales.date,
                    sales.amount,
                    products.productType,
                    employees.firstName,
                    employees.lastName
                FROM
                    `sales`
                JOIN
                    `products` ON products.id = sales.productType
                JOIN
                    employees ON employees.id = sales.soldBy
                WHERE MONTH(sales.date) = MONTH(CURDATE())
                AND YEAR(sales.date) = YEAR(CURDATE())";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getDailyExpensesTransaction(){
        $sql = "SELECT 
                    expenses.id,
                    expenses.date,
                    expensecategory.category,
                    expenses.amount,
                    expenses.description,
                    admin.firstName,
                    admin.lastName
                FROM
                    `expenses`
                JOIN
                    `expensecategory` ON expensecategory.id = expenses.category
                JOIN
                    `admin` ON admin.id = expenses.recordedBy
                    WHERE DATE(expenses.date) = CURDATE()";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getWeeklyExpensesTransaction(){
        $sql = "SELECT 
                    expenses.id,
                    expenses.date,
                    expensecategory.category,
                    expenses.amount,
                    expenses.description,
                    admin.firstName,
                    admin.lastName
                FROM
                    `expenses`
                JOIN
                    `expensecategory` ON expensecategory.id = expenses.category
                JOIN
                    `admin` ON admin.id = expenses.recordedBy
                WHERE WEEK(expenses.date) = WEEK(CURDATE())
                AND YEAR(expenses.date) = YEAR(CURDATE())";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getMonthlyExpensesTransaction(){
        $sql = "SELECT 
                    expenses.id,
                    expenses.date,
                    expensecategory.category,
                    expenses.amount,
                    expenses.description,
                    admin.firstName,
                    admin.lastName
                FROM
                    `expenses`
                JOIN
                    `expensecategory` ON expensecategory.id = expenses.category
                JOIN
                    `admin` ON admin.id = expenses.recordedBy
                WHERE MONTH(expenses.date) = MONTH(CURDATE())
                AND YEAR(expenses.date) = YEAR(CURDATE())";

        $result = $this->conn->query($sql);
        return $result;      
    }

    public function getTodaysTotalPetrolSale(){
        $sql = "SELECT SUM(sales.amount) AS totalSales
                FROM sales
                JOIN products ON sales.productType = products.id
                WHERE products.productType = 'petrol' AND DATE(sales.date) = CURDATE()";

            $result = $this->conn->query($sql);
            return $result;      
    }

    public function getTodaysTotalGasSale(){
        $sql = "SELECT SUM(sales.amount) AS totalSales
                FROM sales
                JOIN products ON sales.productType = products.id
                WHERE products.productType = 'gas' AND DATE(sales.date) = CURDATE()";

            $result = $this->conn->query($sql);
            return $result;      
    }
    

    public function getTodaysTotalExpenses(){
        $sql = "SELECT SUM(expenses.amount) AS totalExpenses
                FROM expenses
                WHERE DATE(expenses.date) = CURDATE()";

            $result = $this->conn->query($sql);
            return $result;      
    }
    


    public function setEmployee($firstName, $lastName, $email, $phone, $date, $salary){

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->date = $date;
        $this->salary = $salary;

        $sql = "INSERT INTO employees(firstName, lastName, email, phone, dateEmployed, salary) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssssss", $this->firstName,  $this->lastName, $this->email, $this->phone, $this->date, $this->salary);
        $result = $stmt->execute();
        return $result;
        
    }
     
    public function deleteEmployee($employeeId){
        $sql = "DELETE FROM `employees` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
       

        // Check if the preparation of the statement was successful
        if (!$stmt) {
            error_log("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
            return [
                'success' => false,
                'error' => 'Failed to prepare the SQL statement.'
            ];
        }
        // Bind the parameters to the statement
        if (!$stmt->bind_param("s", $employeeId)) {
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to bind parameters.'
            ];
        }
        
        // Execute the statement
        if (!$stmt->execute()) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to execute the statement.'
            ];
        }
    
        // Close the statement
        $stmt->close();
    
        // Return success if all operations were successful
        return [
            'success' => true,
            'error' => null
        ];
    }

    public function editEmployee($firstName, $lastName, $email, $phone, $salary, $id){
        $sql = "UPDATE `employees` SET `firstName` = ?, `lastName` = ?, `email` = ?, `phone` = ?, `salary` = ? WHERE `id` = ?";

        $stmt = $this->conn->prepare($sql);

        // Check if the preparation of the statement was successful
        if (!$stmt) {
            error_log("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
            return [
                'success' => false,
                'error' => 'Failed to prepare the SQL statement.'
            ];
        }
        // Bind the parameters to the statement
        if (!$stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $salary, $id)) {
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to bind parameters.'
            ];
        }
        // Execute the statement
        if (!$stmt->execute()) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to execute the statement.'
            ];
        }
        
            // Close the statement
            $stmt->close();
        
            // Return success if all operations were successful
            return [
                'success' => true,
                'error' => null
            ];
    }
    

    public function recordSales($productType, $amount, $date, $soldBy, $recordedBy) {
        // Prepare the SQL statement
        $sql = "INSERT INTO `sales`(`productType`, `amount`, `date`, `soldBy`, `recordedBy`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
    
        // Check if the preparation of the statement was successful
        if (!$stmt) {
            error_log("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
            return [
                'success' => false,
                'error' => 'Failed to prepare the SQL statement.'
            ];
        }
    
        // Bind the parameters to the statement
        if (!$stmt->bind_param("issii", $productType, $amount, $date, $soldBy, $recordedBy)) {
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to bind parameters.'
            ];
        }
    
        // Execute the statement
        if (!$stmt->execute()) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to execute the statement.'
            ];
        }
    
        // Close the statement
        $stmt->close();
    
        // Return success if all operations were successful
        return [
            'success' => true,
            'error' => null
        ];
    }

    

    public function recordExpenses($date, $expenseCategory, $amount, $description, $recordedBy) {
        // Prepare the SQL statement
        $sql = "INSERT INTO `expenses`(`date`, `category`, `amount`, `description`, `recordedBy`) VALUES(?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
    
        // Check if the preparation of the statement was successful
        if (!$stmt) {
            error_log("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
            return [
                'success' => false,
                'error' => 'Failed to prepare the SQL statement.'
            ];
        }
    
        // Bind the parameters to the statement
        if (!$stmt->bind_param("sissi", $date, $expenseCategory, $amount, $description, $recordedBy)) {
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to bind parameters.'
            ];
        }
    
        // Execute the statement
        if (!$stmt->execute()) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to execute the statement.'
            ];
        }
    
        // Close the statement
        $stmt->close();
    
        // Return success if all operations were successful
        return [
            'success' => true,
            'error' => null
        ];
    }



    public function updateAdminPhoto($photo, $adminId) {
        $sql = "UPDATE `admin` SET `image` = ? WHERE `id` = ?";
    
        $stmt = $this->conn->prepare($sql);
    
        // Check if the preparation of the statement was successful
        if (!$stmt) {
            error_log("Prepare failed: (" . $this->conn->errno . ") " . $this->conn->error);
            return [
                'success' => false,
                'error' => 'Failed to prepare the SQL statement.'
            ];
        }
        // Bind the parameters to the statement
        if (!$stmt->bind_param("si",  $photo, $adminId)) {
            error_log("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to bind parameters.'
            ];
        }
        // Execute the statement
        if (!$stmt->execute()) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
            return [
                'success' => false,
                'error' => 'Failed to execute the statement.'
            ];
        }
        
            // Close the statement
            $stmt->close();
        
            // Return success if all operations were successful
            return [
                'success' => true,
                'error' => null
            ];
    }












}



