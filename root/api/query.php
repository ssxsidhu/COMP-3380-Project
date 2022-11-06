<head>  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='https://s3-us-west-2.amazonaws.com/s.cdpn.io/123941/rwd.table.min.css'>
<link rel="stylesheet" href="style2.css">
</head>


<?php
include "db_connect.php";
$sql=NULL;
if(filter_has_var(INPUT_POST,'table')){
$table_name = $_POST['table'];
$sql = "SELECT * from $table_name";
}
else if(filter_has_var(INPUT_POST,'query')){
$query_num = $_POST['query'];
if(filter_has_var(INPUT_POST,'X')){
$X = $_POST['X'];
mysqli_real_escape_string($mysqli, $X);
}
switch($query_num){
    case "q1": 
        $sql='SELECT country,city,postalCode,SUM(amount) as Total FROM payments 
        NATURAL join customers GROUP BY city,country,postalCode ORDER BY Total ASC';
        break;
    case "q2":
        $sql='SELECT productName from products 
        NATURAL JOIN customers C
        where C.customerNumber = ALL
        (SELECT customerNumber from customers)';
        break;
    case "q3":
        $sql='SELECT customerName FROM customers C
        WHERE NOT EXISTS
        (SELECT productLine FROM productlines EXCEPT
        SELECT productLine FROM products
        NATURAL JOIN orderdetails
        NATURAL JOIN orders O
        WHERE C.customerNumber = O.customerNumber)';
        break;
    case "q4":
        $sql='SELECT employeeNumber FROM employees E
        WHERE jobTitle = "Sales Rep" AND NOT EXISTS
        (SELECT customerNumber FROM customers EXCEPT
        SELECT customerNumber FROM customers  C WHERE E.employeeNumber = C.salesRepEmployeeNumber)';
        break;
    case "q5":
        $sql='SELECT productName, SUM(quantityOrdered) as num_sold FROM 
        products NATURAL JOIN orderdetails
        GROUP BY productName
        ORDER BY num_sold DESC';
        break;
    case "q6":
        $sql='SELECT customerName, SUM(quantityOrdered) as Quantity FROM customers 
        NATURAL JOIN orders NATURAL JOIN orderdetails  
        GROUP BY customerName 
        ORDER BY Quantity DESC';
        break;
    case "q7":
        $sql='SELECT productName, SUM(quantityOrdered) as num_sold FROM products
        NATURAL JOIN orders NATURAL JOIN orderdetails
        NATURAL JOIN customers 
        WHERE postalCode = '.$X.'	
        GROUP BY productName
        ORDER BY num_sold desc';
        break;
    
    case "q8":
        $sql='SELECT orderNumber, customerName, customerNumber, amount AS Paid FROM 
        orders NATURAL JOIN payments NATURAL JOIN  customers
        WHERE orderNumber = '.$X;
        break;
    case "q9":
        $sql='SELECT orderNumber, customerName, customerNumber, productName FROM 
        orders O 
        NATURAL JOIN payments  
        NATURAL JOIN orderdetails  
        NATURAL JOIN products
        NATURAL JOIN customers
        WHERE O.orderNumber = '.$X;
        break;
    case "q10":
        $sql='SELECT DISTINCT productName FROM products 
        natural join orders
        natural join customers
        where customerNumber= '.$X.'
        ORDER BY productName';
        break;
    case "q11":
        $sql='SELECT productName, SUM(quantityOrdered) as num_sold FROM products 
        natural join orders
        NATURAL JOIN orderdetails
        natural join customers
        where customerNumber = '.$X.'
        group by productName
        order by num_sold desc
        Limit 1';
        break;
}
}

echo '<a href="http://159.203.21.219/" class="button">Return to Main page</a>
 <form method="post" action="download.php" >
 <input type="submit" value="Export as CSV file" name="Export">' ;
if(!empty($sql))
$result = $mysqli->query($sql);

$col_arr = array();
$user_arr = array();


$i = 0;
echo '<style>
.table-bordered {
	border: 1px solid #ddd !important;
    font: 400 16px/1.5 exo, ubuntu, "segoe ui", helvetica, arial, sans-serif;
  }
th {
    text-align: center;
    background-color: #4287f5;
    color: white;
  }
