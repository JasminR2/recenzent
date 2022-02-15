<?php

	header('Content-Type: application/json');

    require_once("../config.php");

    $_where = array();
	$_params = array();
	$_kategorijeSQL = $_gradoviSQL = $_where_sql = $_sort = '';
	$_currentday = strftime("%u");

	$i = 0;

	if(!empty($_REQUEST['kategorije']))
	{
		foreach($_REQUEST['kategorije'] as $_kategorije)
		{
			$i++;
			if($i === count($_REQUEST['kategorije'])) { $_kategorijeSQL .= "`kategorija` LIKE ?";}
			else { $_kategorijeSQL .= "`kategorija` LIKE ? OR "; }				
			$_params[] = "%". $_kategorije. "%";
		}
		$i = 0;
		$_where[] = $_kategorijeSQL;
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_REQUEST['gradovi']))
	{
		foreach($_REQUEST['gradovi'] as $_grad)
		{
			$i++;
			if($i === count($_REQUEST['gradovi'])) { $_gradoviSQL .= "`adresa` LIKE ?";}
			else { $_gradoviSQL .= "`adresa` LIKE ? OR "; }				
			$_params[] = "%". $_grad. "%";
		}
		$i = 0;
		$_where[] = $_gradoviSQL;
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_REQUEST['opste']))
	{
		foreach($_REQUEST['opste'] as $_opste)
		{
			$_where[] =  "JSON_EXTRACT(listingData, '$.opsteZnacajke') LIKE ?";
			$_params[] = "%" . $_opste . "%";
		}
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_REQUEST['covid-regulative']))
	{
		foreach($_REQUEST['covid-regulative'] as $_covid)
		{
			$_where[] = "JSON_EXTRACT(listingData, '$.covidRegulative') LIKE ?";
			$_params[] = "%". $_covid . "%";
		}
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_REQUEST['znacajke']))
	{
		foreach($_REQUEST['znacajke'] as $_znacajke)
		{
			$_where[] = "JSON_EXTRACT(listingData, '$.znacajkeKategorije') LIKE ?";
			$_params[] = "%". $_znacajke . "%";
		}
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_REQUEST['sortiranje']))
	{
		switch($_REQUEST['sortiranje']) {
			case 'najnoviji': { $_sort = 'id DESC'; break; }
			case 'najstariji': { $_sort = 'id ASC'; break; }
			case 'ocjenagore': { $_sort = 'prosjecnaOcjena DESC'; break; }
			case 'ocjenadole': { $_sort = 'prosjecnaOcjena ASC'; break; }
		}
	}

	if(!empty($_REQUEST['ocjena']))
	{	
		array_push($_where, "`prosjecnaOcjena` BETWEEN ? AND ?");
		array_push($_params, $_REQUEST['ocjena']['min']);
		array_push($_params, $_REQUEST['ocjena']['max']);
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_REQUEST['trenutno_otvoreno']))
	{
		$_days = ['Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota', 'Nedjelja'];
		$_where[] = "curtime() >= STR_TO_DATE(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(listingData, '$.radnoVrijeme." . $_days[strftime("%u")-1] . "')), '-', 1), '%H:%i') AND curtime() <= STR_TO_DATE(SUBSTRING_INDEX(JSON_UNQUOTE(JSON_EXTRACT(listingData, '$.radnoVrijeme." . $_days[strftime("%u")-1] . "')), '-', -1), '%H:%i')";
		$_where_sql = implode(" AND ", $_where);
	}

	if(!empty($_where_sql))
	{
		$sql = "SELECT * FROM listing WHERE $_where_sql ORDER BY `plan` DESC, $_sort";

		$stmt = $pdo->prepare($sql);
		$stmt->execute($_params);
		$_markeri = array();

		while($row = $stmt->fetch()) {
			$_currentStatus = '';
			$_data_arr[] = $row;
			$_listingData = json_decode($row['listingData'], true);

			$i = 0;
			foreach($_listingData['radnoVrijeme'] as $_day => $_workHours) {
				$i++;
				if($i == $_currentday) {
					if($_workHours != 'neradni dan')
					{
						$_radnoVrijeme = explode(" - ", $_workHours);
						if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
						$_openingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[0]);
						$_closingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[1]);
						$_currentTime = DateTime::createFromFormat("H:i", date("H:i"));
						if($_currentTime > $_openingAt && $_currentTime < $_closingAt) { $_currentStatus = '<p style="color:green;">Trenutno otvoreno</p>'; }
						else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
					}
					else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
				}
			}            
			$_data_arr = array_map(function($arr) use ($_currentStatus) { return $arr + ['currentStatus' => $_currentStatus]; }, $_data_arr);
		}

		foreach($_data_arr as $result) {
			if(!empty(json_decode($result['koordinate'])))
			{
				$_marker = json_decode($result['koordinate']);
				array_push($_markeri, array($result['naziv'], $_marker[0], $_marker[1], $result['id'], $result['adresa'], $result['prosjecnaOcjena']));
			}
		}
		echo json_encode(array("listing_data" => $_data_arr, "markeri_data" => $_markeri));
		$stmt = null;
	}	
	else
	{
		$sql = "SELECT * FROM listing ORDER BY `plan` DESC, $_sort";
		
		$stmt = $pdo->query($sql);
		$stmt->execute();
		$_markeri = array();

		while($row = $stmt->fetch()) {
			$_currentStatus = '';
			$_data_arr[] = $row;
			$_listingData = json_decode($row['listingData'], true);

			$i = 0;
			foreach($_listingData['radnoVrijeme'] as $_day => $_workHours) {
				$i++;
				if($i == $_currentday) {
					if($_workHours != 'neradni dan')
					{
						$_radnoVrijeme = explode(" - ", $_workHours);
						if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
						$_openingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[0]);
						$_closingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[1]);
						$_currentTime = DateTime::createFromFormat("H:i", date("H:i"));
						if($_currentTime > $_openingAt && $_currentTime < $_closingAt) { $_currentStatus = '<p style="color:green;">Trenutno otvoreno</p>'; }
						else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
					}
					else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
				}
			}            
			$_data_arr = array_map(function($arr) use ($_currentStatus) { return $arr + ['currentStatus' => $_currentStatus]; }, $_data_arr);
		}

		foreach($_data_arr as $result) {
			if(!empty(json_decode($result['koordinate'])))
			{
				$_marker = json_decode($result['koordinate']);
				array_push($_markeri, array($result['naziv'], $_marker[0], $_marker[1], $result['id'], $result['adresa'], $result['prosjecnaOcjena']));
			}
		}
		echo json_encode(array("listing_data" => $_data_arr, "markeri_data" => $_markeri));
		$stmt = null;
	}

?>