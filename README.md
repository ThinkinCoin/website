# WordPress > ReadMe

![WordPress Logo](wp-admin/images/wordpress-logo.png)

Semantic Personal Publishing Platform

## First Things First

Welcome. WordPress is very special to me. Every developer and contributor adds something unique to the mix, creating something beautiful. Thank you for making it part of your world.

— Matt Mullenweg

## Installation: Famous 5-minute install

1. Unzip the package in an empty directory and upload everything.
2. Open `wp-admin/install.php` in your browser to set up `wp-config.php` with your database connection details.
   - If this does not work, open `wp-config-sample.php`, fill in your details, save it as `wp-config.php`, and upload it.
   - Open `wp-admin/install.php` in your browser again.
3. Once the configuration file is set up, the installer will set up the tables needed for your site.
4. If you did not enter a password, note the password given to you. The default username will be `admin`.
5. The installer should then send you to the login page. Sign in with the username and password you chose during the installation.

## Updating

### Using the Automatic Updater

1. Open `wp-admin/update-core.php` in your browser and follow the instructions.

### Updating Manually

1. Backup any files you've modified such as `index.php`.
2. Delete your old WordPress files, saving ones you've modified.
3. Upload the new files.
4. Point your browser to `/wp-admin/upgrade.php`.

## Migrating from other systems

WordPress can import from a number of systems. First, get WordPress installed and working as described above, before using our import tools.

## System Requirements

- PHP version 7.0 or greater.
- MySQL version 5.0 or greater.

### Recommendations

- PHP version 7.4 or greater.
- MySQL version 5.7 or greater OR MariaDB version 10.4 or greater.
- The mod_rewrite Apache module.
- HTTPS support.

## Online Resources

For any questions not addressed here, WordPress has numerous online resources available.

## Final Notes

If you have any suggestions, ideas, comments, or found a bug, join us in the Support Forums.

## Share the Love

WordPress is powered by you. Consider telling a friend, setting it up for someone less knowledgeable, or writing an article about us.

## License

WordPress is free software, released under the GPL (GNU General Public License) version 2 or any later version. See license.txt.
