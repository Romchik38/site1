# logger folder

Use commands below to create a log folder and grant write access for service in system with Selinux.

```sh
cd path_to_app
mkdir app/var/
sudo semanage fcontext -a -t httpd_sys_rw_content_t "/path_to_app/app/var(/.*)?"
sudo restorecon -R .
sudo chown user_name:service_name app/var/
chmod g=rwx app/var/
```
