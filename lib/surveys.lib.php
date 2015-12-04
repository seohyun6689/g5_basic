<?php
if (!defined('_GNUBOARD_')) exit;

// 회원권한을 배열 형식으로 얻음
function get_member_level_array($start_id=0, $end_id=10)
{
    global $g5;
	$returns = array();
    for ($i=$start_id; $i<=$end_id; $i++) {
	    if ( !$g5['mb_level'][$i] ) continue;
        $returns[$i] = $g5['mb_level'][$i];
        
    }

    return $returns;
}

// 항목수 업데이트
function surveys_count_update( $su_id ) {
	global $g5;
	
	sql_query( "update {$g5['surveys_m_table']} set su_questions = (select count(suq_id) from {$g5['surveys_q_table']} where su_id = '{$su_id}' ) where su_id = '{$su_id}'" );
}


// 스킨폴더출력
function display_surveys($su_id = null, $skin_dir = 'basic'){
	global $g5, $member, $is_admin;
	
	$su_id = clean_xss_tags($su_id);
	
	if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $surveys_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/surveys/'.$match[1];
            if(!is_dir($surveys_skin_path))
                $surveys_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/surveys/'.$match[1];
            $surveys_skin_url = str_replace(G5_PATH, G5_URL, $surveys_skin_path);
        } else {
            $surveys_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/surveys/'.$match[1];
            $surveys_skin_url = str_replace(G5_PATH, G5_URL, $surveys_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $surveys_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/surveys/'.$skin_dir;
            $surveys_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/surveys/'.$skin_dir;
        } else {
            $surveys_skin_path = G5_SKIN_PATH.'/surveys/'.$skin_dir;
            $surveys_skin_url  = G5_SKIN_URL.'/surveys/'.$skin_dir;
        }
    }	

	$conditions = array(" su_removed = 0 ");
		
	if ( !is_null($su_id) ) {
		$conditions[] = whereClause( 'su_id', $su_id );
	} else if ( !$is_admin ) {	// 관리자는 기간설정이 없음
		$conditions[] = 'su_begin_time <= "' . date('Y-m-d H:i:s') . '"';  
		$conditions[] = 'su_end_time >= "' . date('Y-m-d H:i:s') . '"';  
	}
	$condition = ( count($conditions) ? ' where ' . implode( ' and ', $conditions ) : '' );
	$sql = "select * from {$g5['surveys_m_table']} " . $condition . ' order by su_id desc';
	$surveys = sql_fetch($sql);

	// 회원레벨설정
	$surveys_level = explode( ',' , $surveys['su_level'] );
	if ( $surveys != false && !in_array($member['mb_level'], $surveys_level) ) {
		$message = '설문조사 권한이 없습니다.';
	}	
	
	if ( $surveys['su_multiple'] == 'Y' ) {
		if ( $member ) {
			$sql = "select suq_id from {$g5['surveys_r_table']} where su_id = '{$surveys['su_id']}' and mb_id = '{$member['mb_id']}' group by mb_id ";
		} else {
			$sql = "select suq_id from {$g5['surveys_r_table']} where su_id = '{$surveys['su_id']}' and sur_ip = '{$_SERVER['REMOTE_ADDR']}' group by sur_ip ";
		}
		$has_result = sql_fetch($sql);
		if ( $has_result['suq_id'] ) {
			$message ='이미 설문조사에 참여하셨습니다. 현재 설문조사는 한번만 참여가 가능합니다.';
		}
	}
	
	if ( $surveys ) { 
		$categories = array();
		$sql ="select * from {$g5['surveys_c_table']} where su_id = '{$surveys['su_id']}'";
		$result = sql_query($sql);
		while ( $row = sql_fetch_array($result)){
			$categories[$row['suc_id']] = $row;
		}
		
		$group_surveys_items = array();
		$rows = array();
		$sql = "select * from {$g5['surveys_q_table']} q left join {$g5['surveys_c_table']} c on q.suq_category = c.suc_id where q.su_id = '{$surveys['su_id']}' order by suq_sort asc ";
		$result = sql_query($sql);
		while ($row = sql_fetch_array($result)){
			$rows[] = $row; 
			$group_surveys_items[$row['suc_id']][] = $row;
		}
	}
	ob_start();
	include_once( $surveys_skin_path . '/surveys.skin.php' );
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;
}

