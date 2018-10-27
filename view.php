<!DOCTYPE html>
<head>
<title>IP Tracer</title>
<link rel="stylesheet" href="table.css">
</head>

<body>
<?php
	require("servers.php");
	require("config.php");

	$serverID = $serverList[$_GET["server"]]["id"];
	$serverName = $serverList[$_GET["server"]]["name"];
?>
<h1 style="margin-left:auto;margin-right:auto;"><?php echo "IP Tracer Results for ".$serverName; ?></h1>
<?php

$conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);

if ($conn->connect_error) {
	die($conn->connect_error);
}

$sql  = "select time, steamUsername, steamID, userIP, userLocation from iptracer where serverID = \"".$serverID."\" order by time DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table border=1 style=\"width: 85%;margin-left: auto;margin-right: auto;\">";
	echo "<tr>";
	echo "<th>Timestamp</th>";
	echo "<th>Username</th>";
	echo "<th>SteamID</th>";
	echo "<th>IP Address</th>";
	echo "<th>Reported Location</th>";
	echo "</tr>";
	while($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>".$row["time"]."</td>";
		echo "<td>".$row["steamUsername"]."</td>";
		echo "<td>".$row["steamID"]."</td>";
		echo "<td>".$row["userIP"]."</td>";
		echo "<td>".$row["userLocation"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
	echo "<p>0 results.</p>";
}
$conn->close();
?>

<footer>
<p>Please note, all times are in London time (GMT/BST).<p>
</footer>
</body>
</html>
