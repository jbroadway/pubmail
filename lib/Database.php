<?php

if ($db = @sqlite_open ('admin/data/database.db', 0666, $sqlite_error)) {
	// we're good!
} else {
	die ($sqlite_error);
}

if (! function_exists ('sqlite_fetch_object')) {
	function sqlite_fetch_object (&$res) {
		$arr = @sqlite_fetch_array ($res, SQLITE_ASSOC);
		if ($arr) {
			return (object) $arr;
		}
		return $arr;
	}
}

function db_compile_query ($sql, $args) {
	if (count ($args) > 1 || $args[0] != $sql) {
		if ($args[0] == $sql) {
			array_shift ($args);
		}
		foreach ($args as $k => $arg) {
			if (! is_numeric ($arg)) {
				if (empty ($arg)) {
					$args[$k] = "''";
				} else {
					$args[$k] = "'" . str_replace ("'", "''", stripslashes ($arg)) . "'";
				}
			}
		}
		$sql = vsprintf ($sql, $args);
	}
	return $sql;
}

function db_fetch_array ($sql) {
	global $db;
	$args = func_get_args ();
	$sql = db_compile_query ($sql, $args);
	$res = @sqlite_query ($db, $sql);
	$out = array ();
	while ($obj = @sqlite_fetch_object ($res)) {
		$out[] = $obj;
	}
	return $out;
}

function db_execute ($sql) {
	global $db;
	$args = func_get_args ();
	$sql = db_compile_query ($sql, $args);
	return @sqlite_query ($db, $sql);
}

function db_single ($sql) {
	global $db;
	$args = func_get_args ();
	$sql = db_compile_query ($sql, $args);
	$res = @sqlite_query ($db, $sql);
	if ($res) {
		return @sqlite_fetch_object ($res);
	}
	return false;
}

function db_shift ($sql) {
	global $db;
	$args = func_get_args ();
	$sql = db_compile_query ($sql, $args);
	$res = @sqlite_query ($db, $sql);
	if ($res) {
		$arr = @sqlite_fetch_array ($res);
		if (is_array ($arr)) {
			return array_shift ($arr);
		}
	}
	return false;
}

function db_lastid () {
	global $db;
	return @sqlite_last_insert_rowid ($db);
}

function db_error () {
	global $db;
	$code = @sqlite_last_error ($db);
	if ($code == 0) {
		return false;
	}
	return @sqlite_error_string ($code);
}

?>