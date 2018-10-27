# source-security
A security implementation for source engine servers.

The system runs off of PHP, and is easily configurable.

To set it up, you need to add 2 files:

## config.php
  In this, you need to add the MySQL connection variables `$sql_servername`, `$sql_username`, `$sql_password` and `$sql_dbname`.

## servers.php
  In this, you need to declare a two-dimentional PHP array in the form 
  ```
  "KEY" => array("name" => "NAME", "id" => "ID")
  ```.
  
  (Replace `KEY` with the server key, `NAME` with the readable server name, and `ID` with a short ID for the server.)
