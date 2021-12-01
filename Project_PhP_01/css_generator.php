<?php

Fusion_image($argc,$argv);





function Fusion_image($argc,$argv){
    
    
    $Fusion_png=imagecreatetruecolor(5000,2000);
    
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
            
            if ($Size_png_zero[1]>$Size_png[1]) {  // if the height of png zero is the most big then we save it

                $Size_png_final = $Size_png_zero[1];
                
            }
            
            imagecopy( $Fusion_png,$PNG, $Size_png_zero[0], 0, 0, 0, $Size_png[0], $Size_png[1]);
            
            imagepng($Fusion_png,"Fusion.png");
            
            imagedestroy($PNG);
            
            $Size_All = $Size_png_zero[0] + $Size_png[0]; // get the larger of two first pics
            
            
            
        }
        elseif ($i!=2) {

            if ($Size_png_final<$Size_png[1]) { // if the height of png png is the most big then we save it

                $Size_png_final = $Size_png[1];
                
            }
            
            
            
            imagecopy( $Fusion_png,$PNG, $Size_All, 0, 0, 0, $Size_png[0], $Size_png[1]);
            
            imagepng($Fusion_png,"Fusion.png");
            
            imagedestroy($PNG);

            $Size_All += $Size_png[0]; // add the larger of the new pics 

            
        }
        
    }

    // final png with perfect size
    $Fusion_png_final=imagecreatetruecolor($Size_All,$Size_png_final);

    $PNG_final= imagecreatefrompng("Fusion.png");

    imagecopy( $Fusion_png_final,$PNG_final, 0, 0, 0, 0, $Size_All, $Size_png_final);
            
    imagepng($Fusion_png_final,"Fusion_final.png");
}





