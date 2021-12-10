<?php
$array=[]; // make the array where i will put my .png
$Dir_name_sub =Null;
$Path_ALL=NULL;
Scandir_();
Scandir_Sub();


function Scandir_(){
    
    global $array; global $Dir_name_sub; global $Path_ALL;
    
    
    $handle = opendir('.');
    $Number_of_files= count(glob('*')); // count all files and dir in my dir
    for ($i=1; $i <=$Number_of_files+2 ; $i++) { 
        
        $Tree_Dir=readdir($handle);
        $Info_Files = pathinfo($Tree_Dir); // get info of every files
        
        if ($Tree_Dir != "." && $Tree_Dir != "..") { // eception of dir . and ..
            
            if (is_file($Tree_Dir)==true) {
                
                
                if ($Info_Files['extension']=="png"){
                    
                    array_push($array,$Tree_Dir);
                    
                }
            }
            elseif (is_dir($Tree_Dir)==true) {
                
                $Dir_name_sub =$Tree_Dir;
                
                
                
            }
        }
        
        
    }
   
}

function Scandir_Sub()
{
    global $array; global $Dir_name_sub; global $Path_ALL;
    
    $handle_sub = opendir($Dir_name_sub);
    
    $Number_of_files_sub= count(glob('*')); // count all files and dir in my dir
    
    for ($i=1; $i <=$Number_of_files_sub ; $i++) { 
        
        $Tree_Dir_sub=readdir($handle_sub); // read the name of file in dir
        var_dump($Tree_Dir_sub);
        sleep(1);
        $Info_Files_sub = pathinfo($Tree_Dir_sub); // get info of every files
        
        if ($Tree_Dir_sub != "." && $Tree_Dir_sub != "..") { 
            
            $Path_dir = $Dir_name_sub."/";
            
            $Path_ALL=$Path_dir.$Tree_Dir_sub;
            $Last_char= substr($Path_ALL, -1);
            
            
            if (is_file($Path_ALL)==true) {
                
                if ($Info_Files_sub['extension']=="png"){
                    
                    array_push($array,$Tree_Dir_sub);
                    
                }
            }
            elseif (is_dir($Path_ALL)==true && ($Last_char !="/")) {
                var_dump($Path_ALL);
                $Dir_name_sub =$Path_ALL;
                
                sleep(1);
                
                
            }
            
        }
       
        
    }
    Scandir_Sub();
    var_dump($array);
}




