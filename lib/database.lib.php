<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  데이터베이스 관련 함수 모음
**
*************************************************************************/

/* DB */
function escapeStringForQuery ( $value )
{	
	return mysql_real_escape_string( trim(  stripslashes( $value ) ) );
}

function whereClause ( $columnName, $keyword, $usingLikeOperation = false )
{
	$keyword     = $keyword . '';
	$queryFormat = ( $usingLikeOperation === false ) ? '`%s` = "%s"' : '`%s` LIKE "%%%s%%"';
	
	if ( !is_string( $columnName ) && is_int( $columnName ) )
	{
		$queryFormat = '%s%s';
		$columnName  = '';
	}
	
	if ( $usingLikeOperation === 2 )
	{
		$queryFormat = '`%s` LIKE "%s%%"';
	}
	else if ( $usingLikeOperation === 3 )
	{
		$queryFormat = '`%s` LIKE "%%%s"';
	}
	
	$columnName = strstr( $columnName, '.' ) ? str_replace( '.', '`.`', $columnName ) : $columnName;
	
	return sprintf( $queryFormat, $columnName, escapeStringForQuery( $keyword ) );
}

function whereClauseWithFunction ( $columnName, $functionName )
{
	$columnName = strstr( $columnName, '.' ) ? str_replace( '.', '`.`', $columnName ) : $columnName;
	
	return sprintf( '`%s` = %s', $columnName, $functionName );
}
function generateQuery ( $data, $tableName, $dateColumns = null, $conditions = null )
{
	$query = null;
	
	if ( !is_null( $dateColumns ) )
	{
		$dateColumns = is_array( $dateColumns ) ? $dateColumns : array( $dateColumns );
		
		$dateTypes = array(
			'datetime'  => 'NOW()',
			'date'      => 'CURDATE()',
			'time'      => 'CURTIME()',
			'timestamp' => 'UNIX_TIMESTAMP()'
		);
	}
	
	if ( is_null( $conditions ) )
	{
		$queryFormat = 'INSERT INTO `%s` ( %s ) VALUES ( %s )';
		
		$dataFixed = array();
		foreach ( $data as $column => $value )
		{
			if ( is_null( $value ) )
			{
				continue;
			}
			
			if ( substr( $column, 0,1 ) == '#' )
			{
				$dataFixed[ '`' . substr( $column, 1 ) . '`'  ] = $value;
			}
			else if ( substr( $column, 0,1 ) == '!' )
			{
				$dataFixed[ '`' . substr( $column, 1 ) . '`'  ] = 'PASSWORD( "' . $value . '" )';
			}
			else if ( $value === 0 )
			{
				$dataFixed[ '`' . $column . '`'  ] = $value;
			}
			else
			{
				$dataFixed[ '`' . $column . '`'  ] = '"' . escapeStringForQuery( $value ) . '"';
			}
		}
		
		if ( !is_null( $dateColumns ) )
		{
			$columnsToAppend = array();
			$valuesToAppend  = array();
			foreach ( $dateColumns as $columnType => $columnName )
			{
				$dateType  = strtolower( $columnType );
				$dateValue = isset( $dateTypes[ $dateType ] ) ? $dateTypes[ $dateType ] : 'NOW()';
				
				if ( is_string( $columnName ) )
				{
					$dataFixed[ '`' . $columnName . '`'  ] = $dateValue;
				}
				else
				{
					foreach ( $columnName as $childrenName )
					{
						$dataFixed[ '`' . $childrenName . '`'  ] = $dateValue;
					}
				}
			}
		}
		
		$columns = implode( ', ', array_keys( $dataFixed ) );
		$values  = implode( ', ', array_values( $dataFixed ) );
		
		$query = sprintf( $queryFormat, $tableName, $columns, $values );
	}
	else
	{
		$queryFormat = 'UPDATE `%s` SET %s WHERE %s';
		
		$values = array();
		foreach ( $data as $column => $value )
		{
/*
			if ( is_null( $value ) )
			{
				continue;
			}
*/
			
			if ( substr( $column, 0,1 ) == '#' )
			{
				$values[] = whereClauseWithFunction( substr( $column, 1 ), $value );
			}
			else if ( substr( $column, 0,1 ) == '!' )
			{
				$values[] = whereClauseWithFunction( substr( $column, 1 ), 'PASSWORD( "' . $value . '" )' );
			}
			else if ( is_null( $value ) || $value === 0 )
			{
				$values[] = ' `' . $column . '` = "' . $value . '"';
			}
			else
			{
				$values[] = whereClause( $column, $value );
			}
		}
		
		if ( !is_null( $dateColumns ) )
		{
			$columnsToAppend = array();
			$valuesToAppend  = array();
			foreach ( $dateColumns as $columnType => $columnName )
			{
				$dateType  = strtolower( $columnType );
				$dateValue = isset( $dateTypes[ $dateType ] ) ? $dateTypes[ $dateType ] : 'NOW()';
				
				if ( is_string( $columnName ) )
				{
					$values[] = whereClauseWithFunction( $columnName, $dateValue );
				}
				else
				{
					foreach ( $columnName as $childrenName )
					{
						$values[] = whereClauseWithFunction( $childrenName, $dateValue );
					}
				}
			}
		}
		
		$where = array();
		if ( is_array( $conditions ) )
		{
			foreach ( $conditions as $column => $value )
			{
				$where[] = whereClause( $column, $value );
			}
			$where  = implode( ' AND ', $where );
		}
		else
		{
			$where = $conditions;
		}
		
		$values = implode( ', ', $values );
		

		$query  = sprintf( $queryFormat, $tableName, $values, $where );
	}
	
	
	return $query;
}
?>