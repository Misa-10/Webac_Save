<?php
$Red_Color_Start = "\033[31m ";
$Color_End = "\033[0m";
#Gestion Erreurs
# check if there is at least one args
if ($argc == 1) {
    echo "$Red_Color_Start Erreur : Vous n'avez pas mis d'arguments à la fonction.
    Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    return;  
    
}
#Options Man
if ($argv[1]=="-man" )
{
    
    echo "php Nameofscript -r -i -s -p -o NameFolder
    
    NameOfscript
    The name of the php script.
    
    -r, --recursive
    Look for images into the assets_folder passed as arguement and all of its subdirectories.\
    
    -i, --output-image=IMAGE
    Name of the generated image. If blank, the default name is « sprite.png ».
    
    -s, --output-style=STYLE
    Name of the generated stylesheet. If blank, the default name is « style.css ».
    
    -p, --padding=NUMBER
    Add padding between images of NUMBER pixels.
    
    -o, --override-size=SIZE
    Force each images of the sprite to fit a size of SIZExSIZE pixels.
    
    NameFolder
    You can put name of one folder or one files if your folder or files is out of the script you have to put all the path.\n";
    
    return;
    
}

# check if the files or folder exist
if(file_exists($argv[$argc-1] )==false){ 
    
    echo "$Red_Color_Start Erreur : Ce fichier ou dossier n'existe pas.
    Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    return;  
    
}

#Start my var
$Path_Dir =$argv[$argc-1]; 
$array_png=[]; // make the array where i will put my .png 
$array_dir=[]; // make the array where i will put my dir
$n=0; $Number_of_png =0; $Name_Fusion_Img = NUll; $Name_css = NULL; $options = NULL;$Size_png_zero_resize = NULL;$Size_png_resize =NUll;$Padding =NULL;
$Number_of_dir = NULL;
#Launch my code
Options();
#Gestions D'erreur -o
if (array_key_exists("o",$options)==true && is_numeric($options["o"])==false) {
    echo "$Red_Color_Start Erreur : L'option override-size  ne marchera pas si -o a pour valeur des lettres.
    Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    return;
}
if (array_key_exists("override-size",$options)==true && is_numeric($options["override-size"])==false) {
    echo "$Red_Color_Start Erreur : L'option override-size  ne marchera pas si --override-size a pour valeur des lettres.
    Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    return;
}
#Gestions D'erreur -p
if (array_key_exists("p",$options)==true && is_numeric($options["p"])==false) {
    echo "$Red_Color_Start Erreur : L'option padding  ne marchera pas si -p a pour valeur des lettres.
    Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    return;
}
if (array_key_exists("padding",$options)==true && is_numeric($options["padding"])==false) {
    echo "$Red_Color_Start Erreur : L'option padding  ne marchera pas si --padding a pour valeur des lettres.
    Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    return;
}


#Start my var
$Handle = fopen($Name_css,"w+"); // open the css at the beginning otherwise it erase everything again and again
$global_width =0 ; $global_height =0 ; $img_name = 0; $Size_All = 0; 
#Launch my code
Get_global_width_height();
Fusion_image();
fclose($Handle);




