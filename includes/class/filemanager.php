<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /include/filemanager.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 12/04/2014, 12:30 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
Class FileManager{
	private $sub = array();
	public function __construct() {

	}
	public function copyFolderFile($src,$dst) { 
	    $dir = opendir($src); 
	    mkdir($dst);
	    @chmod($dst,0775);
	    while(false !== ($file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )&&($file!='.DS_Store') && ($file !='.temp')) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                $this->copyFolderFile($src . '/' . $file,$dst . '/' . $file); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	                chmod($dst . '/' . $file,0664);
	            } 
	        } 
	    } 
	    closedir($dir); 
	}
	public function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                $this->recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
	public function getItemDir( DirectoryIterator $dir )
		{
		  $accept = array('css','htm','html','js');
		  $data = array();
		  foreach ( $dir as $node )
		  {
		  	$ext= pathinfo($node, PATHINFO_EXTENSION);   	

		    if ( $node->isDir() && !$node->isDot() )
		    {
		      $data[$node->getFilename()] = array('type' => 'd',
		      	'name'=>$node->getFilename(),
		      	'size'=>count(glob($node->getPathname().'*')),
		      	'sub'=>$this->getItemDir( new DirectoryIterator( $node->getPathname() ) ));
		    }
		    else if ( $node->isFile() && preg_match('/^[A-Za-z0-9]+/', $node) && in_array($ext,$accept))
		    {
		      $data[] = array('type'=>'f','ext'=>$ext,'name'=>$node->getFilename(),'sub'=>null);
		    }
		  }
		  return $data;
		}
	
	//////////////////////////////////////////////////////////////////
    // Clean a path
    //////////////////////////////////////////////////////////////////

    public static function cleanPath( $path ){
    
        // replace backslash with slash
        $path = str_replace('\\', '/', $path );

        // prevent Poison Null Byte injections
        $path = str_replace(chr(0), '', $path );

        // prevent go out of the workspace
        while (strpos($path , '../') !== false)
            $path = str_replace( '../', '', $path );

        return $path;
    }
}
?>