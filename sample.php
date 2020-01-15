<?php 


# include class_SMS.php file 
# change API KEY in sms.php file
if( file_exists('class.SMS.php') ) {
	include_once 'class.SMS.php';
}


# ONE TO ONE

# instantiate of SMS Class
$single = new SMS();

# setting attributes
$single->
		setNumbers('01700000000')-> # STRING | Numbers
		setMessage('your message')-> # STRING | Message
		send(); # Returns array




# ONE TO MANY

$multi = new SMS();

# setting attributes
$multi->
		setNumbers(['01700000000', '01700000001'])-> # ARRAY | ['number1', 'numbers2']
		setMessage('your message')-> # STRING | Message
		send(); # Returns array



# ONE TO MANY [Method 2]

$multi2 = new SMS();

# setting attributes
$multi2->
		setNumbers('01700000000', '01700000001')-> # STRING | Use comma after each number
		setMessage('your message')-> # STRING | Message
		send(); # Returns array



# ONE TO MANY [Method 3]

$multi3 = new SMS();

# setting attributes, recalling setNumbers method will store new number
$multi3->
		setNumbers('01700000000')-> # STRING | Numbers
		setNumbers('01700000001')-> # STRING | Numbers
		setNumbers('01700000003')-> # STRING | Numbers
		setMessage('your message')-> # STRING | Message
		send(); # Returns array




# MANY TO MANY

# instantiate of SMS Class
$bulk = new SMS();

# setting attributes
$bulk->
		setBulk(['01757377445' => 'hello text'])-> # ARRAY | [Number => Message]
		send(); # Returns array


# recalling  setBulk method will store new number and message, won't reset previous values. Assigning multiple element in array inside setBulk method is allowed.



##################################################################################################
############### 			Developed by Jafran Hasan | fb/iamjafran 				##############
##################################################################################################





