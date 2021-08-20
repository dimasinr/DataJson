<?php

include 'koneksi.php';

$fn = fopen("nginx.log","r");

 while(! feof($fn)) {
	 $result = fgets($fn);
	 $data = [];
	 $parsing = preg_match_all("/^(\S+) (\S+) (\S+) (\[\d+\/\S+\ \+\d+\]) (\"\S+\s+\S+\s+\S+\") (\d+\d+) (\d+\d+) (\"\S+\") (\S+) (\S+) (\S+) (\S+) (\S+)/",$result,$data);
	 $ip_address = $data[1][0] ?? "";
	 $date = $data[4][0] ?? "";
	 $method = $data[5][0] ?? "";
	 $status_server = $data[6][0] ?? "";
	 $ping_ms = $data[7][0] ?? "";
	 $site_request = $data[8][0] ?? "";
	 $rt = $data[9][0] ?? "";
	 $uct = $data[10][0] ?? "";
	 $uht = $data[11][0] ?? "";
	 $urt = $data[12][0] ?? "";
	 $gz = $data[13][0] ?? "";


	 // Insert Data Ke Mysql Langsung
	 echo "$ip_address $date $method $status_server $ping_ms $site_request $rt $uct $uht $urt $gz \n";
		 $query = "INSERT INTO nginx() VALUES ('$ip_address', '$date', '$method', '$status_server', '$ping_ms', '$site_request', '$rt', '$uct', '$uht', '$urt', '$gz')";
		 $conn->query($query);

	// Insert Data ke Redis
      $json = ["ip_address" => $ip_address, "date" => $date, "method" => $method, "status_server" => $status_server, "ping_ms" => $ping_ms, "site_request" => $site_request, "rt" => $rt, "uct" => $uct, "uht" => $uht, "urt" => $urt, "gz" => $gz];
      $json = json_encode($json);
      $redis = new Redis();
      $redis->connect('127.0.0.1', 6379);
      $redis->lPush("nginx",$json);
}

 fclose($fn);
?>