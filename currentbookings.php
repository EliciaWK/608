<?php

include "config.php"; //load in any variables
$db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE) or die();


    $query = "SELECT roomname, checkinDate, checkoutDate, firstname, lastname, bookingID
    FROM booking, customer, room
    WHERE booking.customerID = customer.customerID and booking.roomID = room.roomID
    ";
    $result = mysqli_query($db_connection, $query);
    $rowcount = mysqli_num_rows($result); 
        //makes sure we have customers
    if ($rowcount > 0) {  
        $rows=[]; //start an empty array
        
        //append each row in the query result to our empty array until there are no more results                    
        while ($row = mysqli_fetch_assoc($result)) {            
            $rows[] = $row; 
        }
        //take the array of our 1 or more customers and turn it into a JSON text
        $searchresult = json_encode($rows);
        //this line is cruicial for the browser to understand what data is being sent
        header('Content-Type: text/json; charset=utf-8');
    } else echo "<tr><td colspan=3><h2>No Bookings found!</h2></td></tr>";

mysqli_free_result($result); //free any memory used by the query
mysqli_close($db_connection); //close the connection once done

echo  $searchresult;