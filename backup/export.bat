@echo off
setlocal
echo "Enter * 3 (No password)"
pushd "%~dp0"
mysqldump -u root -p users > users.sql
mysqldump -u root -p items > items.sql
mysqldump -u root -p msg > msg.sql
popd
