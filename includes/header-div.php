<?php session_start(); ?>
<?php include "header.php"; ?>


<div class="header-div">
            <div class="username">
                
                <?php
                    echo "<p>".$_SESSION['role'].": ".$_SESSION['firstName']." ".$_SESSION['lastName']."</p>";
                ?>
            </div>
            <div class="company-name">
                <img src="images/Google_Icons-09-512.png" alt="company logo">
                <p>SID Petrol and Gas Nigeria Limited</p>
            </div>
        </div>