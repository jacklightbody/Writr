<?php
class Pagination{
	var $length;
	var $list;
	var $page;
	var $root;
	public function __construct($list,$page=0,$root){
		$this->length=count($list);
		$this->page=$page;
		$this->list=$list;
		$this->root=$root;
	}
	public function getList(){
		$start=10*$this->page;
		return array_slice($this->list,$start,10);
	}
	public function generateLinks(){
		$disp=$this->page+1;
		$dispd=$this->page;
		$dispd2=$this->page-2;
		$dispu2=$this->page+3;
		$dispu1=$this->page+2;
		$neg2=$this->page-2;
		$neg1=$this->page-1;
		$plus1=$this->page+1;
		$plus2=$this->page+2;
		$number=$this->calcPages();
		if($number>1){
			$links='<div class="pagination"><ul>';
			if($disp==1){
				$pclass="disabled";
				$neg2=$this->page;
				$neg1=$this->page;
			}
			if($disp==$number){
				$nclass="disabled";
				$plus1=$this->page;
				$plus2=$this->page;
			}
    		$links.='<li class="prev '.$pclass.'"><a href="'.$this->root.'&page='.$neg1.'">&larr; Previous</a></li>';
    		if($dispd2>1){
    			$links.='<li><a href="'.$this->root.'&page=1">1</a></li>';
    			$links.='<li><a href="#">...</a></li>';
    		}
    		if($dispd2>=1){
    			$links.='<li><a href="'.$this->root.'&page='.$neg2.'">'.$dispd2.'</a></li>';
    		}
    		if($dispd>=1){
    			$links.='<li><a href="'.$this->root.'&page='.$neg1.'">'.$dispd.'</a></li>';
    		}
   			$links.='<li class="active"><a href="#">'.$disp.'</a></li>';
   			if($dispu1<=$number){
   	   			$links.='<li><a href="'.$this->root.'&page='.$plus1.'">'.$dispu1.'</a></li>';
   	    	}
   	    	if($dispu2<=$number){
   	   			$links.='<li><a href="'.$this->root.'&page='.$plus2.'">'.$dispu2.'</a></li>';
   	   		}
    		if($dispu2<$number){
    			$links.='<li><a href="#">...</a></li>';
    			$links.='<li><a href="'.$this->root.'&page='.$number.'">'.$number.'</a></li>';
    		}
    		$links.='<li class="next '.$nclass.'"><a href="'.$this->root.'&page='.$plus1.'">Next &rarr;</a></li>';
			$links.='  </ul></div>';
			return $links;
		}
	}
	public function calcPages(){
		if($this->length % 10 == 0){
			return $this->length/10;
		}else{
			return intval($this->length/10)+1;
		}
	}
}