// 답변항목변형
function display_answer( $surveys, $row ) {
	global $g5;
	
	$content = '';
	for($i = 1; $i <= 10; $i++  ){
		$answer[$i] = $row['suq_answer_' . $i];
	}
	$answers = array_filter($answer);
	switch ( $row['suq_type'] ) {
		case 'table' :	// 표형식
			$th = array();
			$td = array();
			$width = ceil(100/count($answers));
			foreach ( $answers as $index => $answer ) {
				$th[] = '<th scope="col"><label for="answer_'  . $row['suq_id'] . '_' .  $index . '">' . $answer . '</label></th>';
				$td[] = '<td width="' . $width . '%"><input type="radio" name="answer_' . $row['suq_id'] . '[]" id="answer_'  . $row['suq_id'] . '_' .  $index . '" value="' . $index . '" /></td>';
			}
			$content .= '<table class="answer-table">' . PHP_EOL;
			$content .= '<thead>' . PHP_EOL;
			$content .= '<tr>' . PHP_EOL;
			$content .= implode( PHP_EOL, $th );
			$content .= '</tr>' . PHP_EOL;
			$content .= '</thead>' . PHP_EOL;
			$content .= '<tbody>' . PHP_EOL;
			$content .= '<tr>' . PHP_EOL;
			$content .= implode( PHP_EOL, $td );
			$content .= '</tr>' . PHP_EOL;
			$content .= '</tbody>' . PHP_EOL;
			$content .= '</table>' . PHP_EOL;
			break;
		case 'subjective' :	// 주관식
			
			$content .= '<table class="answer-subjective">' . PHP_EOL;
			$content .= '<tbody>' . PHP_EOL;
			$content .= '<tr>' . PHP_EOL;
			$content .= '<td>' .PHP_EOL;
			$content .= '<input type="hidden" name="answer_' . $row['suq_id'] . '[]" id="answer_'  . $row['suq_id'] . '" value="etc" />' . PHP_EOL;
			$content .= '<textarea name="answer_etc_' . $row['suq_id'] . '" class="subjective-textarea"></textarea></td>' . PHP_EOL;
			$content .= '</tr>' . PHP_EOL;
			$content .= '</tbody>' . PHP_EOL;
			$content .= '</table>' . PHP_EOL;
			
			break;
		default :
			if ( $row['suq_max_select'] > 1 ) {
				$inputtype = 'checkbox'; 
			} else {
				$inputtype = 'radio';
			}
			$content .= '<table class="answer-default">' . PHP_EOL;
			$content .= '<tbody>' . PHP_EOL;
			foreach ( $answers as $index => $answer ) {	
				$content .= '<tr>' . PHP_EOL;		
				$content .= '<td>' .PHP_EOL;
				$content .= '<input type="' . $inputtype . '" name="answer_' . $row['suq_id'] . '[]" id="answer_'  . $row['suq_id'] . '_' .  $index . '" value="' . $index . '" data-max="' . $row['suq_max_select'] . '" />' . PHP_EOL;
				$content .= '<label for="answer_'  . $row['suq_id'] . '_' .  $index . '">' . $answer . '</label>' . PHP_EOL;
				$content .= '</td>' . PHP_EOL;
				$content .= '</tr>' . PHP_EOL;
			}
			
			// 기타
			if ( $row['suq_enable_etc'] == 'enabled' ) {
				$content .= '</tr>' . PHP_EOL;
				$content .= '<td>' .PHP_EOL;
				$content .= '<input type="' . $inputtype . '" name="answer_' . $row['suq_id'] . '[]" id="answer_'  . $row['suq_id'] . '_etc" value="etc" data-max="' . $row['suq_max_select'] . '" />' . PHP_EOL;
				$content .= '<label for="answer_'  . $row['suq_id'] . '_etc">기타</label>' . PHP_EOL;
				$content .= '<textarea name="answer_etc_' . $row['suq_id'] . '" class="etc_textarea" data-target="#answer_'  . $row['suq_id'] . '_etc"></textarea>' . PHP_EOL;
				$content .= '</td>' . PHP_EOL;
				$content .= '</tr>' . PHP_EOL;
			}
			
			$content .= '</tbody>' . PHP_EOL;
			$content .= '</table>' . PHP_EOL;
		
	}
	return $content;
}
// 설문조사 인원 업데이트
function surveys_people_update($su_id) {
	global $g5;
	
	$sql = "update {$g5['surveys_m_table']} set su_people = su_people+1 where su_id = '{$su_id}'";
	sql_query($sql);
}


