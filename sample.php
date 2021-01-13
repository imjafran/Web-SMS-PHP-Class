<?php


# include class_SMS.php file 
if (file_exists('class.SMS.php')) {
	include_once 'class.SMS.php';
}


# ONE TO ONE

# instantiate of SMS Class
$sms = new \BDGO\SMS('bdgoifxzmlPQu5OrRAnVEoawMZ0F9qeNJd');

# setting attributes
$send = $sms
	->setNumber('01757377448')
	->setMessage('This is a text message')
	->send();


if ($send)
	echo 'Message Sent!';
else
	echo 'Message not sent';
	

##################################################################################################
##############  	    Developed by Jafran Hasan | fb/iamjafran 	            ##############
##################################################################################################
