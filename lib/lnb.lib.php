<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// 	~/extend/lnb.extend.php 설정 파일
// 	메뉴에 없는 페이지는 최상위 LNB 위치 지정으로 LNB를 출력 할 수 있다.
//	define('G5_MENU', '1020'); 
//------------------------------------------------------------------------------

// 다른 테마에서 이미 들어가 있다면 적용되지 않음
if ( defined('G5_LNB_LIB_EXISTS') ) { return; }
else { define( 'G5_LNB_LIB_EXISTS', true ); }

class LNB extends GNB
{
	public $skin = '';
	public $lnb_menu = array();
	public $lnb_keys = array();
	public $exclude = array();
	public $current_lnb = array();
	public $current_menu = array();
	
	function __construct( $skin = null, $exclude = null )
	{

		if ( isset($skin) && trim($skin) != '' ) {
			$this->setSkin($skin);	
		}
		if ( isset( $exclude ) ) {
			$this->setExclude($exclude);
		}
		$this->lnb_menu = $this->getGlobalMenu();
		$this->lnb_keys = array_keys( $this->lnb_menu );
	}
	function setExclude( $exclude ) {
		$this->exclude = $exclude;
	}
	function selected( $key, $lnb ) 
	{
		global $g5, $bo_table, $co_id;
		
		$me_link_parse = parse_url( $lnb['me_link'] );
		parse_str($me_link_parse['query'], $me_link_parameters);
		
		$has_define = ( defined('G5_MENU') && G5_MENU == $key );
		$has_menu = preg_match( '/^' . preg_quote( $_SERVER['REQUEST_URI'], '/' )  . '$/' , $lnb['me_link'] );
		$has_content = ( isset($_REQUEST['co_id']) && $_REQUEST['co_id'] == $me_link_parameters['co_id'] );
		$has_board = ( isset($_REQUEST['bo_table']) && $_REQUEST['bo_table'] == $me_link_parameters['bo_table'] );
		
		if ( defined('_SHOP_') ) {
			$has_shop = (isset($_REQUEST['ca_id']) && preg_match( '/ca_id=' . $_REQUEST['ca_id'] . '/', $lnb['me_link'] ) );
		}
		
		return ( $has_define || $has_menu || $has_content || $has_board || $has_shop );
	}
	public function getLnb( $menus = null )
	{
		global $g5;
		
		if ( !count($menus) )
		{
			return null;
		}
		
	    foreach ( $menus as $key => $lnb )
		{
			
			if ( $this->selected( $key, $lnb ) )
			{
				$lnb_key = substr( $key, 0, 2 );
				return $this->lnb_menu[$lnb_key];
			}
			
			if ( count( $lnb['items'] ) > 0 )
			{
				$current_lnb = $this->getLnb($lnb['items']);
				if ( !is_null( $current_lnb ) )
				{
					return $current_lnb;
					break;
				}
			}
		}
	}
	
	public function current_lnb()
	{
		global $g5;
		
		if ( count( $this->current_lnb['items'] ) <= 0 )
		{
			return false;
		}
		foreach( $this->current_lnb['items'] as $key => $lnb )
		{
			if ( $this->selected( $key, $lnb ) )
			{
				return $lnb;
			}
		}
		
		return false;
	}
	function set_current_lnb( $lnb ) {
		global $g5;
		$this->current_lnb = $lnb;
	}
	function set_current_menu( $menu ){ 
		global $g5;
		$this->current_menu = $menu;
	}
	function get_current_menu(){
		return $this->current_menu;
	}
	function display_head( $skin = null ) 
	{
		global $g5, $config, $bo_table, $w;
		
		$content = '';
		if ( $skin && !is_dir( $this->skin_path ) && !file_exists($this->skin_path) ) {
			$this->setSkin($skin);
		}		
		if ( !is_dir( $this->skin_path ) && !file_exists($this->skin_path) )
		{
			echo 'LNB 스킨 디렉토리가 존재하지 않습니다.';
		}

		// G5_MENU 가 안먹힘..ㅠㅠ
		if ( !$this->current_lnb ) {
			$this->current_lnb = $this->getLnb($this->lnb_menu);
		}
		if ( is_null($this->current_lnb) ) {
			$this->current_lnb = array('me_name' => $config['cf_title']);
			$this->current_menu = array('me_name' => $g5['title']);
		}
		if ( !defined("_INDEX_") && !is_null( $this->current_lnb ) ) 
		{	
			if ( count($this->current_menu) <= 0 ) {
				$this->current_menu = $this->current_lnb();
				if ( in_array($currnt_menu['me_code'] , $this->exclude ) )
				{
					return false;
				}
			}
			
			if ( is_file( $this->skin_path . '/lnb.head.php' ) && file_exists( $this->skin_path . '/lnb.head.php' ) )
			{
				$this->title = $this->current_lnb['me_name'];
				$this->title_small = $this->current_lnb['me_sub_name'];
				
				$this->lnb = ( count($this->current_lnb['items']) > 0 ? $this->current_lnb['items'] : array() );
				ob_start();
				include( $this->skin_path . '/lnb.head.php' );
				$content = ob_get_contents();
				ob_end_clean();
			}
			else
			{
				echo 'LNB HEAD 파일이 존재하지 않습니다.';
			}
			
		}
		return $content;
	}
	
	function display_tail( $skin = null )
	{
		global $g5, $bo_table, $w;
		
		if ( !defined("_INDEX_") && !is_null( $this->current_lnb ) ) 
		{
			if ( is_file( $this->skin_path . '/lnb.tail.php' ) && file_exists( $this->skin_path . '/lnb.tail.php' ) )
			{
				ob_start();
				include( $this->skin_path . '/lnb.tail.php' );
				$content = ob_get_contents();
				ob_end_clean();
				
				return $content;
			}
			else
			{
				echo 'LNB TAIL 파일이 존재하지 않습니다.';
			}
		}
	}
	
	function lnb_aside( $name )
	{	
		$aside_path = $this->skin_path . '/aside/' . $name . '.php';
		if ( is_file( $aside_path ) && is_file( $aside_path ) )
		{
			ob_start();
			include( $aside_path );
			$aside = ob_get_contents();
		    ob_end_clean();
		
		    return $aside;
		}
	}
}
$lnb = new LNB('basic');

?>