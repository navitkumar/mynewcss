<?php

$username = "";
$password = "";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");

//select a database to work with
$selected = mysql_select_db("test",$dbhandle)
  or die("Could not select examples");
  
if($selected){
	$ip = getRealIpAddr();
	$city = getCityfromIp($ip);
	$query = "insert into traceip (`IP_address`,`Created`,`Modified`) values ('".$ip."',now(),now())";
	echo mysql_query($query);
	if (!mysql_query($query)) {
	  echo 'inserted';
	}
	print_r($city);
	//mysql_close($dbhandle);
}


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function getCityfromIp($ip){

			/*Get user ip address*/
			//$ip_address=$_SERVER['REMOTE_ADDR'];

			/*Get user ip address details with geoplugin.net*/
			$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
			$addrDetailsArr = unserialize(file_get_contents($geopluginURL)); 

			/*Get City name by return array*/ 
			$city = $addrDetailsArr['geoplugin_city']; 

			/*Get Country name by return array*/ 
			$country = $addrDetailsArr['geoplugin_countryName'];

			/*Comment out these line to see all the posible details*/
			/*echo '<pre>'; 
			print_r($addrDetailsArr);
			die();*/

			if(!$city){
			   $city='Not Define'; 
			}if(!$country){
			   $country='Not Define'; 
			}
			echo '<strong>IP Address</strong>:- '.$ip.'<br/>';
			echo '<strong>City</strong>:- '.$city.'<br/>';
			echo '<strong>Country</strong>:- '.$country.'<br/>';

}