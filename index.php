<?php

include 'Classes/Database.php';
include 'Classes/Admin.php';

$db_conn = new Database();
$db = $db_conn->connect();

$Admin = new Admin($db);


if (isset($_POST['submitBtn'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("location: index.php?error=emptyfields&username=".$username);
        exit();
    }
    else{
        $result = $Admin->getAdmin();

        $loginSuccessful = false;

        if ($result->num_rows > 0) {        
            while ($row = $result->fetch_assoc()) {
                if ($row['username'] === $username && $row['password']  === $password) {
                    session_start();
                    $_SESSION['adminId'] = $row['id'];
                    $_SESSION['firstName'] = $row['firstName'];
                    $_SESSION['lastName'] = $row['lastName'];
                    $_SESSION['role'] = $row['role'];

                    
                    $loginSuccessful = true;
                    break;
                }
                
            }
            if (!$loginSuccessful) {
                header("location: index.php?error=unauthoriseduser");
            }
            else{
                header("location: dashboard.php");
            }
        }
        else{
            header("location: index.php?error=emptyadmintable");
        }

    }
    // mysqli_stmt_close($stmt);
    mysqli_close($db);

}


?>



<?php include "includes/header.php"; ?>
<div class="body">
<div class="login-form-container">
        <form action="" method="post">
            <h2>Admin Login</h2>
            <?php 
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "emptyfields") {
                        echo "<p class='error-message'>Fill in all fields</p>";
                    }
                    elseif ($_GET['error'] == "unauthoriseduser"){
                        echo "<p class='error-message'>Unauthorized user</p>";
                    }
                    elseif ($_GET['error'] == "emptyadmintable"){
                        echo "<p class='error-message'>Admin Table is Empty</p>";
                    }
                }
            ?>
            <div class="errorMsg"></div>
            <div class="input-container">
                <input type="text" name="username" id="username" placeholder="username">
                <label for="username">username</label>
            </div>
            <div class="input-container">
                <input type="password" name="password" id="password" placeholder="password">
                <label for="password">password</label>
            </div>
            <button type="submit" name="submitBtn">login</button>
        </form>
    </div>
</div>
</body>

<!-- <script>
    
    function preventBack(){
        window.history.forward();
    }
    setTimeout("preventBack()", 0);
    window.onload = function (){
        null
    };
    
</script> -->


<script type="text/javascript">
    function preventBack() {
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    }

    window.onload = preventBack;
</script>


</html>
