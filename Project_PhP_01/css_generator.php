<?php

$Handle = fopen("My_css.css","w+"); // open the css at the beginning otherwise it erase everything again and again
$global_width =0 ; $global_height =0 ; $img_name = 0; $Size_All = 0;
Get_global_width_height($argc,$argv);
Fusion_image($argc,$argv);

fclose($Handle);


function Get_global_width_height($argc,$argv){
    
    global $global_width; global $global_height;
    
    
    // boucle
    for ($i=1; $i <=$argc-1 ; $i++) { 
        
        
        
        $Size_png_global= getimagesize($argv[$i]);
        
        if ($global_height<$Size_png_global[1]) { // if the height of png png is the most big then we save it
            
            $global_height = $Size_png_global[1];
            
        }
        
        $global_width+=$Size_png_global[0];
        
        
        
        
    }
    
    
    
}



function Fusion_image($argc,$argv){
    
    global $global_width; global $global_height; global $Handle; global $img_name; global $Size_All;
    
    
    $Fusion_png=imagecreatetruecolor($global_width,$global_height);
    
    // Image numero 1
    $PNG_zero= imagecreatefrompng($argv[1]);
    
    
    $Size_png_zero= getimagesize($argv[1]);

    // Write css 
    $img_name= $argv[1]; // put the path inside new var ( if i put in funct the loop never stop)
    cut_image_path_and_name($i=NULL,$argc,$argv);// call my func with var null cause they didn't exist for the moment then it's skip the bug message
    Fill_css($Size_png=NULL,$i,$Size_png_zero);
    //
    
    imagecopy(  $Fusion_png,$PNG_zero, 0, 0, 0, 0, $Size_png_zero[0], $Size_png_zero[1]);
    
    imagepng($Fusion_png,"Fusion.png");
    
    imagedestroy($PNG_zero);
    
    
    
    
    
    // boucle
    for ($i=2; $i <=$argc-1 ; $i++) { 
        
        
        
        $PNG= imagecreatefrompng($argv[$i]);
        
        
        $Size_png= getimagesize($argv[$i]);
        
        if ($i==2) {
            
            // Write css 
            $img_name= $argv[$i]; // put the path inside new var ( if i put in funct the loop never stop)
            cut_image_path_and_name($i,$argc,$argv);
            Fill_css($Size_png,$i,$Size_png_zero);
            //
            
            imagecopy( $Fusion_png,$PNG, $Size_png_zero[0], 0, 0, 0, $Size_png[0], $Size_png[1]);
            
            imagepng($Fusion_png,"Fusion.png");
            
            imagedestroy($PNG);
            
            $Size_All = $Size_png_zero[0] + $Size_png[0]; // get the larger of two first pics
            
            
            
        }
        elseif ($i!=2) {
            // Write css 
            $img_name= $argv[$i]; // put the path inside new var ( if i put in funct the loop never stop)
            cut_image_path_and_name($i,$argc,$argv);
            Fill_css($Size_png,$i,$Size_png_zero);
            //
            
            
            imagecopy( $Fusion_png,$PNG, $Size_All, 0, 0, 0, $Size_png[0], $Size_png[1]);
            
            imagepng($Fusion_png,"Fusion.png");
            
            imagedestroy($PNG);
            
            $Size_All += $Size_png[0]; // add the larger of the new pics 
            
            
        }
        
    }
    
    
}

function cut_image_path_and_name($i,$argc,$argv)
{
    
    global $img_name;
    
    if (preg_match('#/#', $img_name)) //check jusqu'au dernier /
    {
        $img_name = strpbrk($img_name, '/'); // cherche le premier /
        $img_name = substr($img_name, 1); // surpprime le caratere derriere
    
        return cut_image_path_and_name($img_name,$i,$argc,$argv);
    }
    
    
    $img_name = strrev($img_name);
    $img_name = strpbrk($img_name, '.');
    $img_name = strrev($img_name);
    $img_name = substr($img_name, 0, -1);
    
    
}


function Fill_css($Size_png,$i,$Size_png_zero){
    
    global $Handle; global $img_name; global $Size_All;

    if ($i==NULL) {

        fwrite($Handle,".img-".$img_name."{"."   background-position:0"."px 0px;"."   Width : $Size_png_zero[0]px;"."   Height : $Size_png_zero[1]px;"."}\n");


    }
    elseif ($i==2) {

        fwrite($Handle,".img-".$img_name."{"."   background-position: $Size_png_zero[0]"."px 0px;"."   Width : $Size_png[0]px;"."   Height : $Size_png[1]px;"."}\n");


    }
    elseif ($i!=2) {

        fwrite($Handle,".img-".$img_name."{"."   background-position: $Size_All"."px 0px;"."   Width : $Size_png[0]px;"."   Height : $Size_png[1]px;"."}\n");


    }
    
  
}




