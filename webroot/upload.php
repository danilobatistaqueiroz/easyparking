<?php

const DS = DIRECTORY_SEPARATOR;
$name = '';
$type = '';
$size = '';
$error = '';

function resize_image($file, $type, $url, $w, $h, $crop = FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }
    if ($type == "image/gif") {
        $src = imagecreatefromgif($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagegif($dst, $url);
    } else if ($type == "image/jpeg" || $type == "image/pjpeg") {
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($dst, $url);
    } else if ($type == "image/png") {
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagepng($dst, $url);
    }
}

function save_image($file, $type, $url) {
    if ($type == "image/gif") {
        $src = imagecreatefromgif($file);
        imagegif($src, $url);
    } else if ($type == "image/jpeg" || $type == "image/pjpeg") {
        $src = imagecreatefromjpeg($file);
        imagejpeg($src, $url);
    } else if ($type == "image/png") {
        $src = imagecreatefrompng($file);
        imagepng($src, $url);
    }
}

function persist_file($uploaded, $id) {
    $error = "";
    $id = str_pad($id, 8, "0", STR_PAD_LEFT);
    if ($uploaded["error"] > 0) {
        $error = $uploaded["error"];
    }
    $tipos = array("image/gif", "image/jpeg", "image/png", "image/pjpeg");
    $type = $uploaded["type"];
    if (in_array($type, $tipos)) {
        $url_normal = __DIR__ . DS . 'img' . DS . 'parkings' . DS . $id . '.png';
        $url_mini = __DIR__ . DS . 'img' . DS . 'parkings' . DS . 'minis' . DS . $id . '.png';
        save_image($uploaded["tmp_name"], $type, $url_normal);
        resize_image($uploaded["tmp_name"], $type, $url_mini, 50, 50);
    } else {
        $error = "Uploaded image should be jpg or gif or png";
    }
    echo $error;
}

if ($_POST) {
    print_r($_FILES);
    for ($id = 1; $id <= 3; $id++) {
        persist_file($_FILES["upload" . $id], $id);
    }
}
?>