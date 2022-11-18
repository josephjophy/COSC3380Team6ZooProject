<!DOCTYPE html>
<html lang = "en">
    <head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "revenuereport.css">
</head>


<body id = "revenuereport">

<form id = "revenue-report-form" method="post" action="financialanalytics.php" >
    <div style="max-width: 400px;">
    </div>
    <div style="padding-bottom: 18px;">Revenue Streams<br/>
    <select id="data_1" name="report_type" style="max-width : 600px;" class="form-control">
    <option>Restaurant Sales</option>
    <option>Gift Shop Sales </option>
    <option>Ticket Sales</option>
    </select>
    </div>
    <div style="padding-bottom: 18px;">
    <input value="Generate Report" name = "generaterevenuereport" type="submit"/></div>
    </form>

    
    <form id = "expense-report-form" method="post" action="financialanalytics.php" >
    <div style="max-width: 400px;">
    </div>
    <div style="padding-bottom: 18px;">Expenses<br/>
    <select id="data_1" name="report_type" style="max-width : 600px;" class="form-control">
    <option>Employee Salaries</option>
    <option>Gift Shop Operation Costs</option>
    <option>Restaurant Operation Costs</option>
    <option>Ticket Booth Operation Costs</option>
    </select>
    </div>
    <div style="padding-bottom: 18px;">
    <input value="Generate Report" name = "generateexpensesreport" type="submit"/></div>
    </form>

    <form id = "profit-report-form" method="post" action="financialanalytics.php">
    <div style="max-width: 400px;">
    </div>
    <div style="padding-bottom: 18px;">Total Profit<br/>
    <input value="Generate Report" name = "generateprofitreport" type="submit"/></div>
</form>


<body>


