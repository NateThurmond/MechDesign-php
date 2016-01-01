<?php

    include("php_Global_Vars_and_DB_Conn.php");

    $query = "SELECT * FROM mechs NATURAL JOIN mechengine";
    $data = mysqli_query($conn, $query);
    
    
    echo "<table class='mechPickTable' border='1'>
        <tr>
        <th>Mech Name</th>
        <th>Armor</th>
        <th>Movement</th>
        <th>Tonnage</th>
        <th>Intro Date</th>
        </tr>";

        while($row = mysqli_fetch_array($data)) {

            echo "<tr>";
            echo "<td id='mechPickLink' >" . "<a href='mechDesign.php?mechIDPassed=" . $row['mechID'] . "'>" .  $row['mechName'] . "</a> </td>";
            echo "<td>" . $row['armor'] . "</td>";
            echo "<td>" . $row['mechWalk'] . " / " . $row['mechRun'] . " / " . $row['mechJump'] . "</td>";
            echo "<td>" . $row['maxTonnage'] . "</td>";
            echo "<td>" . $row['introDate'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

    $conn->close();