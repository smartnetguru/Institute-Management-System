<?php
  /* MySQL connection */
	$gaSql['user']       = $_SESSION['user'];
	$gaSql['password']   = $_SESSION['pass'];
	$gaSql['db']         = "simplyth_institute";
	$gaSql['server']     = "localhost";
	$gaSql['type']       = "mysql";
	
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	/* Paging */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	/* Ordering */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<mysql_real_escape_string( $_GET['iSortingCols'] ) ; $i++ )
		{
			$sOrder .= fnColumnToField(mysql_real_escape_string( $_GET['iSortCol_'.$i] ))."
			 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
		}
		$sOrder = substr_replace( $sOrder, "", -2 );
	}
	
	/* Filtering - NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE NAME LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "ID LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "COURSE LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ".
		                "BATCH LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%'";
	}

	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS NAME, ID, COURSE, BATCH, CHILD1, CHILD2, MOBILE
		FROM   students
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	$sQuery = "
		SELECT COUNT(ID)
		FROM   students
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	$sOutput = '{';
	$sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
	$sOutput .= '"iTotalRecords": '.$iTotal.', ';
	$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
	$sOutput .= '"aaData": [ ';
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$sOutput .= "[";
		$sOutput .= '"'.addslashes($aRow['NAME']).'",';
		$sOutput .= '"'.addslashes($aRow['ID']).'",';
		$sOutput .= '"'.addslashes($aRow['COURSE']).'",';
		$sOutput .= '"'.addslashes($aRow['BATCH']).'",';
		$sOutput .= '"'.addslashes($aRow['CHILD1']).'",';
		$sOutput .= '"'.addslashes($aRow['CHILD2']).'",';
		$sOutput .= '"'.addslashes($aRow['MOBILE']).'",';
		$sOutput .= "],";
	}
	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= '] }';
	
	echo $sOutput;
	
	
	function fnColumnToField( $i )
	{
		if ( $i == 0 )
			return "NAME";
		else if ( $i == 1 )
			return "ID";
		else if ( $i == 2 )
			return "COURSE";
		else if ( $i == 3 )
			return "BATCH";
		else if ( $i == 4 )
			return "CHILD1";
		else if ( $i == 5 )
			return "CHILD2";
		else if ( $i == 5 )
			return "MOBILE";
	}
?>