<?php
$conn = mysqli_connect('team6awsdb.cethcqcyjpsc.us-east-1.rds.amazonaws.com', 'admin', 'team6database', 'README_RECOVER_DATABASES2');
if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
  }

  if (isset($_POST['generaterevenuereport'])){

       $report_type = $_POST['report_type'];

       if ($report_type == 'Restaurant Sales'){
        $query = 
        "SELECT Restaurant_Item_Name, R_Name,WhenRItemSold,R_Item_Price
        FROM RESTAURANT,RESTAURANT_INVENTORY, SELLS_REST_ITEM
        WHERE SELLS_REST_ITEM.R_ID = RESTAURANT_INVENTORY.RestaurantID
        AND RESTAURANT_INVENTORY.RestaurantID = RESTAURANT.RestaurantID";

        $restaurantsalesreport = $conn->query($query);

        if ($restaurantsalesreport->num_rows > 0){
        echo "<div>".$report_type."</div>";
        echo "<center><table>";
        echo "<tr><th>Item Order</th><th>Restaurant</th><th>Date Ordered</th><th>Price</th></tr>";
        while($row = $restaurantsalesreport->fetch_assoc()){
            echo "<tr><td>".$row['Restaurant_Item_Name'] . "</td><td> ".$row["R_Name"]."</td><td>".$row["WhenRItemSold"]."</td><td>$".$row["R_Item_Price"]."</tr></td>";
        }
        echo "</table></center>";
    }  
       }

      else if ($report_type == 'Gift Shop Sales'){
        echo "hello";
        $query =
        "SELECT GiftShop_Item_Name,GiftShop_Name,WhenGItemSold,G_Item_Price
        FROM GIFTSHOP, GIFTSHOP_INVENTORY, SELLS_GIFTSHOP_ITEM
        WHERE SELLS_GIFTSHOP_ITEM.Giftshop_ID = GIFTSHOP_INVENTORY.GiftShopID
        AND GIFTSHOP_INVENTORY.GiftShopID = GIFTSHOP.GiftShopID";

        $giftshopsalesreport = $conn->query($query);
         
        if ($giftshopsalesreport->num_rows > 0){
            echo "<center><div>".$report_type."</div>";
            echo "<table>";
            echo "<tr><th>Item Purchased</th><th>GiftShop</th><th>Date Purchased</th><th>Price</th></tr>";
            while ($row = $giftshopsalesreport->fetch_assoc()){
            echo  "<tr><td>".$row['GiftShop_Item_Name']."</td><td>".$row["GiftShop_Name"]."</td><td>".$row["WhenGItemSold"]."</td><td>"."$".$row["G_Item_Price"]. "</tr></td>";
            }
        }
        echo "</table></center>";

       }

    else if ($report_type == 'Ticket Sales'){
         $query = 
         "SELECT TCustomerEmail, Type, Price, WhenTicketSold FROM SELLS_TICKET";
         $ticketsalesreport = $conn->query($query);

         if ($ticketsalesreport->num_rows > 0){
            echo "<div>".$report_type."</div>";
            echo "<center><table>";
            echo "<tr> <th>Email</th>  <th>Type</th> <th>Price</th>  <th>Date Sold</th> </tr>";
            while($row = $ticketsalesreport->fetch_assoc()){
                echo "<tr><td>".$row["TCustomerEmail"]."</td><td>".$row["Type"]. "</td><td>".$row["WhenTicketSold"]."</td><td>"."$".$row['Price']."</tr></td>";
            }
         }
         echo "</table></center>";

       }

       else{
        echo "Table does not exist";
       }
       exit();
  }


  if (isset($_POST['generateexpensesreport'])){
    $report_type = $_POST['report_type'];
if ($report_type == "Employee Salaries"){
        $query = 
        "SELECT E_FNAME,E_LNAME, Dept_Name, E_Salary
        FROM EMPLOYEE,DEPARTMENT WHERE EMPLOYEE.E_DEPTID = DEPARTMENT.Dept_ID ";

        $employeesalaryreport = $conn->query($query);
        if ($employeesalaryreport->num_rows > 0){
        echo "<div>".$report_type."</div>";
        echo "<center><table>";
        echo "<tr><th>First Name </th> <th>  Last Name </th>  <th>Department Name </th>  <th>Employee Salary</th></tr>";
        while ($row = $employeesalaryreport->fetch_assoc()){
            echo "<tr><td>".$row['E_FNAME']."</td><td>".$row['E_LNAME']."</td><td>".$row['Dept_Name']."</td><td>"."$".$row['E_Salary']."</tr></td>";
        }
        echo "</table></center>";
    }
}


else if ($report_type == "Gift Shop Operation Costs"){
         $query = 
        "SELECT Giftshop_Name, GShop_Operation_Cost 
        FROM GIFTSHOP";

    $giftshopsalesreport = $conn->query($query);

    if ($giftshopsalesreport->num_rows > 0){
        echo "<div>".$report_type."</div>";
        echo "<center><table>";
        echo "<tr><th>Giftshop</th><th>Operation Costs</th></tr>";
        while ($row = $giftshopsalesreport->fetch_assoc()){
           echo "<tr><td>".$row['Giftshop_Name']."</td><td>"."$".$row["GShop_Operation_Cost"]. "</tr></td>";
        }
        echo "</table></center>";
    }
}


else if ($report_type == "Restaurant Operation Costs"){
    $query = 
            "SELECT R_Name, R_OperationCost 
            FROM RESTAURANT";
    
            $restaurantoperationcostsreport = $conn->query($query);
    
    if ($restaurantoperationcostsreport->num_rows > 0){
            echo "<div>".$report_type."</div>";
            echo "<center><table>";
            echo "<tr><th>Restaurant</th><th>Operation Costs</th></tr>";
    while ($row = $restaurantoperationcostsreport->fetch_assoc()){
               echo "<tr><td>".$row['R_Name']."</td><td>"."$".$row["R_OperationCost"]. "</tr></td>";
            }
            echo "</table></center>";
         }
    }

    else if ($report_type == "Ticket Booth Operation Costs"){
            $query = 
            "SELECT TBooth_Dept_ID, Ticket_Operation_Cost
            FROM TICKETBOOTH";
        
            $ticketboothoperationcostsreport = $conn->query($query);
        
            if ($ticketboothoperationcostsreport->num_rows > 0){
            echo "<div>".$report_type."</div>";
            echo "<center><table>";
            echo "<tr><th>Ticket Booth ID</th> <th>Operation Costs</th></tr>";
            while ($row = $ticketboothoperationcostsreport->fetch_assoc()){
            echo "<tr><td>".$row['TBooth_Dept_ID']."</td><td>"."$".$row["Ticket_Operation_Cost"]. "</tr></td>";
            }
            echo "</table></center>";
            }
    }

  }

  

  if (isset($_POST['generateprofitreport'])){

}




?>

</html>