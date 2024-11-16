<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';


$db_conn = new Database();
$db = $db_conn->connect();

$admin = new Admin($db);
// $empId = "";

$result = $admin->getEmployees();

if ($result->num_rows > 0) {  
    $employees = "";   
    $index = 1;
    while ($row = $result->fetch_assoc()) {
        
        $id = "";
        $firstName = "";
        $lastName = "";
        $email = "";
        $phone = "";
        $dateEmployed = "";

        $employees.= '<tr>
                        <td>' .$index.'</td>
                        <td>' .$row['firstName'].'</td>
                        <td>' .$row['lastName'].'</td>
                        <td>' .$row['email'].'</td>
                        <td>' .$row['phone'].'</td>
                        <td>' .$row['dateEmployed'].'</td>
                        <td>' .$row['salary'].'</td>
                        <td class="employeeAction">
                            <form method="post">
                                <button type="button" class="editBtn" data-id="'. $row['id'] .'" onclick="handleEdit(this)">Edit Info</button>
                                <button type="button" id="deleteBtn" class="deleteBtn" data-id="'. $row['id'] .'" onclick="deleteEmployee(this)">Delete</button>
                            </form>                            
                        </td>
                    </tr>';
        $index++;

    }   
    
}
else{
    echo "<p>Ooh, no employee available yet!</p>";
}

?>


<?php

if (isset($_POST['addEmployeetBtn'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $date = date('m-d-Y'); 

    $result = $admin->setEmployee($firstName, $lastName, $email, $phone, $date, $salary);

    if ($result === true) {
        echo "<script>alert('employee added successfully');
                    window.location.href='employees.php'
                </script>";
        
    }


}

?>




<?php

    if (isset($_GET['editEmployeeBtn'])) {
            
        $empId = $_GET['empId']; // Retrieve the empId from the form

        $newFirstName = $_GET['newFirstName'];
        $newLastName = $_GET['newLastName'];
        $newEmail = $_GET['newEmail'];
        $newPhone = $_GET['newPhone'];
        $newSalary = $_GET['newSalary'];
    
        $result = $admin->editEmployee($newFirstName, $newLastName, $newEmail, $newPhone, $newSalary, $empId);
    
        if ($result['success']) {
            echo "<script>alert('employee information have been updated successfully');
                    window.location.href='employees.php'
                </script>";
        }
        else{
            echo $result['error'];
        }

    }
?>








<?php
//Handle AJAX request for deleting employee
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function deleteEmployee($admin, $employeeId){
        $result = $admin->deleteEmployee($employeeId);
        return $result;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);

    $response ="";

    if ($data && isset($data['employeeId'])) {
        $employeeId = $data['employeeId'];

        $result = deleteEmployee($admin, $employeeId);

        if ($result) {
            $response = ['success' => true, 'message' => "The employee has been deleted successfully"];
        }
        else{
            $response = ['success' => false, 'message' => "Fail to delete employee: $result"];
        }
        
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
   echo json_encode($response);

   exit();
}


?>



<?php include "includes/header.php"; ?>
<?php include "includes/header-div.php"; ?>


<div class="employee">
    <?php include "includes/side-nav-bar.php"; ?>

    <div class="employee-contents">
        <div class="add-emp">
            <h3>Employees</h3>
            <div class="add-employee-btn">
                <button onclick="displayEmployeeForm()">Add Employee</button>
            </div>
        </div>
        <table>
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date Employed</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($employees)){echo $employees;}  ?>
                </tbody>
        </table>
        
        <?php include "includes/addEmployee.php";?>
        <?php include "includes/editEmployee.php";?>

    </div>
</div>

    
</body>

<script>

    function displayEmployeeForm(){
        let addEmployee = document.querySelector(".add-employee");

        if (addEmployee.style.display === 'none' || '') {
            addEmployee.style.display = 'block';    
        }
        else{
            addEmployee.style.display = 'block';    
        }
    }

    function hideEmployeeForm(){
        let addEmployee = document.querySelector(".add-employee");

        if (addEmployee.style.display === 'block') {
            addEmployee.style.display = 'none';    
        }
        else{
            addEmployee.style.display === 'block';    
        }
    }
    
    function displayEditForm(){
        // console.log(e);
        // let empId = e.dataset.id;
        // console.log(employeeId);
        let editEmployee = document.querySelector(".edit-employee");

        if (editEmployee.style.display === 'none' || '') {
            editEmployee.style.display = 'block';

            // handleEdit(empId);  
        }
        else{
            editEmployee.style.display = 'block';    
        }
    }
    
    function hideEditEmployeeForm(){
        // console.log("cancel is clicked");
        let editEmployee = document.querySelector(".edit-employee");

        if (editEmployee.style.display === 'block') {
            editEmployee.style.display = 'none';    
        }
        else{
            editEmployee.style.display === 'block';    
        }
    }

    

    
async function handleEdit(e) {

    let empId = e.dataset.id;

    document.getElementById('empId').value = empId;

    displayEditForm();

}


  

async function deleteEmployee(e) {
    let employeeId = e.dataset.id;
    // alert(employeeId);
    const confirmation = confirm("Are you sure you want to delete this employee?");

    if (confirmation) {
        try{
            const response = await fetch('employees.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ employeeId: employeeId })
            });
            const data = await response.json();
            if (data.success) {
                alert(data.message);
                window.location.reload();
            }
            else{
                alert("Failed to delete employee: " + data.message);
            }
        }
        catch (error) {
            console.error("Error: ", error);
            alert("An error occur while deleting the employee");
        }
    }
}


</script>
</html>



   











