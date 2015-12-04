<?php

$dir = dirname(__FILE__);
$HOST="http://website.com/";

//$filename = $dir . preg_replace("/\?.*$/", "", $_SERVER["REQUEST_URI"]);
//$fileurl = rtrim($HOST, '/') . $_SERVER["REQUEST_URI"];

function toLocalePath($url) {
    $dir = dirname(__FILE__);
    $local_file = preg_replace('/\\\/', '/',  $dir . preg_replace("/\?.*$/", "", $url));
    return $local_file;
}

function downloadFile($fileurl, $filename) {
    if (file_exists($filename)) {
        return;
    } else {
        @mkdir(dirname($filename), 0777, true);
        @copy($fileurl, $filename);
    }
}


$remote_url = rtrim($HOST, '/') . $_SERVER["REQUEST_URI"];
$local_file = toLocalePath($_SERVER["REQUEST_URI"]);

//echo "<pre>";
//echo $_SERVER["REQUEST_URI"] . PHP_EOL;
//echo $remote_url . PHP_EOL;
//echo $local_file . PHP_EOL;
//echo "</pre>";
//exit();

/*
if (preg_match('/\.html$/',  $_SERVER["REQUEST_URI"])) {
    $f = dirname($filename) . '/html/' . basename($filename);
    if (!file_exists($f)) {
        download($fileurl, $f);
    }
} else {
    if (!file_exists($filename)) {
    	download($fileurl, $filename);
    }
}/**/
if (!file_exists($local_file)) {
    downloadFile($remote_url, $local_file);
}


if (preg_match('/\.(?:min\.)/', $_SERVER["REQUEST_URI"])) {
    downloadFile(preg_replace('/\.min\./', '.', $remote_url), preg_replace('/\.min\./', '.', $local_file));
}

if (preg_match('/\.(?:ttf)/', $_SERVER["REQUEST_URI"])) {
    downloadFile(preg_replace('/\.ttf/', '.svg', $remote_url), preg_replace('/\.ttf/', '.svg', $local_file));
    downloadFile(preg_replace('/\.ttf/', '.eot', $remote_url), preg_replace('/\.ttf/', '.eot', $local_file));
}



if (preg_match('/\.(?:html)$/', $_SERVER["REQUEST_URI"])) {
	header("Content-Type: text/html; charset=utf-8");
} elseif (preg_match('/\.(?:css)$/', $_SERVER["REQUEST_URI"])) {
	header("Content-Type: text/css; charset=utf-8");
} elseif (preg_match('/\.(?:js)$/', $_SERVER["REQUEST_URI"])) {
	header("Content-Type: text/javascript; charset=utf-8");
}


$f =  dirname(__FILE__) . preg_replace('/\\\/', '/', $_SERVER["REQUEST_URI"]);
$f = preg_replace('/\?.*$/', '', $f);
// echo $f;
// exit()

//if (preg_match('/\.html$/', $f)) {
//    $f = dirname(__FILE__) . preg_replace('/\\\/', '/', $_SERVER["REQUEST_URI"]);
//    $f = dirname($f) . '/html/' . basename($f);
//}

if (file_exists($f)) {
	// header("Content-Type: text/html; charset=utf-8");
	readfile($f);
	return;
}


// return false; // сервер возвращает файлы напрямую.

