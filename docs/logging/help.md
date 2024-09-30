# logger folder

Use commands below to create a log folder and grant write access for service in system with Selinux.

```sh
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/path_to_app/site1/app/var(/.*)?"
sudo restorecon -R .
mkdir app/var/
sudo chown user_name:service_name app/var/
chmod g=rwx app/var/
```
