<?php
include_once('./_common.php');

include_once(G5_PLUGIN_PATH . '/PHPExcel/PHPExcel.php');
include_once(G5_PLUGIN_PATH . '/PHPExcel/PHPExcel/IOFactory.php');

if (isset($_FILES['import_excel']) && $_FILES['import_excel']['tmp_name']) {

	$objPHPExcel = new PHPExcel();

	try {
		// 이전 메뉴정보 삭제
		$sql = " delete from {$g5['menu_table']} ";
		sql_query($sql);

		//엑셀리더 초기화
		$objReader = PHPExcel_IOFactory::createReader("Excel2007");

		//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
		$objReader->setReadDataOnly(true);

		//업로드된 엑셀 파일 읽기
		$objPHPExcel = $objReader->load($_FILES['import_excel']['tmp_name']);

		// 첫번째 시트를 선택
		$objPHPExcel->setActiveSheetIndex(0);
	    $sheet = $objPHPExcel->getActiveSheet();

		 //시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$total_rows = count($sheetData);

		foreach($sheetData as $rows) {

			$me_code = $rows["A"]; //A열값을 가져온다.
			$me_name = $rows["B"]; //A열값을 가져온다.
			$me_link = '#';
		    /* 데이터 처리 */
			$sql = " insert into {$g5['menu_table']}
					set me_code         = '$me_code',
						me_name         = '$me_name',
						me_link         = '$me_link',
						me_target       = 'self',
						me_order        = '0',
						me_use          = '1',
						me_mobile_use   = '1' ";
			if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
			    $sql .= ", me_lang = '" . G5_I18N_LANG . "' ";
			}
			sql_query($sql);

		}
		goto_url($_SERVER['HTTP_REFERER']);
	} catch (exception $e) {
		die('엑셀 읽기 오류!!!' . $e->getMessage());
	}

} else {
	alert('엑셀파일을 업로드 해주세요.');
}