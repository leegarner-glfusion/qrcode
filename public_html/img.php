<?php
/**
*   Allow the downloading of original images to authorized visitors
*  
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2012 Lee Garner <lee@leegarner.com>
*   @package    photocomp
*   @version    0.0.1
*   @license    http://opensource.org/licenses/gpl-2.0.php 
*               GNU Public License v2 or later
*/

/**
*   Include require glFusion common functions
*/
require_once '../lib-common.php';
USES_qrcode_class_qrcode();

$img = isset($_GET['img']) ? $_GET['img'] : '';
if ($img == '') die('');

// Make sure the image exists
if (!qrCode::file_exists($img)) {
    die('');
}

$file_path = $_QRC_CONF['img_path'] . $img;
$fsize = @filesize($file_path);
if ($fsize === FALSE) die('');

// Start the download
// set headers
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: public');
header('Content-Description: File Transfer');
header('Content-Type: ' . qrCode::MimeType($img));
header('Content-Disposition: attachment; filename="' . $img . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $fsize);

// download
// @readfile($file_path);
$file = @fopen($file_path, 'rb');
if ($file) {
  while (!feof($file)) {
    print (fread($file, 1024*8));
    flush();
    //if (connection_status()!=0) {
    //  @fclose($file);
    //  die();
    //}
  }
  @fclose($file);
}

?>
