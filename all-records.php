<?php
    include_once "DBConnector.php";
    include_once "User.php";
    $con = new DBConnector;
    $res = User::readAll($con->conn);
?>
<html>
    <head>
        <title>All Records</title>
    </head>
    <body>
        <table align="center">
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>City</th>
            
                <?php
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["first_name"] . "</td>";
                            echo "<td>" . $row["last_name"] . "</td>";
                            echo "<td>" . $row["user_city"] . "</td>";
                            echo "</tr>";
                        }
                    }
                ?>
            
        </table>
    </body>
</html>