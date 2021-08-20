 <?php
include 'koneksi.php';

$fn = fopen("uwsgi.log","r");
 
 while(! feof($fn)) {
	 $result = fgets($fn);
	 $data = [];
	 $parsing = preg_match_all("/^(\S+\ \S+\ \S+\ \d+\ \w+\/\d+\w+\}) (\D+\w+ \w+\/\w+\}) (\S+ \w+\|\w+\: +\d+\S+\ \w+\/\w+\])/",$result,$data);
	 $address_space_usage = $data[1][0] ?? "";
	 $rss_usage = $data[2][0] ?? "";
	 $pid = $data[3][0] ?? "";

	 // Insert Data Json ke Mysql Langsung
	//  echo "$address_space_usage $rss_usage $pid \n";
	//  $query = "INSERT INTO uwsgi (address_space_usage, rss_usage, pid) VALUES ('$address_space_usage', '$rss_usage', '$pid')";
	//  echo $query."\n";
	//  $conn->query($query);	
		
	// Insert Data JSON ke Redis
 	 $jsonuwsgi = ["address_space_usage" => $address_space_usage, "rss_usage" => $rss_usage, "pid" => $pid,];
     $jsonuwsgi = json_encode($jsonuwsgi);
     $redis = new Redis();
     $redis->connect('127.0.0.1', 6379);
     $redis->lPush("uwsgi",$jsonuwsgi);

}

   fclose($fn);
?>

