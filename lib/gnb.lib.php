<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 다른 테마에서 이미 들어가 있다면 적용되지 않음
if ( defined('G5_GNB_LIB_EXISTS') ) { return; }
else { define( 'G5_GNB_LIB_EXISTS', true ); }

class GNB {

	protected $skin = '';
	protected $skin_path = '';
	protected $skin_url = '';
	protected $me_code_selected = null;
	protected $global_menu = null;
	function __construct($skin)
	{
		$this->setSkin( $skin );
	}
	public function setSkin( $skin )
	{
		global $is_mobile;

		$this->skin = $skin;
		if ( !$this->skin ) { $this->skin = 'basic'; }
		$skin_path = get_skin_path( 'menu', $this->skin );
		$skin_url = get_skin_url( 'menu', $this->skin );

        $this->skin_path = $skin_path;
        $this->skin_url = $skin_url;

	}

	// 하위메뉴 갯수
	protected function global_menu_count($me_code) {
		global $g5, $config;
		if(!$me_code) return 0;
		$me_code_len = strlen($me_code)+2;
		$sql = "select count(me_id) as count from {$g5[menu_table]} where me_code LIKE '{$me_code}%' and LENGTH(me_code) = {$me_code_len}";
		$result = sql_fetch($sql);

		return $result['count'];
	}

	// 도든 메뉴 불러오기(제귀함수)
	protected function global_menus($me_code = null){
		global $g5, $config, $is_mobile;
		$conditions = array();

		if (!$me_code) {
			$conditions['me_code_len'] = "LENGTH(me_code) = 2";
		} else {
			$conditions['me_parent'] = "me_code LIKE '{$me_code}%'";
			$conditions['me_code_len'] = "LENGTH(me_code) = " . (strlen($me_code) + 2);
		}

		if ( $is_mobile && G5_USE_MOBILE )
	    {
		   $conditions['me_use'] = "me_mobile_use = '1'";
	    }
	    else
	    {
		   $conditions['me_use'] = "me_use = '1'";
	    }

		if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
            $conditions['me_lang'] = "me_lang = '" . G5_I18N_LANG . "'";
        }

	    $condition = ( count( $conditions ) > 0 ? ' where ' . implode( ' and ', $conditions ) : '' );
	    $sql = " select * from {$g5['menu_table']} {$condition} order by me_order asc, me_code, me_id ";
		$result = sql_query($sql, true);
		$list = array();
		while($row = sql_fetch_array($result)) {
			$sub_count = $this->global_menu_count($row['me_code']); // 하위 메뉴 갯수

			if ($row['me_selected'] = $this->selected($row)) { // 해당 메뉴 항목
				$this->me_code_selected = $row['me_code'];
			}

			// 하위 메뉴가 있는 경우
			if( $sub_count > 0 ) {
				$row['items'] = $this->global_menus($row['me_code']);
			} else {
				$row['items'] = array();
			}

			$list[$row['me_code']] = $row;
		}
		return $list;
	}

	// 상위 메뉴 선택
	protected function get_selected_global_menu($menu, $me_code_selected, $type){
		$_menu = $menu;
		foreach ($menu as $key => $me){
			if ($me['me_use_' . $type] == 0)  {  // GNB, LNB 사용안함
				unset($_menu[$key]);
				continue;
			}
			if (in_array($me['me_code'], $me_code_selected)) {
				$me['me_selected'] = true;
			}
			if(count($me['items'])) {
				$me['items'] = $this->get_selected_global_menu($me['items'], $me_code_selected, $type);
			}
			$_menu[$key] = $me;
		}

		return $_menu;
	}
	// 전체 메뉴 리턴
	protected function get_global_menu($type="gnb")
	{
		global $g5;
		$this->global_menu = $menu = $this->global_menus();
		$me_code_selected = array();
		if ($this->me_code_selected) {
			$selectlen = strlen($this->me_code_selected);
			for($i=2; $i <= $selectlen; $i+=2) {
				$me_code = substr($this->me_code_selected, 0, $i);
				$me_code_selected[] = $me_code;
			}
		}
		$menu = $this->get_selected_global_menu($menu, $me_code_selected, $type);
		return $menu;
	}

	// 선택된 메뉴
	protected function selected($menu)
	{
		global $g5, $bo_table, $co_id;

		$me_link_parse = parse_url( $menu['me_link'] );
		parse_str($me_link_parse['query'], $me_link_parameters);
		$uri_segment = parse_url($_SERVER['REQUEST_URI']);

		$is_define = ( defined('G5_MENU') && G5_MENU == $menu['me_code'] );
		$is_menu = preg_match( '/^' . preg_quote( $_SERVER['REQUEST_URI'], '/' )  . '$/' , $menu['me_link'] );
		$is_content = (isset($_REQUEST['co_id']) && $_REQUEST['co_id'] == $me_link_parameters['co_id'] );
		$is_content_path = ($uri_segment['path'] == $me_link_parse['path']);
		$is_board = ( isset($_REQUEST['bo_table']) && $_REQUEST['bo_table'] == $me_link_parameters['bo_table'] );

		// 메뉴가 게시판이고 카테고리가 존재하는 경우 선택
		if ( $is_board && isset($me_link_parameters['sca']) && $_REQUEST['sca'] == $me_link_parameters['sca'] ) {
			$is_board = true;
		} else if ($is_board && isset($me_link_parameters['sca']) && $_REQUEST['sca'] != $me_link_parameters['sca']) {
			$is_board = false;
		}

		if ( defined('_SHOP_') ) {
			$is_shop = (isset($_REQUEST['ca_id']) && $_REQUEST['ca_id'] == $me_link_parameters['ca_id']);
		}

		return ( $is_define || $is_menu || $is_content || $is_content_path || $is_board || $is_shop );
	}

	function display( $skin = null )
	{
		global $g5, $bo_table, $w;

		if ( !is_null( $skin ) )
		{
			$this->setSkin( $skin );
		}
	    if ( !is_dir($this->skin_path) && !file_exists($this->skin_path) )
	    {
		    echo ( 'GNB 스킨 디렉토리가 존재하지 않습니다.' );
		    return false;
	    }

	    $gnb_skin_file = $this->skin_path . '/gnb.skin.php';
	    if ( !is_file($gnb_skin_file) && !file_exists($gnb_skin_file) )
	    {
		    echo ( 'GNB 스킨 파일이 존재하지 않습니다.' );
		    return false;
	    }

		$rows = $this->get_global_menu("gnb");

	    ob_start();
	    include_once $this->skin_path.'/gnb.skin.php';
	    $content = ob_get_contents();
	    ob_end_clean();

	    return $content;
	}
}

$gnb = new GNB('theme/basic');
?>
