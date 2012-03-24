<?php 
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Html
    Processes Html and Js files.
    Basically you pass this thing a css or js file with a bunch of optional items, and then it sorts 'em all.
    About:
    - file		load.php
	- version	1.0
	- date		11/9/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Helper
*/
class Html {
	var $collectedCssFiles=array();
	var $collectedJsFiles=array();
	var $nonFancyHeaderFiles=array();
	var $nonFancyFooterFiles=array();
	public static function singleton(){
	//we need to use a singleton design pattern here to keep all our css/js links
		//otherwise only the most recent is loaded
		static $instance;
        if (!isset($instance)) {
            $className = __CLASS__;
            $instance = new $className;
        }
        return $instance;
    }
	public function addHeaderItem($file){
		$ins=$this->singleton();
		$ins->nonFancyHeaderFiles[]=$file;
	}
	public function addFooterItem($file){
		$ins=$this->singleton();
		$ins->nonFancyFooterFiles[]=$file;
	}
	public function outputHeaderlinks(){
		$ins=$this->singleton();
		$items=$this->getPendingItems(0);
		$items=array_merge($items, $ins->nonFancyHeaderFiles);
		$list='';
		foreach($items as $item){
			$list.=$item;
		}
		return $list;
	}
	public function outputFooterlinks(){
		$ins=$this->singleton();
		$items=$this->getPendingItems(1);
		$items=array_merge($items, $ins->nonFancyFooterFiles);
		$list='';
		foreach($items as $item){
			$list.=$item;
		}
		return $list;
	}
	public function css($file, $extHandle = null,$compare=array()) {
		$ins=$this->singleton();
		if(isset($compare['handle'])){
			if(isset($ins->collectedCssFiles[$compare['handle']])){
				$v=explode(',', $ins->collectedCssFiles[$compare['handle']]);
				$v=$v[3];
				if(version_compare($compare['version'],$v,'>')){//if the version is greater than the one we already have then we use this new one.
					if(isset($compare['version'])&&is_numeric($compare['version'])){//if the version isn't given to us and we already have that handle we forget about it
						$footer=0;
						if(isset($compare['footer'])){
							$footer=$compare['footer'];
						}
						$ins->collectedCssFiles[$compare['handle']]=$extHandle.','.$footer.','.$file.','.$version;
					}
				}
			}else{
				$version=$compare['version'];
				if(!isset($compare['version'])){
					$version='0';//if we aren't given a version we assume its 0	
				}
				$footer=0;
				if(isset($compare['footer'])){
					$footer=$compare['footer'];
				}
				$ins->collectedCssFiles[$compare['handle']]=$extHandle.','.$footer.','.$file.','.$version;
			}
		}else{//if they haven't updated their file yet then don't give 'em the fancy treatment	
			// if the first character is a / then that means we just go right through, it's a direct path
			if (substr($file, 0, 1) == '/' || substr($file, 0, 4) == 'http' ) {
				return $this->getCssLink($file);
			}else{
				if(isset($extHandle)){
					if(file_exists(DIR_EXTENSIONS.'/'.$file)){
						return $this->getCssLink(DIR_EXTENSIONS.'/'.$file);
					}elseif(file_exists(DIR_CORE_EXTENSIONS.'/'.$file)){
						return $this->getCssLink(DIR_CORE_EXTENSIONS.'/'.$file);
					}
				}else{
					if(file_exists(DIR_CSS.'/'.$file)){
						return $this->getCssLink(DIR_CSS.'/'.$file);
					}elseif(file_exists(DIR_CORE_CSS.'/'.$file)){
						return $this->getCssLink(DIR_CORE_CSS.'/'.$file);
					}
				}
			}
		}
	}

