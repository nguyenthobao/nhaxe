<?php
/**
 *
 */
class Minify {

	function __construct($base_url) {
		$this->base_url   = 'http://' . $base_url . '/';
		$this->dir_themes = str_replace('themes/', '', DIR_THEME);
	}
	/**
	 * [minifyCSS Ham su dung minify file css]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-07-11
	 * @param  [type]                     $cssFile [description]
	 * @param  integer                    $time    [description]
	 * @return [type]                              [description]
	 */
	public function minifyCSS($cssFile, $offset = 86400) {
		$modified = 0;
		// Enable caching
		$offset = 60 * 60 * 24 * 7; // Cache for 1 weeks
		header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $offset) . ' GMT');
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $modified) {
			header("HTTP/1.0 304 Not Modified");
			header('Cache-Control:');
		} else {
			$content = '';
			$path    = $this->dir_themes . $cssFile;
			$fp      = fopen($path, 'r');
			$content = fread($fp, filesize($path));
			fclose($fp);
			//Remove comments
			$content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
			// Remove space after colons
			$content = str_replace(': ', ':', $content);
			// Remove whitespace
			$content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
			// Enable GZip encoding.
			$this->cacheOb();
			header('Cache-Control: max-age=' . $offset);
			header('Content-type: text/css; charset=UTF-8');
			header('Pragma:');
			header("Last-Modified: " . gmdate("D, d M Y H:i:s", $modified) . " GMT");
			echo $content;
		}
	}
	
	public function minifyJS($jsFile, $offset = 86400) {
		$modified = 0;
		// Enable caching
		$content = '';
			$path    = $this->dir_themes . $jsFile;
			$fp      = fopen($path, 'r');
			$content = fread($fp, filesize($path));
			fclose($fp);
			//Remove comments
			$content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
			// Remove space after colons
			$content = str_replace(': ', ':', $content);
			// Remove whitespace
			$content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
			
			// Enable GZip encoding.
			$this->cacheOb();
		    $offset = 60 * 60 * 24 * 7; // Cache for 1 weeks
			header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $offset) . ' GMT');
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $modified) {
				header("HTTP/1.0 304 Not Modified");
				header('Cache-Control:');
			} else {
				
				header('Cache-Control: max-age=' . $offset);
				header('Content-type: text/javascript');
				header('Pragma:');
				header("Last-Modified: " . gmdate("D, d M Y H:i:s", $modified) . " GMT");
				
			} 
		echo $content;  
	}


	public function cacheOb() {
		if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
			ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS ^ PHP_OUTPUT_HANDLER_REMOVABLE);
		} else {
			ob_start(null, 0, false);
		}
	}
}
