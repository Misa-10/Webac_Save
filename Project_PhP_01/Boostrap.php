<?php




function my_merge_image($First_Path, $Second_Path){
    
    
    $First_png= imagecreatefrompng($First_Path);
    $Second_png=imagecreatefrompng($Second_Path);
    $Third_png=imagecreatetruecolor(1920,1080);
    
    $First_Size= getimagesize($First_Path);
    $Second_Size= getimagesize($Second_Path);
    
    
    
    
    imagecopy(  $Third_png,$First_png, 0, 0, 0, 0, $First_Size[0], $First_Size[1]);
    imagecopy( $Third_png, $Second_png, $First_Size[0], 0, 0, 0, $Second_Size[0], $Second_Size[0]);
    
  
    
    imagepng($Third_png,"test.png");
    
}

 //my_merge_image("test/1.png", "test/2.png");


function cut_image_path_and_name($img_name)
{

    
    
    if (preg_match('#/#', $img_name)) //check jusqu'au dernier /
	{
        $img_name = strpbrk($img_name, '/'); // cherche le premier /
        $img_name = substr($img_name, 1); // surpprime le caratere derriere
       
    
        
        return cut_image_path_and_name($img_name);
    }

    $img_name = strrev($img_name);
    $img_name = strpbrk($img_name, '.');
    $img_name = strrev($img_name);
    $img_name = substr($img_name, 0, -1);
    
   // var_dump($img_name);
    return $img_name;
    
}




function Make_Css(){

    global $img_name;

    var_dump($img_name);

$Handle = fopen("My_css.css","w+");

fwrite($Handle,".img-".$img_name."{"."   background-position:"."px;"."   Width :"."px;"."   Height :"."px;"."}");


fclose($Handle);


}


$img_name =cut_image_path_and_name("test/test/1.png");
Make_Css();