<?
/**
 * @Project BNC v2 -> Frontend
 * @File /includes/class/pagination.php
 * @author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 11/04/2014, 15:36 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Pagination {
    private $max, $total, $parameter, $start = 0;

    private $i      = 0;
    private $href   = '';
    var $pagination = array();
    var $totalPage;

    function __construct($href, $max, $total, $max_items = 10, $parameter = 'p') {
        global $web;

        $this->max       = $max;
        $this->total     = $total;
        $this->parameter = $parameter;
        $this->max_items = $max_items;
        $this->get       = (!empty($_GET[$this->parameter]) && ($_GET[$this->parameter] <= $this->pages())) ? $_GET[$this->parameter] : 1;
       
        //prcess href
        //VD: href='/news-category-getList-333-lang-vi.html'
        $href = str_replace($web['dotExtension'], '', $href);
        $re   = "/-p([0-9]+)/i";
        if (preg_match($re, $href)) {
            $href = preg_replace($re, '-' . $parameter . '{nbh}' . $web['dotExtension'] . '?', $href);
        } else if ($this->get == 1) {
            $re = "/\\?/";
            if (preg_match($re, $href)) {
                $href = preg_replace($re, '-' . $parameter . '{nbh}' . $web['dotExtension'] . '?', $href);
            } else {
                $href .= '-' . $parameter . '{nbh}' . $web['dotExtension'];
            }

        } else {
            $href = str_replace($web['dotExtension'], "", $href);
            $href .= '-' . $parameter . '{nbh}' . $web['dotExtension'];
        }
        //Xoa bo ?
        $exls = explode('?', $href);
        if (count($exls) == 2 && $exls[1] != false) {
            $href = $exls[0] . '?' . $exls[1];
        } else {
            $href = str_replace('?', '', $href);
        }
        $exls_html=explode('.html', $href);
        if($exls_html[1]){
        	$href=str_replace('.html', '.html?', $href);
            $href=str_replace('??', '?', $href);
        }
        if($web['idw']==194 && count($_GET)==0){
            $href=str_replace('-p', 'product-p', $href);
        }
        // if(isset($_COOKIE['truong'])){
        //     echo '<pre>';
        //     print_r($_GET);
        //     echo '</pre>';
        //     die();
        // }
        // echo $hrefFirst;
        // $re = "/-p[0-9]+/";
        // if($this->get==1){
        //     if (preg_match($re,$hrefFirst)) {
        //         $hrefFirst = preg_replace($re, '-'.$parameter.'{nbh}', $hrefFirst);
        //     }else{
        //         $hrefFirst = str_replace($web['dotExtension'],"",$hrefFirst);
        //     }
        // }else{
        //     if (preg_match($re,$hrefFirst)) {
        //         $hrefFirst = preg_replace($re, '-'.$parameter.'{nbh}', $hrefFirst);
        //     }
        // }
        // echo '<br/>'.$hrefFirst;
        // $hrefFirst .= $web['dotExtension'];
        $this->pagination = array(
            'first'    => $this->first($href),
            'previous' => $this->previous($href),
            'numbers'  => $this->numbers($href),
            'next'     => $this->next($href),
            'last'     => $this->last($href),
            'info'     => $this->info(),
        );
        
    }

    function start() {
        $start = $this->get - 1;
        $calc  = $start * $this->max;
        return $calc;
    }
    function end() {
        $calc = $this->start() + $this->max;
        $r    = ($calc > $this->total) ? $this->total : $calc;
        return $r;
    }

    function pages() {
        return @ceil($this->total / $this->max);
    }
    function info() {
        $code = array(
            'total' => $this->total,
            'start' => $this->start() + 1,
            'end'   => $this->end(),
            'page'  => $this->get,
            'pages' => $this->pages(),
        );
        return $code;
    }

    function first($href) {
        if ($this->get != 1) {
            $nbh['num']  = 1;
            $nbh['href'] = str_replace('{nbh}', $nbh['num'], $href);
            return $nbh;
        }

    }

    function previous($href) {
        if ($this->get != 1) {
            $nbh['num']  = $this->get - 1;
            $nbh['href'] = str_replace('{nbh}', $nbh['num'], $href);
            return $nbh;
        }

    }

    function next($href) {
        if ($this->get < $this->pages()) {
            $nbh['num']  = $this->get + 1;
            $nbh['href'] = str_replace('{nbh}', $nbh['num'], $href);
            return $nbh;
        }

    }

    function last($href) {
        if ($this->get < $this->pages()) {
            $nbh['num']  = $this->pages();
            $nbh['href'] = str_replace('{nbh}', $nbh['num'], $href);
            return $nbh;
        }

    }
    function numbers($href, $reversed = false) {
        $r     = '';
        $range = floor(($this->max_items - 1) / 2);
        if (!$this->max_items) {
            $page_nums = range(1, $this->pages());
        } else {
            $lower_limit = max($this->get - $range, 1);
            $upper_limit = min($this->pages(), $this->get + $range);
            $page_nums   = range($lower_limit, $upper_limit);
        }

        if ($reversed) {
            $page_nums = array_reverse($page_nums);
        }

        foreach ($page_nums as $k => $i) {
            if ($this->get == $i) {
                $nbh['active']['num'] = $i;
            } else {
                $nbh[$k + 1]['num']  = $i;
                $nbh[$k + 1]['href'] = str_replace("{nbh}", $i, $href);
            }
        }
        return $nbh;
    }

    function paginator() {
        $this->i = $this->i + 1;
        if ($this->i > $this->start() && $this->i <= $this->end()) {
            return true;
        }
    }
}
