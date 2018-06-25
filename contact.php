<?php

$from = 'NRHD Resources Web <no-reply@nrhd-resources.com>';
$sendTo = 'NRHD Resources Web Inquiry <lakmalhimbutu@gmail.com>'; 
$subject = 'New message: '. $_POST["subject"] . ' | NRHD Resources web contact form';
$fields = array('name' => 'Name', 'subject' => 'Subject', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text appear in the email
$okMessage = 'Contact form successfully submitted. Thank you, We will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

try
{
    $emailText = "You have a new message through NRHD Resources web contact form\n\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: \n$value\n\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $_POST["email"],
        'Return-Path: ' . $_POST["email"],
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
