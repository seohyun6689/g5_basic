<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_LIB_PATH . '/FirePHPCore/FirePHP.class.php');

$firephp = FirePHP::getInstance(true);


/*
*	firephp function.
*	디버깅용함수 (firephp를 이용)
*
* 	@access public
* 	@param mixed $value
* 	@param string $type (default: 'log', set: 'log', 'warn', 'error' )
* 	@return void
*/
function firephp($value, $type='log') {
	global $firephp;

	if( $type != 'log' AND $type != 'warn' AND $type != 'error')
	{
		$type = 'warn';
	}

	$firephp->{$type}($value);
}

/**
 * debugout function.
 * 디버깅용 함수 (울회사에서만 됨?)
 *
 * @access public
 * @param mixed $value
 * @param bool $stopProcess (default: false, true일경우 실행 중지)
 * @return void
 */
function debugout ( $value, $stopProcess = false )
{
	$remote_pass_addr = array( '127.0.0.1', '175.203.91.208' );
	if ( in_array( $_SERVER[ 'REMOTE_ADDR' ] , $remote_pass_addr ) )
	{
		ob_start();
		var_dump( $value );
		$dumped = ob_get_contents();
		ob_end_clean();

		$dumped = str_replace( "=>\n  ", ' => ', $dumped );

		echo _before();
		echo $dumped;
		echo _after();

		if ( $stopProcess !== false )
		{
			exit;
		}
	}
}

/**
 * exportVariable function.
 * 배열(주로 $_GET, $_POST)에 사용하려고 만든 함수
 * 배열의 키값으로 PHP 배열 소스를 생성
 *
 * @access public
 * @param mixed $input
 * @param mixed $valueFormat (default: null)
 * @return String
 */
function exportVariable ( $input, $valueFormat = null )
{
	ob_start();
	var_export( array_keys( $input ) );
	$content = ob_get_contents();
	ob_end_clean();

	$content   = preg_replace( '/\ +[0-9]+ \=\>\ /', '', $content );
	$lines     = explode( PHP_EOL, $content );
	$maxLength = 0;
	foreach ( $lines as $value )
	{
		$lines[ $key ] = trim( $value );
		$maxLength     = ( $maxLength < strlen( $value ) ) ? strlen( $value ) : $maxLength;
	}

	foreach ( $lines as $key => $value )
	{
		if ( strstr( $value, "'" ) )
		{
			$lines[ $key ] = str_pad( $value, $maxLength + 1 );
		}
	}

	$replaces = '    \'$1\'$3=> \'$1\'$2';
	if ( !is_null( $valueFormat ) )
	{
		$replaces = '    \'$1\'$3=> ' . sprintf( $valueFormat, '$1' ) . '$2';
	}

	$content = implode( PHP_EOL, $lines );
	$content = preg_replace( '/\'([^\']+)\'(,)([^\n]+)/', $replaces, $content );

	return $content;
}

//------------------------------------------------------------------------------

/**
 * _before
 *
 * @return    string
 */
function _before()
{
	$before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>'."\n";
	$before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>'."\n";
	$before .= '<pre>'."\n";
	return $before;
}

//------------------------------------------------------------------------------

/**
 * _after
 *
 * @return    string
 */

function _after()
{
	$after = '</pre>'."\n";
	$after .= '</div>'."\n";
	return $after;
}


//------------------------------------------------------------------------------

?>