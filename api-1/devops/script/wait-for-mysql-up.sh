#!/bin/bash

for i in 1 2 3 4 5;do wait-for-it -h mysql -p 3306 -t 15 -s -- devops/script/init-api.sh && break || sleep 10; done