<html>
<head>
<link rel="stylesheet" href="style.css">
<script type="text/javascript">
function CheckRequiredInput(val){
var elementInput = document.getElementById('X');
var classInput = document.getElementsByClassName('p');
 if(val=='q7'||val=='q8'||val=='q9'||val=='q10'||val=='q11'){
  switch(val){
  case "q7":
    classInput[0].style.display='block';
    classInput[1].style.display='none';
    classInput[2].style.display='none';
    break;
  case "q8":
  case "q9":
    classInput[1].style.display='block';
    classInput[0].style.display='none';
    classInput[2].style.display='none';
    break;
  case "q10":
  case "q11":
    classInput[2].style.display='block';
    classInput[0].style.display='none';
    classInput[1].style.display='none';
    // break;
  
    // classInput[3].style.display='block';
    // classInput[2].style.display='none';
    // classInput[0].style.display='none';
    // classInput[1].style.display='none';
    // break;
  }
  elementInput.style.display='block';
  elementInput.required='true';
 }
 else { 
  classInput[0].style.display='none';
  classInput[1].style.display='none';
  classInput[2].style.display='none';
  elementInput.style.display='none';
}
}

</script></head>
<body>
    <h1>Classic Models</h1>

<?php
include "db_connect.php";
?>
<style>
body{
  font-weight: 1000;
  text-align: justify;
}
h1{
  text-align: center;
}
p{
  display:none;
  background-color:transparent;
  border: none;
  /* padding: 0 1.5em 0 0; */
  padding: 1.5px 3px;
  margin: 0;
  width: 100%;
  font-family: inherit;
  color:white;
  font-size:medium;
  font-weight: 800;
  cursor: inherit;
  line-height: inherit;
  z-index: 1;
  outline: none;
}
</style>

<form action="/query.php" method="post">
<label for ="table">Show Table:</label><br>
<button class="button"  name="table" type="submit" value="customers">Customers</button>
<button class="button"  name="table" type="submit" value="orders">Orders</button>
<button class="button"  name="table" type="submit" value="orderdetails">Order Details</button>
<button class="button"  name="table" type="submit" value="products">Products</button>
<button class="button"  name="table" type="submit" value="productlines">Product Lines</button>
<button class="button"  name="table" type="submit" value="payments">Payments</button>
<button class="button"  name="table" type="submit" value="employees">Employees</button>
<button class="button"  name="table" type="submit" value="offices">Offices</button>
</form>

<form action="/query.php" method="post">
  <label for = "Queries">Choose a query:</label><br>
  <div class ="select">
  <select name = "query" id = "query" onchange='CheckRequiredInput(this.value);'>
    <option value="q1">Total revenue of regions order from low to high</option>
    <option value="q2">Product purchased by all customers</option>
    <option value="q3">Customers purchased at least one product in each of the product lines</option>
    <option value="q4">Assistants who assist all of the customers</option>
    <option value="q5">Products has the most quantity being sold</option>
    <option value="q6">Customer purchased the most quantity of all products</option>
    <option value="q7">Products have the most sales in regions 'X' (postal code), order from high to low</option>
    <option value="q8">Customer and amount they paid for a specific order (X)</option>
    <option value="q9">Customers name and all of the products they placed in a specific order (X)</option>
    <option value="q10">All products had been purchased by a customer (X) order by product name</option>
    <option value="q11">Product purchased the most (quantity) by a specific customer (X)</option>

  </select>
  <span class="focus"></span>
  
  <div class ="form-group">
  <span class="p">Enter Postal Code</span>
  <span class="p">Enter Order Number</span>
  <span class="p">Enter Customer Number</span>
  <input  class="form-field" type="text" name="X" id="X" style='display:none;'/>
  </div>
</div>
  <input type = "submit" value = "Submit">


</form>

<?php
// include "query.php";

$mysqli->close();

?>

</body>
</html>