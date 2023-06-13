<!DOCTYPE HTML>
<html><head><title>Current Bookings</title>

</head>
<script>
   xmlhttp=new XMLHttpRequest();
   xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {

      var bookings = JSON.parse(this.responseText);              
      var tbl = document.getElementById("tablebookings");
      
      //populate the table
      //bookings.length is the size of our array
      for (var i = 0; i < bookings.length; i++) {
         var roomname = bookings[i]['roomname'];
         var checkin = bookings[i]['checkinDate']
         var checkout = bookings[i]['checkoutDate']
         var firstname = bookings[i]['firstname'];
         var lastname = bookings[i]['lastname'];
         var bookingID = bookings[i]['bookingID']
      
         //concatenate our actions urls into a single string
         var urls  = '<a href="viewbooking.php?id='+bookingID+'">[view]</a>';
             urls += '<a href="editbooking.php?id='+bookingID+'">[edit]</a>';
             urls += '<a href="managereviews.php?id='+bookingID+'">[manage reviews]</a>';
             urls += '<a href="deletebooking.php?id='+bookingID+'">[delete]</a>';
         
         //create a table row with three cells  
         tr = tbl.insertRow(-1);
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = roomname + ', ' + checkin + ', ' + checkout; //booking room and dates
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = lastname + ', ' + firstname; //lastname and firstname     
         var tabCell = tr.insertCell(-1);
             tabCell.innerHTML = urls; //action URLS            
        }
    }
  }
  xmlhttp.open("GET","currentbookings.php");
  xmlhttp.send();
</script>

<body>
<?php 
session_start();
include 'checksession.php';

checkUser();
?>
<h1>Current Bookings</h1>
<h2><a href='makebooking.php'>[Make Booking]</a><a href="index.php">[Return to main page]</a>
</h2>

<table id="tablebookings" border="1">
<thead><tr><th>Booking (room,dates)</th><th>Customer</th><th>Action</th></tr></thead>

</table>
</body>
</html>
  