	public function js($file, $extHandle = null,$compare=array()) {
		$ins=$this->singleton();
		if(isset($compare['handle'])){
			if(isset($ins->collectedJsFiles[$compare['handle']])){
				$v=explode(',', $ins->collectedJsFiles[$compare['handle']]);
				$v=$v[3];
				if(version_compare($compare['version'],$v,'>')){//if the version is greater than the one we already have then we use this new one.
					if(isset($compare['version'])&&is_numeric($compare['version'])){//if the version isn't given to us and we already have that handle we forget about it
						$footer=0;
						if(isset($compare['footer'])){
							$footer=$compare['footer'];
						}
						$ins->collectedJsFiles[$compare['handle']]=$extHandle.','.$footer.','.$file.','.$version;
					}
				}
			}else{
				$version=$compare['version'];
				if(!isset($compare['version'])){
					$version='0';//if we aren't given a version we assume its 0	
				}
				$footer=0;
				if(isset($compare['footer'])){
					$footer=$compare['footer'];
				}
				$ins->collectedJsFiles[$compare['handle']]=$extHandle.','.$footer.','.$file.','.$version;
			}
		}else{//if they haven't updated their file yet then don't give 'em the fancy treatment
			// if the first character is a / then that means we just go right through, it's a direct path
			if (substr($file, 0, 1) == '/' || substr($file, 0, 4) == 'http' ) {
				return $this->getJSLink($file);
			}else{
				if(isset($extHandle)){
					if(file_exists(DIR_EXTENSIONS.'/'.$file)){
						return $this->getJSLink(DIR_EXTENSIONS.'/'.$file);
					}elseif(file_exists(DIR_CORE_EXTENSIONS.'/'.$file)){
						return $this->getJsLink(DIR_CORE_EXTENSIONS.'/'.$file);
					}
				}else{
					if(file_exists(DIR_JS.'/'.$file)){
						return $this->getJsLink(DIR_JS.'/'.$file);
					}elseif(file_exists(DIR_CORE_JS.'/'.$file)){
						return $this->getJsLink(DIR_CORE_JS.'/'.$file);
					}
				}
			}
		}
	}
	public function getPendingItems($footer=0){
		$ins=$this->singleton();
		$info=array();
		foreach($ins->collectedJsFiles as $handle=>$data){
			$dataArr=explode(',',$data);
			$extHandle=$dataArr[0];
			$f=$dataArr[1];
			$file=$dataArr[2];
			//echo $footer;echo $f; echo $file;
			if($footer==$f){
				// if the first character is a / then that means we just go right through, it's a direct path
				if (substr($file, 0, 1) == '/' || substr($file, 0, 4) == 'http' ) {
					$info[]= $this->getJSLink($file);
				}else{
					if(isset($extHandle)&&$extHandle!=''){
						if(file_exists(DIR_EXTENSIONS.'/'.$file)){
							$info[]= $this->getJSLink(DIR_EXTENSIONS.'/'.$extHandle.'/'.DIR_JS.'/'.$file);
						}elseif(file_exists(DIR_CORE_EXTENSIONS.'/'.$file)){
							$info[]= $this->getJsLink(DIR_CORE_EXTENSIONS.'/'.$extHandle.'/'.DIR_JS.'/'.$file);
						}
					}else{
						if(file_exists(DIR_JS.'/'.$file)){
							$info[]=  $this->getJsLink(DIR_JS.'/'.$file);
						}elseif(file_exists(DIR_CORE_JS.'/'.$file)){
							$info[]= $this->getJsLink(DIR_CORE_JS.'/'.$file);
						}
					}
				}
			}
		}
		foreach($ins->collectedCssFiles as $handle=>$data){
			$dataArr=explode(',',$data);
			$extHandle=$dataArr[0];
			$f=$dataArr[1];
			$file=$dataArr[2];
			//echo $footer;echo $f; echo $file;
			if($footer==$f){
				// if the first character is a / then that means we just go right through, it's a direct path
				if (substr($file, 0, 1) == '/' || substr($file, 0, 4) == 'http' ) {
					$info[]= $this->getCssLink($file);
				}else{
					if(isset($extHandle)&&$extHandle!=''){
						if(file_exists(DIR_EXTENSIONS.'/'.$file)){
							return $this->getCssLink(DIR_EXTENSIONS.'/'.$file);
						}elseif(file_exists(DIR_CORE_EXTENSIONS.'/'.$file)){
							$info[]= $this->getCssLink(DIR_CORE_EXTENSIONS.'/'.$file);
						}
					}else{
						if(file_exists(DIR_CSS.'/'.$file)){
							$info[]= $this->getCssLink(DIR_CSS.'/'.$file);
						}elseif(file_exists(DIR_CORE_CSS.'/'.$file)){
							$info[]= $this->getCssLink(DIR_CORE_CSS.'/'.$file);
						}
					}
				}
			}
		}
		return $info;
	}


	public function getJsLink($file) {
		return '<script type="text/javascript" src="' . $file . '"></script>';
	}

	public function getCssLink($file) {
		return '<link rel="stylesheet" type="text/css" href="' . $file . '" />';
	}

}