function Options(){
    $Red_Color_Start = "\033[31m ";
    $Color_End = "\033[0m";
    
    global $Name_Fusion_Img; global $Name_css; global $options;
    
    # Options of shell
    $options = getopt("ri::s::o::p::",["recursive","output-image::","output-style::","override-size::","padding::"]);
    
    
 
    
    #Options recursive
    if (array_key_exists("r",$options)==true || array_key_exists("recursive",$options)==true)
    {
        
        Scandir_recursive();
        
    }
    elseif (array_key_exists("r",$options)==false || array_key_exists("recursive",$options)==false) {
        Scandir_();
    }
    #Options name image
    if (array_key_exists("i",$options)==true)
    {
        if ($options["i"]==false) {
            $Name_Fusion_Img= "sprite.png";
        }
        elseif ($options["i"]==true) {
            $Name_Fusion_Img =$options["i"];
        }
       
        
        
    }
    elseif (array_key_exists("output-image",$options)==true) {
        if ($options["output-image"]==false) {
            $Name_Fusion_Img= "sprite.png";
        }
        elseif ($options["output-image"]==true) {
            
            $Name_Fusion_Img =$options["output-image"];
        }
    }
    elseif (array_key_exists("i",$options)==false || array_key_exists("output-image",$options)==false) {
        $Name_Fusion_Img ="sprite.png";
    }
    #Options name css
    if (array_key_exists("s",$options)==true)
    {
        if ($options["s"]==false) {
            $Name_css ="style.css";
        }
        else {
            $Name_css=$options["s"];
        }
        
        
    }
    elseif (array_key_exists("output-style",$options)==true) {
        if ($options["output-style"]==false) {
            $Name_css ="style.css";
        }
        else {
            $Name_css=$options["output-style"];
        }
    }
    elseif (array_key_exists("s",$options)==false || array_key_exists("output-style",$options)==false) {
        $Name_css ="style.css";
    }
    #Options size img 
    #Conditions and action in the function "fusion image"
    if (array_key_exists("o",$options)==true && $options["o"]==false) {
        
        echo "$Red_Color_Start Erreur : L'option override-size  ne marchera pas si -o n'a pas de valeur et donc n'aura aucn effet.
        Faites php Nomduscript -man pour voir le manuel.$Color_End\n";  
    }
    elseif (array_key_exists("override-size",$options)==true && $options["override-size"]==false) {
        echo "$Red_Color_Start Erreur : L'option override-size  ne marchera pas si --override-size n'a pas de valeur et donc n'aura aucn effet.
        Faites php Nomduscript -man pour voir le manuel.$Color_End\n";
    }
    
    #Options padding
    if (array_key_exists("p",$options)==true && $options["p"]==false) {
        
        echo "$Red_Color_Start Erreur : L'option padding ne marchera pas si -p n'a pas de valeur.
        Faites php Nomduscript -man pour voir le manuel.$Color_End\n";    
    }
    elseif (array_key_exists("padding",$options)==true && $options["padding"]==false) {
        echo "$Red_Color_Start Erreur : L'option padding ne marchera pas si --padding n'a pas de valeur.
        Faites php Nomduscript -man pour voir le manuel.$Color_End\n"; 
    }
    
}



function Scandir_recursive()
{
    
    # First part
    global $array_png ; global $array_dir; global $Path_Dir; global $n;global $Number_of_dir;
    
    
    
    $handle = opendir($Path_Dir);
    $Number_of_files= count(glob($Path_Dir."/*")); // count all files and dir in my dir
    
    
    #Second part
    
    for ($i=1; $i <=$Number_of_files+2 ; $i++) {
        
        $Tree_Dir=readdir($handle);
        $Info_Files = pathinfo($Tree_Dir); // get info of every files
        
        
        if ($Tree_Dir != "." && $Tree_Dir != "..") { // eception of dir . and ..
            
            $Tree_Dir_Full = $Path_Dir."/".$Tree_Dir; # make full path with names files 
            
            
            
            if (is_file($Tree_Dir_Full)==true) {
                
                if ($Info_Files['extension']=="png"){
                    $Tree_Dir= $Path_Dir."/".$Tree_Dir; # make the path + the name of the png
                    array_push($array_png,$Tree_Dir);
                    
                    
                }
                
            }
            elseif (is_dir($Tree_Dir_Full)==true) {
                $Tree_Dir= $Path_Dir."/".$Tree_Dir; # make the path + the name of the png
                array_push($array_dir,$Tree_Dir);
                
                
            } 
            
        }
    }
    #Third part
    
    
    
    $Number_of_dir= count($array_dir); // count all files and dir in my dir
    var_dump($Number_of_dir);
    
    if ($Number_of_dir == 0 ) {
        
        return null;
        
    }
    
    
    $full_path = $array_dir[0]; # take the path of the folder in the array
    
    
    array_shift($array_dir);
    
    
    $Path_Dir = $full_path;
    
    
    if ($n=$Number_of_dir-1) {
        
        $n=0;
    }
    
    for ($n; $n <=$Number_of_dir ; $n++) { 
        
        Scandir_recursive();
        
        
    }
    
}

