<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

/* * *
 *   Envio de los respectivos mail
 */

if (!function_exists('validationMail')) {

    function validationMail($name, $valCode, $email) {
        $CI = get_instance();
        $CI->load->library("email");
        $message = "<h2>Se ha creado una nueva cuenta de YouTuve</h2><br>"
                . "<p>" . $name . " para confirmar tu cuenta debe hacer click en el link que se encuentra debajo</p><br>"
                . "<a href='" . base_url() . "User/validate/" . $valCode . "'>Click aqui para activar cuenta</a>";
        $subject = "Correo de confirmacion YouTuve";
        $ret = $CI->email->sendMail($email, $message, $subject);
        return $ret;
    }

}

//Mail informando a todos los suscriptos a un canal que este subio un video
if (!function_exists('newChannelVideoMail')) {

    function newChannelVideoMail($idChannel, $videoId) {
        $CI = get_instance();
        $CI->load->model("channel_model");
        $CI->load->library("email");
        $followerUsers = $CI->channel_model->getFollower($idChannel);
        if ($followerUsers != FALSE) {
            $count = 0;
            foreach ($followerUsers as $user) {
                $to[$count] = $user->email;
                $count++;
            }
            $channel = $CI->channel_model->selectById($idChannel);
            $message = "<h2>El canal " . $channel->name . " ha subido nuevo contenido</h2><br>"
                    . "<p>Click </p>"
                    . "<a href='" . base_url() . "Video/view/" . $videoId . "'>aqui </a>"
                    . "<p>para ver el video</p>";
            $subject = $channel->name . " se ha subido un nuevo video";
            $ret = $CI->email->sendMail($to, $message, $subject);
            return $ret;
        } else {
            return FALSE;
        }
    }

}

//Mail informando un nuevo suscriptor en el canal
if (!function_exists('newFollowMail')) {

    function newFollowMail($userId, $channelId) {
        //creo instancia de objeto, y cargo channel_model
        $CI = get_instance();
        $CI->load->model('channel_model');
        $CI->load->model('user_model');
        $CI->load->library('email');
        $userChannel = $CI->channel_model->selectByIdUser($userId);
        $message = "<h2>El usuario " . $userChannel->name . " ahora sigue tu canal</h2><br>"
                . "<p>Click </p>"
                . "<a href='" . base_url() . "Channel/" . $userChannel->id . "'>aqui </a>"
                . "<p>para visitar su canal</p>";
        $subject = "Tienes un nuevo seguidor";
        $channel = $CI->channel_model->selectByIdChannel($channelId);
        $ret = $CI->email->sendMail($channel->email, $message, $subject);

        $channel = $CI->channel_model->selectById($channelId);
        $user = $CI->user_model->selectById($channel->idUser);
        $ret = $CI->email->sendMail($user->email, $message, $subject);

        return $ret;
    }

}

if (!function_exists('valCode')) {

    function valCode($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
    