<?php
/**
 * @Project BNC v2 -> Module Info
 * @File info/controller/detail.php
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 11/18/2014, 10:25 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
Class Detail extends Controller {

	public function view() {		
		global $_B, $web;
		$uri = $_B['curUrl']['URI'];
		$re  = "/^\/(.*)\.html/";
		preg_match($re, $uri, $uriNew);
		$data['curUrl'] = $uriNew[0];

		$modelInfo = $this->loadModel('info');
		//$curUrl = $this->linkUrl('detail','view',$id);
		$id                    = $this->request->get_string('id', 'GET');
		$info                  = $modelInfo->getDetail($id);

		$breadcrumbsHomeModule = array(
			'text' => lang('title_info'),
			'href' => $this->linkUrl('info'),
		);
		if (isset($this->id->ids) && $this->id->count == 1) {
			$breadcrumbs_title[$this->id->last] = $info['title'];
			$breadcrumbs                        = array(
				'title' => $breadcrumbs_title,
				'page'  => 'detail',
				'sub'   => 'view',
			);
			$data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule);
		}
		
		$tags = explode(',', $info['tags']);
		foreach ($tags as $k => $v) {
			if (!empty($v)) {
				$href         = $web['home_url'].'/tag/'.fixTitle($v);
				$tagss[$href] = $v;
			}
		}
		$thumb              = $this->loadImage($info['img'], 'resize', 500, 200);
		$data['infoDetail'] = array(
			'id'               => $info[$this->id_field],
			'title'            => $info['title'],
			'thumb'            => $thumb,
			'img'              => $info['img'], //Load ảnh gốc,
			'details'          => $info['details'],
			'create_time'      => date("H:i:s d-m-Y", $info['create_time']),
			'tags'             => (isset($tagss)) ? $tagss : null,
			'meta_description' => $info['meta_description'],
			'view' => $info['view'],
		);
		if($info['meta_title']==true){
			$meta_title=$info['meta_title'];
		}else{
			$meta_title=$info['title'];
		}

		if($info['meta_keyword']==true){
			$meta_keyword=$info['meta_keyword'];
		}else{
			$meta_keyword=lang('keyword_info');
		}

		if($info['meta_description']==true){
			$meta_description=$info['meta_description'];
		}else{
			$meta_description=lang('description_info');
		}
		// $head = array(
		// 	'title'       => lang('title_info'),
		// 	'keywords'    => lang('keyword_info'),
		// 	'description' => lang('description_info'),
		// );

		$head = array(
			'title'       => $meta_title,
			'keywords'    => $meta_keyword,
			'description' => $meta_description,
		);
		$modelInfo->setView($id,$info['view']+1);
		$this->setTitle($head);
		$this->setContent($data, 'info_details');
	}
}