// 설문조사 결과
function answer_guest_count($su_id) {
	global $g5;
	
	$sql = "select count(sur_id) from {$g5['surveys_r_table']} where su_id = '$su_id' and mb_id = '' group by mb_id ";
	debugout( $sql );
}
function get_progress_width( $total, $value ) {
	
	if ( !$total || !$value ) return number_format( 0 ) . '%';
	$percent = ($value / $total);

	return number_format( $percent * 100 ) . '%';	
}
function answer_result( $surveys, $question ) {
	global $g5;
	
	$answers = array();
	$answers_etc = array();
	$sql = "select * from {$g5['surveys_r_table']} where su_id = '{$surveys['su_id']}' and suq_id = '{$question['suq_id']}'";
	$result = sql_query($sql);
	while( $answer = sql_fetch_array($result) ) {
		$answer_exp = explode( ',', $answer['sur_result'] );
		foreach ( $answer_exp as $answer_values ) {
			$answers[] = $answer_values;
		}
		if ( in_array('etc' , $answer_exp ) ) {
			$answers_etc[] = $answer['sur_etc_result'];
		}
	}
	$answer_count_values = array_count_values( $answers );
	$total = array_sum($answer_count_values);

	$content = '';
	$content .= '<ul>';
	if ( $question['suq_type'] == 'subjective' ) {
		$content .= '<li>';
		$content .= '<ol>';
		foreach ( $answers_etc as $etc) {
			if ( !$etc ) continue;
			$content .= '<li>' . $etc . '</li>';
				
		}
		$content .= '</ol>';
		$content .= '</li>';
	} else {
		foreach ( $question['answer'] as $index => $answer ) {
			$value = $answer_count_values[($index+1)];
			$content .= '<li>';
			$content .= '<table><tr><th><label>' . $answer . '</label></th>';
			$content .= '<td><div class="progress" style="width:' . get_progress_width($total , $value) . '">' . get_progress_width($total , $value) . '</div></td>';
			$content .= '<td class="result">' . number_format($answer_count_values[($index+1)]).'건' . '</td></tr></table>';
			$content .= '</li>';
		}
		
		if ( count($answers_etc) > 0 ) {
			$content .= '<li>';
			$content .= '<table><tr><th><label>기타</label></th>';
			$content .= '<td><ol class="answer-etc">';
			foreach ( $answers_etc as $etc ) {
				if ( !$etc ) continue;
				$content .= '<li>' . $etc . '</li>';
			}
			$content .= '</ol></td><td class="result">' . number_format($answer_count_values['etc']).'건' . '</td></tr></table>';
			$content .= '</li>';
		} 
	}
	$content .= '</ul>';
	
	return $content;
}

function answer_result_value( $su_id, $answer, $value ) { 
	global $g5;

	$suq_query = "select * from {$g5['surveys_q_table']} where su_id = '{$su_id}' and suq_id = '$answer' ";
	$fetch = sql_fetch($suq_query);
	$question_answer = array();
	for ( $i = 1; $i <= 10; $i++ ) {
		$question_answer[$i] = $fetch['suq_answer_'.$i];
	}

	$answer_etc_result = $_POST['answer_etc_' . $answer];
	$ex_value = explodE( ',', $value );
	$tmp_returns = array();
	foreach ( $ex_value as $user_answer ) {
		if ( $user_answer == 'etc' ) { 
			$tmp_returns[] = $answer_etc_result;
		} else { 
			$tmp_returns[] = $question_answer[$user_answer];	
		}
	}	
	
	return implode( ',', $tmp_returns);
}

?>