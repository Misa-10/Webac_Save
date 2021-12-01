<?php
Get_global_width_height($argc,$argv);
Fusion_image($argc,$argv);
$global_width =0 ;
$global_height =0 ;


function Get_global_width_height($argc,$argv){
    
    global $global_width;
    global $global_height;
    
    
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
    
    global $global_width;
    global $global_height;
    
    
    
    
    $Fusion_png=imagecreatetruecolor($global_width,$global_height);
    
    // Image numero 1
    $PNG_zero= imagecreatefrompng($argv[1]);
    
    
    $Size_png_zero= getimagesize($argv[1]);
    
    imagecopy(  $Fusion_png,$PNG_zero, 0, 0, 0, 0, $Size_png_zero[0], $Size_png_zero[1]);
    
    imagepng($Fusion_png,"Fusion.png");
    
    imagedestroy($PNG_zero);
    
    $Size_All = 0;
    $Size_png_final = 0;
    
    
    // boucle
    for ($i=2; $i <=$argc-1 ; $i++) { 
        
        
        
        $PNG= imagecreatefrompng($argv[$i]);
        
        
        $Size_png= getimagesize($argv[$i]);
        
        if ($i==2) {
            
            imagecopy( $Fusion_png,$PNG, $Size_png_zero[0], 0, 0, 0, $Size_png[0], $Size_png[1]);
            
            imagepng($Fusion_png,"Fusion.png");
            
            imagedestroy($PNG);
            
            $Size_All = $Size_png_zero[0] + $Size_png[0]; // get the larger of two first pics
            
            
            
        }
        elseif ($i!=2) {
            
            
            imagecopy( $Fusion_png,$PNG, $Size_All, 0, 0, 0, $Size_png[0], $Size_png[1]);
            
            imagepng($Fusion_png,"Fusion.png");
            
            imagedestroy($PNG);
            
            $Size_All += $Size_png[0]; // add the larger of the new pics 
            
            
        }
        
    }
    
    
}





