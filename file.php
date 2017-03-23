<?php
session_start();
// get the image name from the query string
if (isset($_GET['img'])){
	// define absolute path to image folder
	$image_folder = '../uploads/';
    $pic = $image_folder.$_GET['img'];
    if (file_exists($pic) && is_readable($pic)) {
        // get the filename extension
        $ext = substr($pic, -3);
        // set the MIME type
        switch ($ext) {
            case 'jpg':
                $mime = 'image/jpeg';
                break;
            case 'gif':
                $mime = 'image/gif';
                break;
            case 'png':
                $mime = 'image/png';
                break;
            default:
                $mime = false;
        }
        // if a valid MIME type exists, display the image
        // by sending appropriate headers and streaming the file
        if ($mime) {
            header('Content-type: '.$mime);
            header('Content-length: '.filesize($pic));
            $file = @ fopen($pic, 'rb');
            if ($file) {
                fpassthru($file);
                exit;
            }
        }
    }
}
?>