</style>
<div class="container">
<div class="row">
<div class="col-xs-12">
<div class="table-responsive" data-pattern="priority-columns">
<table class="table table-bordered table-hover "><thead><tr>';
if(!empty($result)){
	while ($i < mysqli_num_fields($result))
	{
		$meta = mysqli_fetch_field($result);
        formatInput($meta->name);
		$i = $i + 1;
	}
	echo '</tr></thead>';

    collectParm(mysqli_num_fields($result),$col_arr);
	
    $i = 0;
    echo '<tbody>';
	while ($row = mysqli_fetch_row($result)) 
	{
		echo '<tr>';
		$count = count($row);
        collectParm($count,$row);
		$y = 0;
		while ($y < $count)
		{
			$c_row = current($row);
			echo '<td>' . $c_row . '</td>';
			next($row);
			$y = $y + 1;
		}
		echo '</tr>';
		$i = $i + 1;
	}

   echo '</tbody></table>
   </div>
   </div>
   </div>
   </div>';
   $serialize_user_arr = serialize($user_arr);
   echo '<textarea name="export_data" style="display: none;">';
   echo $serialize_user_arr; 
   echo '</textarea></form>';
   mysqli_free_result($result);
}

function collectParm($num,$row){
    global $user_arr;
    switch($num){
        case 1:
            $user_arr[]=array($row[0]);
            break; 
        case 2:
            $user_arr[]=array($row[0],$row[1]);
            break; 
        case 3:
            $user_arr[]=array($row[0],$row[1],$row[2]);
            break; 
        case 4:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3]);
            break; 
        case 5:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4]);
            break; 
        case 6:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
            break; 
        case 7:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6]);
            break; 
        case 8:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);
            break; 
        case 9:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
            break; 
        case 10:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9]);
            break; 
        case 11:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10]);
            break; 
        case 12:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11]);
            break; 
        case 13:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12]);
            break; 
        case 14:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13]);
            break; 
        case 15:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            break; 
        case 16:
            $user_arr[]=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14],$row[15]);
            break; 
        }
}


