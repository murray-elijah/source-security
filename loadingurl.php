<?php
require("config.php");
require("servers.php");

// Set image as display object.
$serverID = $serverList[$_GET["server"]]["id"];
$serverName = $serverList[$_GET["server"]]["name"];

// Gets the CommunityID, and converts to steamID.
$communityid = $_GET["steamid"];
$authserver = bcsub($communityid, '76561197960265728') & 1;
$authid = (bcsub($communityid, '76561197960265728') - $authserver) / 2;
$steamid = "STEAM_0:$authserver:$authid";

// Grabs the client's IP
$clientIP = $_SERVER['REMOTE_ADDR'];

// Loads the XML version of the given SteamID's profile and grabs their username.
$xml_steam = simplexml_load_file("http://steamcommunity.com/profiles/$communityid/?xml=1");
if (! empty($xml_steam)) {
    $sUsername = $xml_steam->steamID;
}

$locJoiner = ", ";

//Loads XML Location Tracking
$xml_loc = simplexml_load_file("http://ip-api.com/xml/".$clientIP);
if (! empty($xml_loc)) {
	$clientLocation = $xml_loc->city.$locJoiner.$xml_loc->regionName.$locJoiner.$xml_loc->country." (".$xml_loc->countryCode.")";
}

// Create connection
$conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO iptracer (steamID, userIP, steamUsername, serverID, userLocation)
VALUES ('" . $steamid . "', '" . $clientIP . "', '" . $sUsername . "', '" . $serverID . "', '" . $clientLocation . "')";

if ($conn->query($sql) === TRUE) {
$im = imagecreatefrompng("img/" . $serverID . ".png");

header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);
} else {
	echo mysqli_error($conn);
}

$conn->close();



?>
