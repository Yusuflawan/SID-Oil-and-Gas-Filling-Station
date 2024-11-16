<?php
include "includes/header-div.php";
include 'Classes/Database.php';
include 'Classes/Admin.php';

$db_conn = new Database();
$db = $db_conn->connect();

$admin = new Admin($db);
?>



<?php include "includes/header.php"; ?>

    <div class="report-container">
        <div class="container">
            <?php include "includes/side-nav-bar.php" ?>
            <div class="report-contents">
                <div class="report-type">
                    <button type="button" class="first-button" data-dailySale="dailySales" onclick="report('dailySales')">Daily sales</button>
                    <button onclick="report('weeklySales')">Weekly sales</button>
                    <button onclick="report('monthlySales')">Monthly sales</button>

                    <button onclick="report('dailyExpenses')">Daily expenses</button>
                    <button onclick="report('weeklyExpenses')">Weekly expenses</button>
                    <button onclick="report('monthlyExpenses')">Monthly expenses</button>
                </div>
                <div id="all-transactions"></div>
            </div>
            
        </div>
        
    </div>

    
</body>


<script>
    function report(reportType){
        // create a new XMLHttpRequest request object
        var xhr = new XMLHttpRequest();

        // make a get request for the url
        xhr.open('GET', 'ganerateReport.php?type=' + reportType, true);

        // send the request over the netwoek
        xhr.send();

        // call back function
        xhr.onload = function(){
            if(xhr.status != 200){
                alert('Error ${xhr.status}: ${xhr.ststusText}');
            }
            else{ //show the report
                // window.print(document.getElementById("report-result").innerHTML = xhr.responseText);
                document.getElementById("all-transactions").innerHTML = xhr.responseText;
            }
        }

        xhr.oneerror = function (){
            alert("Request failed")
        }

    }
</script>


</html>