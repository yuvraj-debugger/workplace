#!/bin/bash

directory="/var/www/html/work-place"

while true; do
    # Run the php artisan command
    php "$directory/artisan" command:employee-shift
    sleep 1
 done
    
    
   
