#!/bin/bash
#added /home/ismail/Desktop/scripts to PATH so we can use this script in every directory
dir="/var/log"
echo "File Name", "Size" > /home/ismail/Desktop/log_dump.csv
for f in "$dir"/*; do
	if [[ $f == *.log ]]; then
		size=$(stat -c%s "$f")		
		echo "${f##*/}", $((size/1000)) >> /home/ismail/Desktop/log_dump.csv
	fi
done