function Scandir_()
{
    
    # First part
    global $array_png ; global $array_dir; global $Path_Dir; global $n; 
    
    
    
    $handle = opendir($Path_Dir);
    $Number_of_files= count(glob($Path_Dir."/*")); // count all files and dir in my dir
    
    
    #Second part
    
    for ($i=1; $i <=$Number_of_files+2 ; $i++) {
        
        $Tree_Dir=readdir($handle);
        $Info_Files = pathinfo($Tree_Dir); // get info of every files
        
        
        if ($Tree_Dir != "." && $Tree_Dir != "..") { // eception of dir . and ..
            
            $Tree_Dir_Full = $Path_Dir."/".$Tree_Dir; # make full path with names files 
            
            
            
            if (is_file($Tree_Dir_Full)==true) {
                
                if ($Info_Files['extension']=="png"){
                    $Tree_Dir= $Path_Dir."/".$Tree_Dir; # make the path + the name of the png
                    array_push($array_png,$Tree_Dir);
                    
                    
                }
                
            }
            elseif (is_dir($Tree_Dir_Full)==true) {
                $Tree_Dir= $Path_Dir."/".$Tree_Dir; # make the path + the name of the png
                array_push($array_dir,$Tree_Dir);
                
                
            } 
            
        }
    }
    
}



function Get_global_width_height(){
    
    global $global_width; global $global_height; global $array_png ; global $Number_of_png; global $options;
    
    $Number_of_png= count($array_png); // count all files and dir in my dir
    
    
    // boucle
    for ($i=0; $i <=$Number_of_png-1 ; $i++) { # start at 0 cause array start at 0
        
        
        
        $Size_png_global= getimagesize($array_png[$i]);
        
        if ($global_height<$Size_png_global[1]) { // if the height of png png is the most big then we save it
            
            $global_height = $Size_png_global[1];
            
        }
        
        $global_width+=$Size_png_global[0];
        
        
        
        
    }
    
    #Options padding
    if (array_key_exists("p",$options)==true)
    {
        $Number_of_png=$Number_of_png-1;# -1 for not make the last padding after the last pics
        var_dump($Number_of_png);
        $Padding_all = $options["p"]*$Number_of_png;
        $global_width = $global_width + $Padding_all;
        $Number_of_png=$Number_of_png+1; # we make again the variable with th right number for the rest of the code
    }
    elseif (array_key_exists("padding",$options)==true) {
        $Number_of_png=$Number_of_png-1;# -1 for not make the last padding after the last pics
        $Padding_all = $options["padding"]*$Number_of_png;
        $global_width = $global_width + $Padding_all;
        $Number_of_png=$Number_of_png+1; # we make again the variable with th right number for the rest of the code

    }
    elseif (array_key_exists("p",$options)==false  || array_key_exists("padding",$options)==false) {
        
    }
    
}



