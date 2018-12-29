#!/usr/bin/expect -f
#Usage: script.sh cmd user pass

set cmd [lindex $argv 0];
set pass [lindex $argv 1];

log_user 0
spawn su -c $cmd - root
expect "Password: "
log_user 1
send "$pass\r"
expect "$ "