function formatInput($title){
    global $col_arr;
    switch ($title){
        case "customerNumber":
            echo '<th>Customer Number</th>';
            $col_arr[] = 'Customer Number';
            break;
        case "customerName":
            echo '<th>Customer Name</th>';
            $col_arr[] = 'Customer Name';
            break;
        case "contactLastName":
            echo '<th>Last Name</th>';
            $col_arr[] = 'Last Name';
            break;
        case "contactFirstName":
            echo '<th>First Name</th>';
            $col_arr[] = 'First Name';
            break;
        case "phone":
            echo '<th>Phone</th>';
            $col_arr[] = 'Phone';
            break;
        case "addressLine1":
            echo '<th>Address Line 1</th>';
            $col_arr[] = 'Address Line 1';
            break;
        case "addressLine2":
            echo '<th>Address Line 2</th>';
            $col_arr[] = 'Address Line 2';
            break;
        case "city":
            echo '<th>City</th>';
            $col_arr[] = 'City';
            break;
        case "state":
            echo '<th>State</th>';
            $col_arr[] = 'State';
            break;
        case "postalCode":
            echo '<th>Postal Code</th>';
            $col_arr[] = 'Postal Code';
            break;
        case "country":
            echo '<th>Country</th>';
            $col_arr[] = 'Country';
            break;
        case "salesRepEmployeeNumber":
            echo '<th>Sales Rep Employee Number</th>';
            $col_arr[] = 'Sales Rep Employee Number';
            break;
        case "creditLimit":
            echo '<th>Credit Limit</th>';
            $col_arr[] = 'Credit Limit';
            break;
        case "orderNumber":
            echo '<th>Order Number</th>';
            $col_arr[] = 'Order Number';
            break;
        case "orderDate":
            echo '<th>Order Date</th>';
            $col_arr[] = 'Order Date';
            break;
        case "requiredDate":
            echo '<th>Required Date</th>';
            $col_arr[] = 'Required Date';
            break;
        case "shippedDate":
            echo '<th>Shipped Date</th>';
            $col_arr[] = 'Shipped Date';
            break;
        case "status":
            echo '<th>Status</th>';
            $col_arr[] = 'Status';
            break;
        case "comments":
            echo '<th>Comments</th>';
            $col_arr[] = 'Comments';
            break;
        case "productCode":
            echo '<th>Product Code</th>';
            $col_arr[] = 'Product Code';
            break;
        case "quantityOrdered":
            echo '<th>Quantity Ordered</th>';
            $col_arr[] = 'Quantity Ordered';
            break;
        case "priceEach":
            echo '<th>Price Each</th>';
            $col_arr[] = 'Price Each';
            break;
        case "orderLineNumber":
            echo '<th>Order Line Number</th>';
            $col_arr[] = 'Order Line Number';
            break;
        case "productName":
            echo '<th>Product Name</th>';
            $col_arr[] = 'Product Name';
            break;
        case "productScale":
            echo '<th>Product Scale</th>';
            $col_arr[] = 'Product Scale';
            break;
        case "productLine":
            echo '<th>Product Line</th>';
            $col_arr[] = 'Product Line';
            break;
        case "productVendor":
            echo '<th>Product Vendor</th>';
            $col_arr[] = 'Product Vendor';
            break;
        case "productDescription":
            echo '<th>Product Description</th>';
            $col_arr[] = 'Product Description';
            break;
        case "quantityInStock":
            echo '<th>Quantity In Stock</th>';
            $col_arr[] = 'Quantity In Stock';
            break;
        case "buyPrice":
            echo '<th>Buy Price</th>';
            $col_arr[] = 'Buy Price';
            break;
        case "textDescription":
            echo '<th>Text Description</th>';
            $col_arr[] = 'Text Description';
            break;
        case "htmlDescription":
            echo '<th>Html Description</th>';
            $col_arr[] = 'Html Description';
            break;
        case "image":
            echo '<th>Image</th>';
            $col_arr[] = 'Image';
            break;
        case "checkNumber":
            echo '<th>Check Number</th>';
            $col_arr[] = 'Check Number';
            break;
        case "paymentDate":
            echo '<th>Payment Date</th>';
            $col_arr[] = 'Payment Date';
            break;
        case "amount":
            echo '<th>Amount</th>';
            $col_arr[] = 'Amount';
            break;
        case "employeeNumber":
            echo '<th>Employee Number</th>';
            $col_arr[] = 'Employee Number';
            break;
        case "lastName":
            echo '<th>Last Name</th>';
            $col_arr[] = 'Last Name';
            break;
        case "firstName":
            echo '<th>First Name</th>';
            $col_arr[] = 'First Name';
            break;
        case "extension":
            echo '<th>Extension</th>';
            $col_arr[] = 'Extension';
            break;
        case "email":
            echo '<th>Email</th>';
            $col_arr[] = 'Email';
            break;
        case "officeCode":
            echo '<th>Office Code</th>';
            $col_arr[] = 'Office Code';
            break;
        case "reportsTo":
            echo '<th>Reports To</th>';
            $col_arr[] = 'Reports To';
            break;
        case "jobTitle":
            echo '<th>Job Title</th>';
            $col_arr[] = 'Job Title';
            break;
        case "territory":
            echo '<th>Territory</th>';
            $col_arr[] = 'Territory';
            break;
        case "num_sold":
            echo '<th>Quantity Sold</th>';
            $col_arr[] = 'Quantity Sold';
            break;
        default :
        echo '<th>' . $title . '</th>';
        $col_arr[] = $title ;

    }
}





// echo "<h2>Customer Names</h2>"; 
// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "Postal Code".$row["postalCode"]."Total Payment".$row["TotalPayment"]."<br>";
//   }
// } else {
//   echo "0 results";
// }


// echo '<table>
//     <tr>
//         <th>Postal Code</th>
//         <th>Total Payment</th>
//     </tr>';

// while ($row = $result->fetch_assoc()) {
//     echo '
//         <tr>
//             <td>'.$row['postalCode'].'</td>
//             <td>'.$row['TotalPayment'].'</td>
//         </tr>';

// }

// echo '
// </table>';


// while ($row = $result->fetch_row()) {
//     echo "{$row[1]}";
// }


// table {
//     width: 100%;
//   }
//   table td {
//     white-space: nowrap;
//   }
//   table td:last-child {
//     width: 100%;
//   }

?>



