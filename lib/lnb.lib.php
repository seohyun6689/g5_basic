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
	public $exclude = array();
	public $current_lnb = array();
	public $current_menu = array();
	public $navi = array();
	
	function __construct( $skin = null, $exclude = null )
	{
		if ( isset($skin) && trim($skin) != '' ) {
			$this->setSkin($skin);	
		}
		if ( isset( $exclude ) ) {
			$this->setExclude($exclude);
		}
		$global_menu = $this->get_global_menu("lnb");
		$lnb_code_selected = substr($this->me_code_selected, 0, 2);
		$this->current_lnb = $global_menu[$lnb_code_selected];
	}
	function setExclude( $exclude ) {
		$this->exclude = $exclude;
	}
	function get_current_menu() {
		if (count($this->current_lnb['items'])<=0){ return null; }
		foreach($this->current_lnb['items'] as $item) {
			if($item['me_selected']) return $item;
		}
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

		if (is_null($this->current_lnb)) {
			$this->current_lnb = array('me_name' => $config['cf_title']);
			$this->current_menu = array('me_name' => $g5['title']);
		}
		if (!defined("_INDEX_") && !is_null($this->current_lnb)) 
		{	
			if ( count($this->current_menu) <= 0 ) {
				$this->current_menu = $this->get_current_menu();
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
				// navigation
				$this->get_navigations();
				if (count($this->navi) > 0) {
					$this->navi[count($this->navi)-1]['me_last'] = 'last';
				}

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
	// 네비게이션 배열
	private function navigation($menu){
		foreach($menu as $item) {
			if ($item['me_selected']) array_push($this->navi, array('me_name' => $item['me_name'], 'me_link' => $item['me_link']));
			if (count($item['items'])>0) { $this->navigation($item['items']); }
		}
	}
	function get_navigations(){
		array_push($this->navi, array('me_name' => $this->current_lnb['me_name'], 'me_link' => $this->current_lnb['me_link']));
		$this->navigation($this->current_lnb['items']);
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
$lnb = new LNB('theme/basic');

?>