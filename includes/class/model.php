<?php
/**
 * @Project BNC v2 -> FrontEnd
 * @File /includes/class/model_core.php 
 * @author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 10/23/2014, 11:40 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
class Model extends ModelCore{ 
     /*
      *@data  array
      */
     public function insert1($data){               
        $dbname = explode('_',$this->name);
        if($dbname[1]=='contact'||$dbname[1]=='feedback') {
            $this->insert_core($data);
        }else{
            return false;
         }
        return false;
     }

     /*
      *@data  array 
      */
     public function update1($data){  
          return false;
     }         
     /* 
      */
     public function delete1(){      
          return false;
     }     
}
?>