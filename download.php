<?php

//name of file downloaded by end user
$namex = "files.zip";

//file name randomiser - edit rand function to match payloads available
$filename = "/var/www/html/payloads/p" . rand(1, 3) . ".zip";


//Check the file exists or not
if(file_exists($filename)) {
//Define header information
header('Content-Description: File Transfer');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Disposition: attachment; filename="'.basename($namex).'"');
header('Pragma: public');

//Clear system output buffer
flush();

//Read the size of the file
readfile($filename);
  
  //add to log
$log  = "IP: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "X-fwd: ".$_SERVER['HTTP_X_FORWARDED_FOR'].PHP_EOL.
                        "File Sent: ".$filename.PHP_EOL.PHP_EOL.
                                "-------------------------".PHP_EOL.PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('/var/log/nginx/payloads.log', $log, FILE_APPEND);


//Terminate from the script
die();
}
else{
echo "File does not exist.";
}

?>
