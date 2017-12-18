<?php
namespace App;
// use Illuminate\Contracts\Pagination\Presenter;
use Illuminate\Pagination\BootstrapThreePresenter;

// class MyPaginationPresenter implements Presenter{
class MyPaginationPresenter extends BootstrapThreePresenter{
	public function hasPage(){

	}
	public function render(){
		if($this->hasPages()){
			return sprintf(
				'<ul class="am-pagination am-pagination-centered"> %s %s %s </ul>',
				$this->getPreviousButton(),
				$this->getLinks(),
				$this->getNextButton()
			);
		}
		return '';
	}
	protected function getAvailablePageWrapper($url,$page,$rel = null){
		$rel = is_null($rel) ? '' : 'rel="'.$rel.'"';
		return '<li><a href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a></li>';
	}
	protected function getDisabledTextWrapper($text){
		return '<li class="am-disabled"><span>'.$text.'</span></li>';
	}
	protected function getActivePageWrapper($text){
		return '<li class="am-active"><span>'.$text.'</span></li>';
	}
}