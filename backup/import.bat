@echo off
setlocal
echo "Enter * 3 (No password)"
pushd "%~dp0"
mysql -u root -p users < users.sql
mysql -u root -p items < items.sql
mysql -u root -p msg < msg.sql
popd