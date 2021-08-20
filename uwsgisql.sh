mq="xx"
i="0"
cnt=`redis-cli llen uwsgi`

while [[ -n $mq ]]
do
 echo $i $data
 
 data=`redis-cli ''rpop uwsgi`
 address_space_usage=`echo $data | jq -r '.address_space_usage'`
 rss_usage=`echo $data | jq -r '.rss_usage'`
 pid=`echo $data | jq -r '.pid'`
 mysql -u ciel -psome_pass webcsv -s -N -e "insert into uwsgi (address_space_usage, rss_usage, pid) values ('$address_space_usage','$rss_usage','$pid')"
 
 if [[ $i == $cnt ]]; then
  break;
 fi

 i=`expr $i + 1`;
done