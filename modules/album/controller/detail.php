<?php
/*
 * @Project BNC V2
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 * Frontend Album Detail Controller
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * detail album
 */
class detail extends Controller {

	public function view() {
		global $web;
		$modelDetail     = $this->loadModel('detail');
		$homeConfig      = @$this->cf->home_config;
		$modelDetail->id = $this->id->last;
		$data            = $modelDetail->detailAlbum();
		
		if (isset($data)) {
			$cate_id = explode(",", $data['category_id']);
			$cate_id = array_filter($cate_id);
			$cate_id = array_unique($cate_id);
			$cate_id = $cate_id[1];
			//them luot xem
			$modelDetail->views = $data['views'];
			$data['views']      = $modelDetail->visit();

			//link xem chi tiet
			if ($this->id->last == 0) {
				$href = $this->linkUrl('detail', 'view', $cate_id . '_' . $modelDetail->id, $data['alias']);
			} else {
				$href = $this->linkUrl('detail', 'view', $this->id->string . $modelDetail->id, $data['alias']);
			}
			$data['url'] = $this->linkUrl('detail', 'view', $modelDetail->id, $data['alias']);
			//album lien quan la day
			if (isset($data['my_related'])) {
				foreach ($data['my_related'] as $k => $v) {
					$v['link']              = $this->linkUrl('detail', 'view', $v['id'], $v['alias']);
					$data['my_related'][$k] = $v;
				}
			}
			if (isset($data['cate_related'])) {
				foreach ($data['cate_related'] as $k => $v) {
					$v['link']                = $this->linkUrl('detail', 'view', $v['id'], $v['alias']);
					$data['cate_related'][$k] = $v;
				}
			}
			//
			$data['count_des']   = strlen($data['contents_description']);
			$data['albumImages'] = $modelDetail->showImages();
			foreach ($data['albumImages'] as $k => $v) {
				$v['image']              = HTTP_STATIC . $v['src_link'];
				$data['albumImages'][$k] = $v;
			}
			//
			$head = array(
				'link'			=> $web['home_url'].'/'.$data['alias'].'-1-3-'.$data['id'].'.html',
				'title'         => $modelDetail->html_decode(($data['meta_title'] != '' ? $data['meta_title'] : $data['title'])),
				'keywords'      => $modelDetail->html_decode($data['meta_keywords']),
				'description'   => $modelDetail->html_decode($data['meta_description']),
				'ogtitle'       => $modelDetail->html_decode(($data['meta_title'] != '' ? $data['meta_title'] : $data['title'])),
				'ogimage'       => HTTP_STATIC . $data['avatar'],
				'ogsite_name'   => $modelDetail->html_decode(($data['meta_title'] != '' ? $data['meta_title'] : $data['title'])),
				'ogdescription' => $modelDetail->html_decode($data['meta_description']),
			);
			//breadcrumbs
			$breadcrumbsHomeModule = array(
				'text' => (!empty($homeConfig['title']) ? $homeConfig['title'] : lang('module_name')),
				'href' => $modelDetail->url_mod,
			);
			if (isset($this->id->ids) && $this->id->count >= 2) {
				//Loại bỏ đi 1 phần tử cuối cùng(vì phần tử cuối cùng là id của tin)
				array_pop($this->id->ids);
				foreach ($this->id->ids as $id) {
					$cat                    = $modelDetail->showCateById($id);
					$breadcrumbs_title[$id] = $cat['title'];
				}
				$breadcrumbs_album = array(
					'text' => $data['title'],
					'href' => $this->linkUrl('detail', 'view', ($this->id->ids) ? preg_replace('/_$/', '', $this->id->string) : $this->id->last, $data['alias']),
				);
				$breadcrumbs = array(
					'title' => $breadcrumbs_title,
					'page'  => 'category',
					'sub'   => '',
				);
				$data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule, null, $breadcrumbs_album);
			} else {
				$breadcrumbs_cat = array(
					'id'   => $cate_id,
					'text' => $modelDetail->showCateById($cate_id)['title'],
					'href' => $this->linkUrl('category', $cate_id),
				);
				$breadcrumbs_title[$modelDetail->id] = $data['title'];
				$breadcrumbs                         = array(
					'title' => $breadcrumbs_title,
					'page'  => 'detail',
					'sub'   => 'view',
				);
				$data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule, $breadcrumbs_cat);

				
			}
			//breadcrumbs end
			$data['restmedia'] = rand();
			$this->setTitle($head);
			$data['contents_description']=$this->getForm($data['contents_description']);
			$data['description']=$this->getForm($data['description']);
			// check url 
            // $str = substr($_SERVER['REQUEST_URI'],1);
            // preg_match('/([a-zA-Z0-9-]+)-2-3-([0-9]+).html/',$str,$match);
            // if(isset($match[1])){  
            //             $tmp_alias=$match[1];   
            // }
            // if($tmp_alias!=$data['alias']){     
            //              header('Location: /');
            // }
            
            // end check url
			
			$this->setContent($data, 'detail');
		} else {
			//Trang bạn tìm kiếm không tồn tại
			$this->notFound('detail');
		}

	}

	public function notFound($temp) {
		//Trang bạn tìm kiếm không tồn tại
		$data['breadcrumbs'][] = array(
			'text'      => lang('title_notfound'),
			'href'      => '#',
			'separator' => true,
		);

		//Set nội dung cho header
		$head = array(
			'title'       => lang('title_notfound'),
			'keywords'    => lang('title_notfound'),
			'description' => lang('description_notfound'),
		);
		$data['title']       = lang('title_notfound');
		$data['description'] = lang('description_notfound');
		//Gọi hàm đưa nội dung ra ngoài giao diện
		$this->setTitle($head);
		$this->setContent($data, $temp);
	}
}

?>