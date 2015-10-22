<?php

require_once 'includes/PHPMailer/class.phpmailer.php';
require_once 'includes/PHPMailer/PHPMailerAutoload.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// FRONTEND : send mail ========================================
function sendmail($to, $subject, $body) {
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; // or 587
    $mail->IsHTML(true);
    $mail->Username = "hoancn1.ptit@gmail.com";
    $mail->Password = "beo05121993";
    $mail->SetFrom("hoancn1.ptit@gmail.com", "GameMagazine");
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

// END of query