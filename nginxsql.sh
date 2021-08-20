mq="xx";
 i="0";
 cnt=`redis-cli llen nginx`;

 while [[ -n $mq ]]
 do
  echo $i $data
 
  data=`redis-cli rpop nginx`
  ip_address=`echo $data | jq -r '.ip_address'`
  date=`echo $data | jq -r '.date'`
  method=`echo $data | jq -r '.method'`
  status_server=`echo $data | jq -r '.status_server'`
  ping_ms=`echo $data | jq -r '.ping_ms'`
  site_request=`echo $data | jq -r '.site_request'`
  rt=`echo $data | jq -r '.rt'`
  uct=`echo $data | jq -r '.uct'`
  uht=`echo $data | jq -r '.uht'`
  urt=`echo $data | jq -r '.urt'`
  gz=`echo $data | jq -r '.gz'`
  mysql -u ciel -psome_pass webcsv -s -N -e "INSERT INTO nginx (ip_address, date, method, status_server, ping_ms, site_request, rt, uct, uht, urt, gz) VALUES ('$ip_address','$date','$method','$status_server','$ping_ms','$site_request','$rt','$uct','$uht','$urt','$gz')";

if [[ $i == $cnt ]]; then
  break;
  fi

i=`expr $i + 1`
  done