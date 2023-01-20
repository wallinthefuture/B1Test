<?php

include_once "config/database.php";
$database = new Database();
$db = $database->getConnection();

$query = "SELECT
        last_name, name, second_name, email, mobile_phone, phone 
    FROM
        users_info
    ";
$result = $db->prepare($query);
$result->execute();

$out = '<head>
  
    <link rel="stylesheet" href="css/style.css"/>
</head><body>
<table cellSpacing="2" cellPadding="6" align="center" border="1">
        <tr>
            <td colspan="6">
                <h3 align="center">Information about users</h3>
            </td>
        </tr>
        <tr>
            <td align="center">Last Name</td>
            <td align="center">Name</td>
            <td align="center">Second Name</td>
            <td align="center">Email</td>
            <td align="center">Mobile Phone</td>
            <td align="center">Phone</td>
        </tr>';
while ($row = $result->fetch()) {
    $out .= "
            <tr>
                <td align='center'>  " . $row['last_name'] . "</td>
                <td align='center'>  " . $row['name'] . "</td>
                <td align='center'>  " . $row['second_name'] . "</td>
                <td align='center'>  " . $row['email'] . "</td>
                <td align='center'>  " . $row['mobile_phone'] . "</td>
                <td align='center'>  " . $row['phone'] . "</td>
               
            </tr>";
}
$out .= "</table>
<p><a class='btn' href='index.php'>Back</a></p></body>";
echo($out);

