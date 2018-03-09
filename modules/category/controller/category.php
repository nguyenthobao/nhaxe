<?php
/**
 * @Project BNC v2 -> Module Category
 * @File category/controller/category.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 11/18/2014, 09:25 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
Class Category extends Controller {
	public function index() {
		global $_B, $web;
		$uri = $_B['curUrl']['URI'];
		$re  = "/^\/(.*)\.html/";
		preg_match($re, $uri, $uriNew);
		$data['curUrl'] = $uriNew[0];
		$modelCategory  = $this->loadModel('category');
		$categoryS      = $modelCategory->getCategoryList();
		$total          = $modelCategory->totalCategory();
		if (isset($categoryS)) {
			//Set nội dung cho header
			$head = array(
				'title'       => lang('title_category'),
				'keywords'    => lang('keyword_category'),
				'description' => lang('description_category'),
			);
			//set title breadcrumbs
			$breadcrumbsHomeModule = array(
				'text' => lang('title_category'),
				'href' => '',
			);

			if (isset($categoryS)) {
				foreach ($categoryS as $category) {
					$data['category'][$category[$this->id_field]] = $this->formatCategory($category);
				}
			} else {
				echo lang('notfound_data');
			}

			$data['breadcrumbs'] = $this->setBreadcrumbs(null, $breadcrumbsHomeModule);

			unset($categoryS);
			//Phân trang
			$data['pagination'] = $this->pagination(10, $total);

			//Gọi hàm set dữ liệu lên header
			$this->setTitle($head);
			//Gọi hàm đưa nội dung ra ngoài giao diện
			
			$this->setContent($data, 'category');

		} else {
			//Trang bạn tìm kiếm không tồn tại
			$data['breadcrumbs'][] = array(
				'text'      => lang('title_notfound'),
				'href'      => '',
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
			$this->setTitle($head);
			//Gọi hàm đưa nội dung ra ngoài giao diện
			
			$this->setContent($data, 'news_not_found');
		}
	}
	private function formatCategory($category) {
		global $_B,$web;
		$id = $category[$this->id_field];
		if ($this->id->last == 0) {
			$href = linkUrl($web,'category','detail', 'view', $this->id->string . $id, $category['alias']);
		}
		$categoryS = array(
			'id'    => $id,
			'title' => $category['title'],
			'short' => $category['short'],
			'href'  => $href,
		);
		return $categoryS;
	}
}