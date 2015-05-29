<?php

defined('BASEPATH') OR exit('No direct script access allowed.');



if (!function_exists('validationMail')) {

    function validationMail($name) {
        $validationCode = generateRandomString();
        $message = "<h2>Se a creado una cuenta de YouTuve</h2><br>"
                . "<p>" . $name . " para confirmar tu cuenta debe hacer click en el link que se encuentra debajo</p><br>"
                . "<a href='" . base_url() . "User/validate/" . $validationCode . "'>Click aqui para activar cuenta</a>";
        $subject = "Correo de confirmacion YouTuve";
        $ret["validationCode"] = $validationCode;
        $ret["message"] = $message;
        $ret["subject"] = $subject;
        return $ret;
    }

}

if (!function_exists('newVideoMail')) {

    function newVideoMail($channelName, $videoId) {
        $message = "<h2>El canal ".$channelName." ha subido nuevo contenido</h2><br>"
                . "<p>Click </p>"
                . "<a href='". base_url(). "Video/view/".$videoId."'>aqui </a>"
                . "<p>para ver el video</p>";
        $subject = $channelName." se ha subido un nuevo video";
        $ret["message"] = $message;
        $ret["subject"] = $subject;
        return $ret;
    }

}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}