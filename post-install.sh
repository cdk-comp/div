#!/bin/bash

echo "==============="
rsync -a wp-tmp/ wp/ && rm -rf wp-tmp
echo "wp updated"
echo "==============="
wp db import elm_test.sql
echo "wp db import"
echo "==============="
wp dotenv salts regenerate
echo "wp salts regenerate"
echo "==============="
ln -s wp htdocs
echo "symlink for htdocs"
echo "==============="
sed -i -e s/WP_ROCKET_KEY\',\ \'\'/WP_ROCKET_KEY\',\ \'replace_key\'/g  wp/wp-content/plugins/wp-rocket/licence-data.php
sed -i -e s/WP_ROCKET_EMAIL\',\ \'\'/WP_ROCKET_EMAIL\',\ \'replace@email.com\'/g  wp/wp-content/plugins/wp-rocket/licence-data.php
echo "==============="
echo "rocket licence added"
echo "==============="
