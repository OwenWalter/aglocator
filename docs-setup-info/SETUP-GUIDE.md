**System requirements:**

Red Hat Enterprise Linux: 7.9

Apache Web Server: 2.4.6

MariaDB: 10.11 (or equivalent MySQL version)

PHP version: 7.4

NOTE: Newer versions or alternatives have not been tested, but probably work fine... may require some minor tweaks to code. PHP in particular -- original system used PHP5. When updated to PHP7 there were code modifications required due to depricated PHP functions. Unclear if there may be others on PHP 8 or newer.

------
------

**How to set up (fresh install):**

1) Install LAMP stack package or individually install Apache, MariaDB/MySQL, and PHP on your Linux/web server host.
2) Enable PHP mod_rewrite.
3) Import cheatsheet-schema.sql (found on git project inside the docs-setup-info subfolder) into the database. This will create the database "cheatsheet" and its tables/structure.
4) Create or assign a database user account with full permissions to "cheatsheet" database.
5) Import HTML files from Git project onto the desired location of your web server. Default: `<HTMLroot>/cheatsheet/`
6) Create a copy of db.php-example as "db.php", and authorkey-salts.php-example as "authorkey-salts.php" . For security, it is suggested to save these files in a location readable by the web server user but outside of HTML root.
7) Edit the db.php file you created in step 6, entering the database host and user credentials you created in step 4.
8) Edit the authorkey-salts.php file you created in step 6, setting unique author key salts (3x text strings).

------

**How to set up (clone, migrate, or disaster recovery):**

1) Install LAMP stack package or individually install Apache, MariaDB/MySQL, and PHP on your Linux/web server host.
2) Enable PHP mod_rewrite.
3) Obtain the toothless backup package you intend to restore from. Extract the various contents as needed in the following steps.
4) Import cheatsheet.sql from the backup package into the database. This will create the database "cheatsheet", tables/structure, and load the existing data rows.
5) Create or assign a database user account with full permissions to "cheatsheet" database.
6) Import HTML files from the backup package html_backup.tar.gz onto the desired location of your web server. Default: `<HTMLroot>/cheatsheet/`

[ALTERNATIVE] The file apacheweb_backup.tar.gz can be imported from the backup package, instead of the file from step 6. This file additionally contains the `secrets` directory where existing database and author key salts are stored. It is recommended to simply set these up again instead of reusing. If you elect to instead use this alternative, references in the subsequent steps should point to the existing secrets files.

7) Create a copy of db.php-example as "db.php", and authorkey-salts.php-example as "authorkey-salts.php" . For security, it is suggested to save these files in a location readable by the web server user but outside of HTML root.
8) Edit the db.php file you created in step 7, entering the database host and user credentials you created in step 5.
9) Edit the authorkey-salts.php file you created in step 7, setting unique author key salts (3x text strings).

------
------

**Post install configuration and validation:**

1) Review the PHP script and HTML files imported to the web server. Update any references to the db.php and authorkey-salts.php files. These appear as "require_once...." at the top of many files, and must point to the locations where you saved the actual db and authorkey-salts files. See the Developer documentation for details if unsure where to set these references.
2) Delete the subdirectory `docs-setup-info` from the files imported to the web server, or move this to a location outside of HTML root. This directory is not used by the application and is only used to keep storage of setup and developer documentation on Git.
3) Restart Apache to ensure any updates/changes during the install process have taken effect.
4) Test the application by creating a new entry, searching for it, attempting to delete it, etc.
5) Test send an author key email request. If this fails, you must configure `mail` on the linux host. PHP uses sendmail() which calls to host email handler. For an internal SAS server, using SMTP relay mailhost.fyi.sas.com on port 25 (anonymous) has worked so far.

------
------

For additional / old information, refer also to SS LAZY project doc. The AG Locator project is refined from source code originally developed for SS LAZY application, which itself was derived from another open-source project. Find SS LAZY readme here: https://gitlab.sas.com/arts-tools-development/ss-lazy/-/blob/master/README.md
