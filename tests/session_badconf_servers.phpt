--TEST--
Session bad configurations, invalid save path (server list)
--SKIPIF--
<?php if (!extension_loaded("memcached")) print "skip"; ?>
--INI--
memcached.sess_locking = on
memcached.sess_lock_wait = 150000
memcached.sess_prefix = "memc.sess.key."
session.save_path="127.0.0.1:11211"
session.save_handler = memcached

--FILE--
<?php 
error_reporting(0);
function handler($errno, $errstr) {
	echo "$errstr\n";
}

set_error_handler('handler', E_ALL);

ini_set('memcached.sess_prefix', 'memc.sess.key.');
ini_set('session.save_path', '');
session_start();
session_write_close();

--EXPECTF--
session_start(): failed to parse session.save_path: ""