<!DOCTYPE HTML>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<html><head><title>Make Booking</title> </head>
<script>


function searchResult() {

  var startdate = document.getElementById("startdate-input").value
  var enddate = document.getElementById("enddate-input").value

  if (startdate == "" || enddate == "") {

  return;
  }

  xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
    
    
    if (this.responseText == "<tr><td colspan=4><h2>No Rooms found!</h2></td></tr>") {
      return;
    }
      var rooms = JSON.parse(this.responseText);              
      var tbl = document.getElementById("tblrooms"); //find the table in the HTML
      
      //clear any existing rows from any previous searches
      //if this is not cleared rows will just keep being added
      var rowCount = tbl.rows.length;
      for (var i = 1; i < rowCount; i++) {
         //delete from the top - row 0 is the table header we keep
         tbl.deleteRow(1); 
      }      
      
      //populate the table
      for (var i = 0; i < rooms.length; i++) {
         var roomID = rooms[i]['roomID'];
         var roomname    = rooms[i]['roomname'];
         var roomtype    = rooms[i]['roomtype'];
         var beds    = rooms[i]['beds'];
      
         tr = tbl.insertRow(-1);
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = roomID; 
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = roomname;   
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = roomtype;   
        var tabCell = tr.insertCell(-1);
          tabCell.innerHTML = beds;       
        }
    }
  }
  //call our php file that will look for a customer or customers matching the searchstring
  xmlhttp.open("GET","roomsearch.php?start="+startdate+"&end="+enddate,true);
  xmlhttp.send();
}
</script>
 <body>

<?php
session_start();
include 'checksession.php';
checkUser();

include "cleaninput.php";
include "config.php"; //load in any variables
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

$query = 'SELECT roomID, roomname, roomtype, beds FROM room';
$result = mysqli_query($db_connection, $query);
$rowcount = mysqli_num_rows($result); 

//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Add')) {
//if ($_SERVER["REQUEST_METHOD"] == "POST") { //alternative simpler POST test    
  include "config.php"; //load in any variables
  $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);
    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
        exit; //stop processing the page further
    };

//validate checkinDate
    $error = 0; //clear our error flag
    $msg = 'Error: ';
    if (isset($_POST['checkinDate']) and !empty($_POST['checkinDate']) and is_string($_POST['checkinDate'])) {
      $checkinDate = cleanInput($_POST['checkinDate']); 
             
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid Check in Date '; 
        $checkinDate = '';  
     } 

//checkoutDate
     if (isset($_POST['checkoutDate']) and !empty($_POST['checkoutDate']) and is_string($_POST['checkoutDate'])) {
      $checkoutDate = cleanInput($_POST['checkoutDate']); 
     if ($checkoutDate < $checkinDate) {
      $error++; //bump the error flag
      $msg .= 'Invalid, Check in date must be before Check out date '; 
       $checkoutDate = ''; 
     }
         
   } else {
      $error++; //bump the error flag
      $msg .= 'Invalid Check out Date '; 
       $checkoutDate = '';  
    } 
        
    //contactNumber Validation
    if (isset($_POST['contactNumber']) and !empty($_POST['contactNumber']) and is_string($_POST['contactNumber'])) {
      $contactNumber = cleanInput($_POST['contactNumber']); 
     if (!preg_match("/^[0-9]{2,3} [0-9]{3,4} [0-9]{3,4}$/", $contactNumber)){
      $error++; //bump the error flag
      $msg .= 'Invalid Contact Number, Must be of format ##(#) ###(#) ###(#) '; //append eror message
       $contactNumber = '';  
     } 
   } else {
      $error++; //bump the error flag
      $msg .= 'Invalid Contact Number '; //append eror message
       $contactNumber = '';  
    } 

 //bookingExtras Validation
    $fullExtras = cleanInput($_POST['extras']);
    $extras = (strlen($fullExtras)>150)?substr($fullExtras,1,150):$fullExtras; //check length and clip if too big



       $roomID = cleanInput($_POST['room']);
       $customerID =   $_SESSION['userid'];

       
       
//save the room data if the error flag is still clear
    if ($error == 0) {
        $query = "INSERT INTO booking (customerID, roomID, checkinDate, checkoutDate, contactNumber, bookingExtra) VALUES (".$customerID.",".$roomID.",'".$checkinDate."', '".$checkoutDate."','".$contactNumber."','".$extras."')";
       
        mysqli_query($db_connection, $query);  
        echo "<h2>Booking made successfully</h2>";        
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
    mysqli_close($db_connection); //close the connection once done
}


?>
<h1>Make a booking</h1>
<h2><a href='listbookings.php'>[Return to the bookings listing]</a><a href='index.php'>[Return to the main page]</a></h2>

<form method="POST" action="makebooking.php">
  <p>
    <label for="room">Room (name, type, beds):</label>
    <select id="room" name="room" required>
    <?php

      //makes sure we have rooms
      if ($rowcount > 0) {  
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value='.$row['roomID'].'>'.$row['roomname'].', '.$row['roomtype'].', '.$row['beds'].'</option>';
        }
      }

      mysqli_free_result($result); //free any memory used by the query
      mysqli_close($db_connection); //close the connection once done
      ?>

    </select>   
  </p> 
  <p>

    <label for="checkinDate">Checkin date: </label>
   <!-- <input type="date" id="checkinDate" name="checkinDate" required>  -->
   <input name="checkinDate" id="checkinDate" class="date"> 

    </input>

  </p>  
  <p>
    <label for="checkoutDate">Checkout date: </label>
    <input class="date" id="checkoutDate" name="checkoutDate" required> 
  </p> 
  <p>
    <label for="contactNumber">Contact number: </label>
    <input placeholder="##(#) ###(#) ###(#)"  type="text" id="contactNumber" name="contactNumber" required> 
  </p>   
  <p>
    <label for="extras">Booking extras: </label>
    <input type="text" id="extras" name="extras" size="100" maxlength="150"> 
  </p>   
  
   <input type="submit" name="submit" value="Add">
   <a href="listbookings.php">[Cancel]</a>
 </form>

 <h2>Search for room availability</h2>


<label>Start date:</label> <input class="date" id="startdate-input"></input> <label>End Date:</label> <input class="date" id="enddate-input"></input> <button onclick=searchResult()>Search availability</button>


<table border="1" id="tblrooms">
<thead><tr><th>Room #</th><th>Roomname</th><th>Room Type</th><th>Beds</th></tr></thead>
<script src="https://cdn.jsdelivr.net/npm/flatpickr">
</script>
<script>
  flatpickr(".date", { enableTime: true,});
</script>
</body>
</html>
  