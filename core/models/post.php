<?php 
defined('WRITR_LOADED') or die("Access Denied.");
/*
	Class: Post
    Deals with getting information for a post
    About:
    - file		post.php
	- version	1.0
	- date		11/9/2011
	- author	Jack Lightbody <jack.lightbody@gmail.com>
	- project	Writr
	- type		Model
*/
class Post {
	public $post;
	/*
	 Function: __construct
	
	Loads the current post
	
	See Also:
	
	   <getPostByID>
	   <getPostByPath>
	*/
	public function __construct($pID=1){
		$path=$_GET['path'];
		if(isset($pID)){
			$this->getPostByID($pID);
		}else{
			$this->getPostByPath($path);//otherwise we load the post
		}
	}
	/*
	 Function: getPostByID
	
	Loads a post from its post id
	
	Parameters:
	
	pID- the id of the post you want to load.
	
	See Also:
	
	   <__construct>
	   <getPostByPath>
	*/
	public function getPostByID($pID){
		$db=load::db();
		$p=$db->getAll('SELECT * FROM '.WRITR_PREFIX.'posts WHERE pID=?', array($pID));
		$this->post=$p[0];
	}
	/*
	 Function: getPostByPath
	
	Loads a post from its path from root
	
	Parameters:
	
	path- the path of the post from root you want to load.
	
	See Also:
	
	   <__construct>
	   <getPostByID>
	*/
	public function getPostByPath($path){
		$db=load::db();
    	$p=$db->getAll('SELECT * FROM '.WRITR_PREFIX.'posts WHERE pPath=?', array($path));
    	$this->post=$p[0];
	}	
	/*
	 Function: isValidPID
	
	Checks if a given post id references a valid post.
	
	Parameters:
	
	pID- the id of the post
	
	Returns:
	
	boolean true if the page exists
	*/
	public function isValidPID($pID){
		$db=load::db();
    	$pID=$db->getOne('SELECT pID FROM '.WRITR_PREFIX.'posts WHERE pID=?', array($pID));
    	if($pID){//if we found a result its valid
    		return true;
    	}else{
    		return false;
    	}
	}
	/*
	 Function: isValidPath
	
	Checks if a given path references a valid post.
	
	Parameters:
	
	path- the path of the post
	
	Returns:
	
	boolean true if the page exists
	*/
	public function isValidPath($path){
		$db=load::db();
    	$pID=$db->getOne('SELECT pID FROM '.WRITR_PREFIX.'posts WHERE pPath=?', array($path));
    	if($pID){//if we found a result its valid
    		return true;
    	}else{
    		return false;
    	}
	}
	/*
	 Function: getPostInfo
	
	Returns an array of all the page information
	
	Returns:
	
	post - array of the posts values
	*/
	public function getPostInfo(){ return $this->post;}
	public function getName(){ return $this->post['pName'];}
	public function getBody(){ return $this->post['pBody'];}
	public function getPath(){ return $this->post['pPath']; }
	public function getDraft(){ return $this->post['pIsActive']; }
	public function getTheme(){ return $this->post['pTheme']; }
	public function getID(){ return $this->post['pID']; }
	public function getAuthor(){ return $this->post['pAuthorID']; }
	public function getDatePublished(){ return $this->post['pDatePublished']; }
	public function getAllPosts(){
		$db=load::db();
		return $db->getAll('SELECT * from '.WRITR_PREFIX.'posts');
	}
	public function getPostsLimit($start=0,$end=10){
		$db=load::db();
		return $db->getAll('SELECT * from '.WRITR_PREFIX.'posts LIMIT ?,?',array($start,$end));
	}
	public function getAllLivePosts(){
		$db=load::db();
		return $db->getAll('SELECT * from '.WRITR_PREFIX.'posts where pIsActive=1');
	}
	public function addPost($name,$body,$path,$draft=1,$theme='default'){
		load::model('user');
		$uID=User::getLoggedIn();
		$db=load::db();
		if($db->getOne('SELECT pID FROM '.WRITR_PREFIX.'posts WHERE pPath=?',array($path))){//we need to check if this path is already taken
			$found=true;
			$i=1;
			while($found==true){
				$path=$path.'-'.$i;
				if(!$db->getOne('SELECT pID FROM '.WRITR_PREFIX.'posts WHERE pPath=?',array($path))){
					$found=false;//if path-i doesn't exist we use that as the path
				}else{
					$i++;//otherwise just increase i
				}
			}
		}
		$db->query('INSERT INTO '.WRITR_PREFIX.'posts (pName,pBody,pPath,pIsActive,pTheme,pAuthorID,pDatePublished) VALUES (?,?,?,?,?,?,?)',array($name,$body,$path,$draft,$theme,$uID,time()));
	}
	public function updatePost($id,$name,$body,$path,$draft=1,$theme='default'){
		$uID=User::getLoggedIn();
		$db=load::db();
		if($db->getOne('SELECT pID FROM '.WRITR_PREFIX.'posts WHERE pPath=?',array($path))){
			$found=true;
			$i=1;
			while($found==true){
				$path=$path.'-'.$i;
				if(!$db->getOne('SELECT pID FROM '.WRITR_PREFIX.'posts WHERE pPath=?',array($path))){
					$found=false;
				}else{
					$i++;
				}
			}
		}
		$db->query('UPDATE '.WRITR_PREFIX.'posts SET pName=?,pBody=?,pPath=?,pIsActive=?,pTheme=? WHERE pID=?',array($name,$body,$path,$draft,$theme,$id));
	}
	public function unpublish($id){
		$uID=User::getLoggedIn();
		$db=load::db();
		$db->query('UPDATE '.WRITR_PREFIX.'posts SET pIsActive=0 WHERE pID=?',array($id));
	}
	public function publish($id){
		$uID=User::getLoggedIn();
		$db=load::db();
		$db->query('UPDATE '.WRITR_PREFIX.'posts SET pIsActive=1 WHERE pID=?',array($id));
	}
	public function delete($pID){
		$db=load::db();
		$db->query('DELETE FROM '.WRITR_PREFIX.'posts WHERE pID=?',array($pID));
	}
	public function getEditLink(){
		$id=$this->post['pID'];
		return 'dashboard.php??path=writr&task=edit&id='.$id;
	}
}