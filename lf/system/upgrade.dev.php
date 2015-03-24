<?php

/*

check for issues, provide options to resolve issues

provide option to finish upgrade, delete file

*/

if(isset($this)) { $db = $this->db; }
else
{
        include 'config.php';
        $conf = $db;
        $db = new Database($conf);
}

// 1.13.5-r129
$index = "<?php require 'lf/system/init.php';";
file_put_contents(ROOT.'../index.php', $index);

$acl = array();
$acl_user = $db->fetchall("SHOW COLUMNS FROM `lf_acl_user`");
foreach($acl_user as $user) $acl[] = $user['Field'];
if(in_array('nav_id', $acl)) $db->query('ALTER TABLE lf_acl_user DROP COLUMN nav_id');

$acl = array();
$acl_user = $db->fetchall("SHOW COLUMNS FROM `lf_acl_global`");
foreach($acl_user as $user) $acl[] = $user['Field'];
if(in_array('nav_id', $acl)) $db->query('ALTER TABLE lf_acl_global DROP COLUMN nav_id');

$db->query("UPDATE lf_users SET status = 'valid' WHERE status = 'online'");


// 1.13.5-r130

// update user table
$columns = array();
$cols = $db->fetchall("SHOW COLUMNS FROM lf_users");
foreach($cols as $col) $columns[] = $col['Field'];
if(in_array('salt', $columns)) $db->query('ALTER TABLE lf_users DROP COLUMN salt');
if(!in_array('hash', $columns)) $db->query('ALTER TABLE lf_users ADD hash VARCHAR( 40 ) NOT NULL');

// add settings
$rewrite = $db->fetch("SELECT * FROM lf_settings WHERE var = 'rewrite'");
if(!$rewrite) $db->query("INSERT INTO lf_settings (id, var, val) VALUES ( NULL, 'rewrite', 'off')");
$debug = $db->fetch("SELECT * FROM lf_settings WHERE var = 'debug'");
if(!$debug) $db->query("INSERT INTO lf_settings (id, var, val) VALUES ( NULL, 'debug', 'off')");
$url = $db->fetch("SELECT * FROM lf_settings WHERE var = 'force_url'");
if(!$url) $db->query("INSERT INTO lf_settings (id, var, val) VALUES ( NULL, 'force_url', '')");
$nav = $db->fetch("SELECT * FROM lf_settings WHERE var = 'nav_class'");
if(!$nav) $db->query("INSERT INTO lf_settings (id, var, val) VALUES ( NULL, 'nav_class', '')");
$simple = $db->fetch("SELECT * FROM lf_settings WHERE var = 'simple_cms'");
if(!$simple) $db->query("INSERT INTO lf_settings (id, var, val) VALUES ( NULL, 'simple_cms', '_lfcms')");

// for handling signup within system/
$signup = $db->fetch("SELECT * FROM lf_settings WHERE var = 'signup'");
if(!$signup) $db->query("INSERT INTO lf_settings (id, var, val) VALUES ( NULL, 'signup', 'disabled')");



// when plugins were introduced
$db->query('CREATE TABLE IF NOT EXISTS lf_plugins (
  id int(11) NOT NULL AUTO_INCREMENT,
  hook varchar(128) NOT NULL,
  plugin varchar(128) NOT NULL,
  status varchar(64) NOT NULL,
  config varchar(1024) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');

// really need to add something here to make this interactive in case of a problem


