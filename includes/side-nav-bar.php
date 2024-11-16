<?php

$adminPhoto = $admin->getAdminPhoto($_SESSION['adminId']);

if ($adminPhoto->num_rows > 0) {

    while ($row = $adminPhoto->fetch_assoc()) {
        $adminPht = $row['image'];
    }
}
?>

<?php

if (isset($_POST['updatePhotoSubmitBtn'])) {
    
    if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $_FILES['photo']['tmp_name'];
        $destination = "./images/".$_FILES['photo']['name'];

        // copying file to the inmate-images folder
        if (move_uploaded_file($uploadFile, $destination)) {
            
            $photo = $destination;
            $adminId = $_SESSION['adminId'];

            $result = $admin->updateAdminPhoto($photo, $adminId);
            
            if ($result['success']) {
                echo '<script>alert("Photo has been added successfully")</script>';
            }
            else{
                echo '<script>alert("' .$result['error']. '")</script>';
            }

        }
    }
    else {
        echo '<script>alert("error!'. $_FILES['photo']['error']. '")</script>';
    }

}

?>




<div class="side-nav">
                <div class="logo">
                    <img src="<?php echo $adminPht; ?>" alt="profile picture">

                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="updatePhoto">update photo</label>
                        <input type="file" name="photo" id="updatePhoto">
                        <button type="submit" name="updatePhotoSubmitBtn" id="updatePhotoSubmitBtn"></button>
                    </form>
                    <!-- <form action="">
                        <input type="text" name="" id="" placeholder="update password">
                    </form> -->
                </div>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="employees.php">Employees</a></li>
                    <li><a href="recordSales.php">Record Sales</a></li>
                    <li><a href="recordExpenses.php">Record Expenses</a></li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        var path = window.location.pathname;
        var page = path.split("/").pop();
        var links = document.querySelectorAll(".side-nav ul li a");

        links.forEach(function(link) {
            if (link.getAttribute("href") === page) {
                link.classList.add("active");
            }
        });
    });





    let updatePhoto = document.querySelector("#updatePhoto");
    
    updatePhoto.addEventListener("change", function () {
        let updatePhotoSubmitBtn = document.querySelector("#updatePhotoSubmitBtn");
        if (this.files.length > 0) {
            updatePhotoSubmitBtn.click();
            // alert("heyyyyyyy");
        }
    });

</script>
