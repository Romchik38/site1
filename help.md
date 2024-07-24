# Help config

## logger folder

sudo semanage fcontext -a -t httpd_sys_rw_content_t ".../site1/app/var(/.*)?"
sudo restorecon -R .

sudo chown user_name:service_name app/var/
chmod g=rwx app/var/