function Fusion_image(){
    
    global $global_width; global $global_height; global $Handle; global $img_name; global $Size_All;
    global $array_png ;global $Number_of_png; global $Name_Fusion_Img; global $options;global $Size_png_zero_resize; global $Size_png_resize;
    
    
    $Fusion_png=imagecreatetruecolor($global_width,$global_height);
    
    // Image numero 1
    $PNG_zero= imagecreatefrompng($array_png[0]);
    
    $Size_png_zero= getimagesize($array_png[0]);
    
    #Options size img 
    if (array_key_exists("o",$options)==true)
    {
        $Size_png_zero_resize=[$options["o"],$options["o"]]; # if -o give new size we save it in this var
        
    }
    elseif (array_key_exists("override-size",$options)==true) {
        $Size_png_zero_resize=[$options["override-size"],$options["override-size"]]; # if -o give new size we save it in this var

    }
    elseif (array_key_exists("o",$options)==false  || array_key_exists("override-size",$options)==false ) {
        $Size_png_zero_resize=[$Size_png_zero[0],$Size_png_zero[1]]; # if -o not exist we keep the same size
    }
    
    
    // Write css 
    $img_name= $array_png[0]; // put the path inside new var ( if i put in funct the loop never stop)
    cut_image_path_and_name($i=NULL);// call my func with var null cause they didn't exist for the moment then it's skip the bug message
    Fill_css($Size_png=NULL,$i,$Size_png_zero);
    
    
    imagecopyresampled($Fusion_png,$PNG_zero, 0, 0, 0, 0,$Size_png_zero_resize[0],$Size_png_zero_resize[1], $Size_png_zero[0], $Size_png_zero[1]);
    
    
    
    imagepng($Fusion_png,$Name_Fusion_Img);
    
    imagedestroy($PNG_zero);
    
    
    
    
    
    // boucle
    for ($i=1; $i <=$Number_of_png-1 ; $i++) {  # start at 1 cause we already did the 0 png of the array
        
        
        
        $PNG= imagecreatefrompng($array_png[$i]);
        $Size_png= getimagesize($array_png[$i]);
        
        #Options size img 
        if (array_key_exists("o",$options)==true)
        {
            $Size_png_resize=[$options["o"],$options["o"]];    
        }
        elseif (array_key_exists("override-size",$options)==true) {
            $Size_png_resize=[$options["override-size"],$options["override-size"]]; 
        }
        elseif (array_key_exists("o",$options)==false  || array_key_exists("override-size",$options)==false) {
            
        }
        
        
        
        if ($i==1) {
            
            // Write css 
            $img_name= $array_png[$i]; // put the path inside new var ( if i put in funct the loop never stop)
            cut_image_path_and_name($i);
            Fill_css($Size_png,$i,$Size_png_zero);
            
            #Options padding
            if (array_key_exists("p",$options)==true)
            {
                $Size_png_zero_resize[0]=$Size_png_zero_resize[0]+$options["p"];
                $Size_png_zero[0]=$Size_png_zero[0]+$options["p"];
            }
            elseif (array_key_exists("padding",$options)==true) {
                $Size_png_zero_resize[0]=$Size_png_zero_resize[0]+$options["padding"];
                $Size_png_zero[0]=$Size_png_zero[0]+$options["padding"];

            }
            elseif (array_key_exists("p",$options)==false  || array_key_exists("padding",$options)==false) {
                
            }
            
            #Options size img 
            if (array_key_exists("o",$options)==true || array_key_exists("override-size",$options)==true)
            {
                imagecopyresampled( $Fusion_png,$PNG,$Size_png_zero_resize[0], 0, 0, 0,$Size_png_resize[0],$Size_png_resize[1], $Size_png[0], $Size_png[1]);
                $Size_All = $Size_png_resize[0] + $Size_png_resize[1]; // get the larger of two first pics
                
            }
            elseif (array_key_exists("o",$options)==false  || array_key_exists("override-size",$options)==false) {
                imagecopy( $Fusion_png,$PNG, $Size_png_zero[0], 0, 0, 0, $Size_png[0], $Size_png[1]);
                $Size_All = $Size_png_zero[0] + $Size_png[0]; // get the larger of two first pics
                
            }
            
            imagepng($Fusion_png,$Name_Fusion_Img);
            
            imagedestroy($PNG);
            
            
            
            
        }
        elseif ($i!=1) {
            // Write css 
            $img_name= $array_png[$i]; // put the path inside new var ( if i put in funct the loop never stop)
            cut_image_path_and_name($i);
            Fill_css($Size_png,$i,$Size_png_zero);
            
           
            #Options padding
           if (array_key_exists("p",$options)==true)
            {
                $Size_All=$Size_All+$options["p"];
                
            }
            elseif (array_key_exists("padding",$options)==true) {
                $Size_All=$Size_All+$options["padding"];
            }
            elseif (array_key_exists("p",$options)==false  || array_key_exists("padding",$options)==false) {
                
            }
            #Options size img 
            if (array_key_exists("o",$options)==true || array_key_exists("override-size",$options)==true)
            {
                imagecopyresampled( $Fusion_png,$PNG, $Size_All, 0, 0, 0,$Size_png_resize[0],$Size_png_resize[1], $Size_png[0], $Size_png[1]);
                $Size_All += $Size_png_resize[0]; // add the larger of the new pics
            }
            elseif (array_key_exists("o",$options)==false  || array_key_exists("override-size",$options)==false) {
                imagecopy( $Fusion_png,$PNG, $Size_All, 0, 0, 0, $Size_png[0], $Size_png[1]);
                $Size_All += $Size_png[0]; // add the larger of the new pics
            }
            
            imagepng($Fusion_png,$Name_Fusion_Img);
            
            imagedestroy($PNG);
            
            
            
            
        }
        
    }
    
    
}

