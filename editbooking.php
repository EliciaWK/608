<!DOCTYPE HTML>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<html><head><title>Edit Booking</title> </head>
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

$id = $_GET['id'];
$query = "SELECT roomID, checkinDate, checkoutDate, contactNumber, bookingExtra FROM booking WHERE bookingID = ".$id."";

$booking = mysqli_query($db_connection, $query);

$currentBooking = mysqli_fetch_assoc($booking);

//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {
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
        $query = "UPDATE booking SET roomID = $roomID, checkinDate = '$checkinDate', checkoutDATE = '$checkoutDate', contactNumber = '$contactNumber', bookingExtra = '$extras' WHERE bookingID = $id";
       
        mysqli_query($db_connection, $query);  
        echo "<h2>Booking Updated!</h2>";   
        $query = "SELECT roomID, checkinDate, checkoutDate, contactNumber, bookingExtra FROM booking WHERE bookingID = ".$id."";

        $booking = mysqli_query($db_connection, $query);

        $currentBooking = mysqli_fetch_assoc($booking);     
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
    mysqli_close($db_connection); //close the connection once done
}

$actionURL = "editbooking.php?id=$id";


?>
<h1>Edit booking</h1>
<h2><a href='listbookings.php'>[Return to the bookings listing]</a><a href='index.php'>[Return to the main page]</a></h2>
<form method="POST" action=<?php echo $actionURL?>>
  <p>
    <label for="room">Room (name, type, beds):</label>
    <select id="room" name="room" required>
    <?php

      //makes sure we have rooms
      if ($rowcount > 0) {  
          while ($row = mysqli_fetch_assoc($result)) { 
            
            $selected=$currentBooking['roomID'] == $row['roomID'] ?'selected':'';
            echo '<option '.$selected.' value='.$row['roomID'].'>'.$row['roomname'].', '.$row['roomtype'].', '.$row['beds'].'</option>';
        }
      }
      
      mysqli_free_result($result); //free any memory used by the query
      mysqli_close($db_connection); //close the connection once done
      ?>

    </select>   
  </p> 
  
  <p>
    <label for="checkinDate">Checkin date: </label>
      <input name="checkinDate" id="checkinDate" value="<?php echo $currentBooking["checkinDate"]?>" class="date">
  </p>
  <p>
    <label for="checkoutDate">Checkout date: </label>

      <input class="date" id="checkoutDate" name="checkoutDate" value="<?php echo $currentBooking["checkoutDate"]?>"  required>
  </p>
  <p>
    <label for="contactNumber">Contact number: </label>
    <input type="text" id="contactNumber" name="contactNumber" value="<?php echo $currentBooking["contactNumber"]?>" required> 
  </p>   
  <p>
    <label for="extras">Booking extras: </label>
    <input type="text" id="extras" name="extras" size="100" maxlength="150" value="<?php echo $currentBooking["bookingExtra"]?>"> 
  </p>    
  
   <input type="submit" name="submit" value="Update">
   <a href="listbookings.php">[Cancel]</a>
 </form>
<script src="https://cdn.jsdelivr.net/npm/flatpickr">
</script>
<script>
    flatpickr(".date", { enableTime: true,});
</script>
</body>
</html>