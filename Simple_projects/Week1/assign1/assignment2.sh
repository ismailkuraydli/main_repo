#!/bin/bash

memoryused=$(free -m | awk 'NR==2{ print $3*100/$2}') 

diskspaceused=$(df -h | awk 'NR==4{ print $5-1+1}')  

if [[ $memoryused < 80 && $diskspaceused < 80 ]]; then
	echo "Everything is OK"
fi

if [[ $memoryused > 80 ]]; then
	echo "ALERT: Virtual memory is at $memoryused %"
fi

if [[ $diskspaceused > 80 ]]; then 
	df -h | awk 'NR==4{printf "ALERT:Disk %s is at %s",$1,$5 }' 
fi
