<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 다른 테마에서 이미 들어가 있다면 적용되지 않음
if ( defined('G5_GNB_LIB_EXISTS') ) { return; }
else { define( 'G5_GNB_LIB_EXISTS', true ); }

class GNB {
	
	protected $skin = '';
	protected $skin_path = '';
	protected $skin_url = '';
	
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
	
	// 상위메뉴 전체 출력
	protected function getGlobalMenu()
	{
		global $g5, $is_mobile;
		
		$conditions = array();
	    $conditions[] = "length(me_code) = '2'";
	    if ( $is_mobile && G5_USE_MOBILE )
	    {
		   $conditions['me_group'] = "me_group = 'M'"; 
		   $conditions['use'] = "me_mobile_use = '1'";
	    }
	    else
	    {
		   $conditions['me_group'] = "me_group = 'P'";
		   $conditions['use'] = "me_use = '1'";
	    }
	    
	    $condition = ( count( $conditions ) > 0 ? ' where ' . implode( ' and ', $conditions ) : '' );
	    $sql = " select * from {$g5['menu_table']}
					{$condition}
					order by me_order, me_id ";
		$result = sql_query($sql, false);
		$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
		$rows = array();
		while ( $row = sql_fetch_array( $result ) )
		{
			$conditions2 = array();
			$conditions2[] = $conditions['me_group'];
			$conditions2[] = $conditions['use'];
			$conditions2[] = "length(me_code) = '4'";
			$conditions2[] = "substring(me_code, 1, 2) = '{$row['me_code']}'";
			$condition2 = (count($conditions2) > 0 ? ' where ' . implode(' and ', $conditions2) : '');
			$sql2 = " select *
						from {$g5['menu_table']}
						{$condition2}
						order by me_order, me_id ";
			$result2 = sql_query($sql2);
			$children = array();
			$me_current = false;
			while ($child = sql_fetch_array($result2)) {
				$child['me_current'] = '';
				if ( $current = $this->currentGnb( $child ) ) {
					$me_current = true;
					$child['me_current'] = ( $current ? ' current ' : '' );
				}
				$children[ $child['me_code'] ] = $child;
			}
			$row['me_current'] = ( $me_current ? ' current ' : '');
			$row['items'] = $children;
			$rows[$row['me_code']] = $row;
		}
		return $rows;
	}
	// 선택된 메뉴
	protected function selected($menu) 
	{
		global $g5, $bo_table, $co_id;
		
		$me_link_parse = parse_url( $lnb['me_link'] );
		parse_str($me_link_parse['query'], $me_link_parameters);
		
		$is_define = ( defined('G5_MENU') && G5_MENU == $menu['me_code'] );
		$is_menu = preg_match( '/^' . preg_quote( $_SERVER['REQUEST_URI'], '/' )  . '$/' , $menu['me_link'] );
		$is_content = (isset($_REQUEST['co_id']) && preg_match( '/co_id=' . $_REQUEST['co_id'] . '/', $menu['me_link'] ) );
		$is_board = ( isset($_REQUEST['bo_table']) && $_REQUEST['bo_table'] == $me_link_parameters['bo_table'] );
		$is_shortlink = ( isset($_REQUEST['bo_table']) && preg_match( '/\/articles/' . $_REQUEST['bo_table'] . '/', $menu['me_link'] ) );
		
		if ( defined('_SHOP_') ) {
			$is_shop = (isset($_REQUEST['ca_id']) && preg_match( '/ca_id=' . $_REQUEST['ca_id'] . '/', $menu['me_link'] ) );
		}

		return ( $is_define || $is_menu || $is_content || $is_board || $is_shortlink || $is_shop );
	}
	// 현재 메뉴
	function currentGnb( $menu )
	{
		global $g5;
		
		
		if ( $this->selected($menu) )
		{
			return true;
		}
		
		return false;
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
	    		
		$rows = $this->getGlobalMenu();

	    ob_start();
	    include_once $this->skin_path.'/gnb.skin.php';
	    $content = ob_get_contents();
	    ob_end_clean();
	
	    return $content;
	}
}

$gnb = new GNB('basic');
?>