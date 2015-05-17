# Generic configuration of mediacenter

## Setup Vi

Create a .vimrc in the home folder with the following content

```
set nocompatible
set backspace=2
```

## Set static IP address

One quick way, is tell the router to assign always the same IP address though
DHCP with infinite lease. This depends on the configuration of your router.


## Disable screensaver

```
System > Settings > Appearance > Screensaver > Screensaver mode > None
```


## Install Aeon Nox

Go to

```
System > Settings > Appearance > Skin
```

Select the current one, select `Get More...`. `Aeon Nox` should be the first
one.

# Scrape TV Shows and Movies

* Go to `Videos > Files > Files > Add Videos...`
* Select `Browse`
* Select `Home folder`
* Select `tv-shows`
* Hit `Ok`
* Select `Ok` on the left again
* In the next screen, on the right of `This directory contains`, move the
  arrows to see the options. Select `TV Shows` and in the dropdown ensure
  `The TVDB` is selected.
* Click `Ok`. Say `Yes` in the next screen to start scraping and get all the
info about the TV Shows.

Repeat the steps for your Movies folder.

# Enable remote access to MySQL DB

This configuration will enable remote access to a MySQL database in the server.

## Configuration

Need to edit `my.cnf` configuration file:

* If you are using Debian Linux file is located at `/etc/mysql/my.cnf` location
* If you are using Red Hat Linux/Fedora/Centos Linux file is located at `/etc/my.cnf` location.
* If you are using FreeBSD you need to create a file  `/var/db/mysql/my.cnf` location.

Now search for the section `[mysqld]` and:

* Ensure the line `skip-networking` is commented or removed
* Add `bind-address=YOUR-SERVER-IP`
* Restart the server

If you have any webapp connecting to this database, you cannot use localhost anymore in the connection url. Another way would
be using `0.0.0.0` as bind address, and ensure via firewall that only the required IP address can connect to port 3306.

## Grant access

It is needed to grant access externally to database/user.

* Log into mysql client as root
* Run the following in a new database `foo`

```
GRANT ALL ON foo.* TO user@'CLIENT-IP' IDENTIFIED BY 'PASSWORD'
```

* Or run the following for an existing DB

```
mysql> use mysql;
mysql> update db set Host='CLIENT-IP' where Db='DBNAME';
mysql> update user set Host='CLIENT-IP' where user='USERNAME';
```
It can happen that the connection is refused, check the `user@host-refused` and add that entry to `user` table. You may need to issue:

```
grant all privileges on *.* to 'user'@'refused-host';
```

You may need to configure several of these, as every service which connects to the database could try to use a different host name. Consider using `'%'` as host to create an *everywhere* rule, but ensure you limit access to *everywhere*

Restart the server after updating the tables and try to reconnect.

* Open port 3306 in the firewall. For `iptables`

```
/sbin/iptables -A INPUT -i eth0 -p tcp --destination-port 3306 -j ACCEPT
```