function cut_image_path_and_name($i)
{
    
    global $img_name; 
    
    if (preg_match('#/#', $img_name)) //check jusqu'au dernier /
    {
        $img_name = strpbrk($img_name, '/'); // cherche le premier /
        $img_name = substr($img_name, 1); // surpprime le caratere derriere
        
        return cut_image_path_and_name($img_name,$i);
    }
    
    
    $img_name = strrev($img_name);
    $img_name = strpbrk($img_name, '.');
    $img_name = strrev($img_name);
    $img_name = substr($img_name, 0, -1);
    
    
}


function Fill_css($Size_png,$i,$Size_png_zero){
    
    global $Handle; global $img_name; global $Size_All; global $options; global $Size_png_zero_resize; global $Size_png_resize;
    
    #Options size img 
    if (array_key_exists("o",$options)==true || array_key_exists("override-size",$options)==true)
    {
        
        if ($i==NULL) {
            
            fwrite($Handle,".img-".$img_name."{"."   background-position:0"."px 0px;"."   Width : $Size_png_zero_resize[0]px;"."   Height : $Size_png_zero_resize[1]px;"."}\n");
            
            
        }
        elseif ($i==1) {
            
            fwrite($Handle,".img-".$img_name."{"."   background-position: $Size_png_zero_resize[0]"."px 0px;"."   Width : $Size_png_resize[0]px;"."   Height : $Size_png_resize[1]px;"."}\n");
            
            
        }
        elseif ($i!=1) {
            
            fwrite($Handle,".img-".$img_name."{"."   background-position: $Size_All"."px 0px;"."   Width : $Size_png_resize[0]px;"."   Height : $Size_png_resize[1]px;"."}\n");
            
            
        }
    }
    elseif (array_key_exists("o",$options)==false || array_key_exists("override-size",$options)==false) {
        
        if ($i==NULL) {
            
            fwrite($Handle,".img-".$img_name."{"."   background-position:0"."px 0px;"."   Width : $Size_png_zero[0]px;"."   Height : $Size_png_zero[1]px;"."}\n");
            
            
        }
        elseif ($i==1) {
            
            fwrite($Handle,".img-".$img_name."{"."   background-position: $Size_png_zero[0]"."px 0px;"."   Width : $Size_png[0]px;"."   Height : $Size_png[1]px;"."}\n");
            
            
        }
        elseif ($i!=1) {
            
            fwrite($Handle,".img-".$img_name."{"."   background-position: $Size_All"."px 0px;"."   Width : $Size_png[0]px;"."   Height : $Size_png[1]px;"."}\n");
            
            
        }
        
    }   
    
}
