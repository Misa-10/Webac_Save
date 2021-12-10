<?php

# Options of shell
$options = getopt("ri::");
$test = 
var_dump($options);
var_dump($argv[1]);


    #Options recursive
    if (array_key_exists("r",$options)==true)
    {
        
        echo "rec\n";
        
    }
    elseif ((array_key_exists("r",$options)==false)) {
        echo "non rec\n";
    }
   #Options name image
   if (array_key_exists("i",$options)==true)
   {
       if ($options["i"]==false) {
           echo "sprite.png\n";
       }
       else {
        echo "name". $options["i"]."\n";
       }
       
       
   }
   elseif ((array_key_exists("i",$options)==false)) {
       echo "sprite.png\n";
   }
   #Options name css
   if (array_key_exists("s",$options)==true)
   {
       if ($options["s"]==false) {
           echo "sprite.png\n";
       }
       else {
        echo "name". $options["s"]."\n";
       }
       
       
   }
   elseif ((array_key_exists("s",$options)==false)) {
       echo "sprite.png\n";
   }