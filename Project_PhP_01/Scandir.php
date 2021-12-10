<?php

#Start my var
$Path_Dir =$argv[1];
$array_png=[]; // make the array where i will put my .png
$array_dir=[]; // make the array where i will put my dir
$n=0;
#Launch my code
Scandir_();




function Scandir_()
{
    
    # First part
    global $array_png ; global $array_dir; global $Path_Dir; global $n; 
    // echo "\nPath:\n";
    //var_dump($Path_Dir);
    
    
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
    // echo "Array_dir:\n";
    // var_dump($array_dir);
    
    $Number_of_dir= count($array_dir); // count all files and dir in my dir
    var_dump($Number_of_dir);
    echo "Array_png:\n";
    var_dump($array_png);
    if ($Number_of_dir == 0 ) {
        return false;
    }
    
    
    $full_path = $array_dir[0]; # take the path of the folder in the array
    
    
    array_shift($array_dir);
    
    
    $Path_Dir = $full_path;
    
    // var_dump($full_path);echo "////";
    # var_dump($Path_Dir);echo "////";
    
    
    
    
    
    
    if ($n=$Number_of_dir-1) {
        $n=0;
    }
    
    for ($n; $n <=$Number_of_dir ; $n++) { 
        
        Scandir_();
    }
    
}




