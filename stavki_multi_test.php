<?
error_reporting(0);
require_once ( "$DOCUMENT_ROOT/incl_main/dBug.php" );

function DiffScore( $val )
{
	$arr = explode ( ':', $val );
	
	$diff = $arr[0] - $arr[1];
	
	return $diff;
}

function sign($a) 
{
	if( $a>0) return 1; 
	else if ( $a < 0 ) return -1; 
	else return 2;
}

function CountSums ( $v, $sum_compare, $name_compare )
{
	$arr = array();
	$total_sum = 0;
	
	foreach ( $v AS $name => $sum )
	{
		if ( $name != $name_compare )
		{
			$arr[$name] = $sum_compare - $sum;
			$total_sum += ( $sum_compare - $sum );
		}
	}
	$arr['total'] = $total_sum;
	
	return $arr;
}

if ( $_REQUEST['todo'] == 'form_2' )
{

$file = file ( 'results.txt' );

$ResultsArr  = array();

foreach ( $file AS $str )
{
	$arr_t = explode( '|', $str );
	$arr_t[0] = intval( $arr_t[0] );
	$ResultsArr[$arr_t[0]] = array( 'numb' => trim ( $arr_t[0] ), 'who' => trim ( $arr_t[1] ), 'where' => trim ( $arr_t[2] ), 'users' => array (  'serg' => trim ( $arr_t[3] ), 'alex' => trim ( str_replace ( '-', ':', $arr_t[4] ) ), 'father' => trim ( $arr_t[5] ), 'alena' => trim ( str_replace ( '-', ':', $arr_t[6] ) ) ) );
}


//ksort( $ResultsArr );

//new d( $ResultsArr, '$ResultsArr' );


$i = 0;

//$RealResults = array ( '2:0','1:1','2:1','0:0','1:1','1:0','2:1','0:2','1:0','2:2','0:0','1:0','3:0','1:1','2:1','1:0','2:2','1:0','3:1','0:2','0:0','4:0','1:1','0:0','1:0','1:3','0:0','2:0','2:2','0:1','2:1','1:1','2:2','0:1','1:1','2:1','2:0','1:1','1:1','0:1','1:1','0:0','1:1','1:0','2:1','0:3','0:2','1:1' );

$arr_names = array( 'serg', 'alex', 'alena', 'father' );

$RealResults = array();

	$letter = 'A';
	$t = 64;	

	$result_sum 	= 200;
	$diff_score_sum = 140;
	$ishod_sum 		= 80;
	
$SuperTotal = array();

for ( $r = 0; $r < 500; $r++ )
{
	$TheSameArr  = $RaznArr = $IshodArr = $GroupsArr = $GroupsResults = $TotalSums = $MatchNames = array();
	
foreach ( $ResultsArr AS $match_numb => $v )
{
	/*if ( $v['serg'] == $v['alex'] && $v['serg'] == $v['alena'] )
		$TheSameArr[] = $v;*/
		
//	$real_result = $RealResults[$i];


	if ( $select_user == 'random' || $random )
	{
		$random = true;
		$key = array_rand( $arr_names );
		$select_user = $arr_names[$key];
	}
	
	$MatchNames[$match_numb] = $v['who'];
	
	foreach ( $v['users'] AS $name => $result )
	{
		if ( $name == $select_user )
		{
			$real_result = $result;
			break;
		}
	}
	
	$j = 0;
	$diff = false;
	foreach ( $v['users'] AS $name => $result )
	{
		
		$TotalSums[$match_numb][$name] = ( $result == $real_result ? $result_sum : ( DiffScore( $result ) == DiffScore( $real_result ) ? $diff_score_sum : ( sign( DiffScore( $result ) ) == sign( DiffScore( $real_result ) ) ? $ishod_sum : 0 ) ) );
		
		if ( $j == 0 )
			$compare = $result;
		elseif ( $result != $compare )	
		{
			$diff = true;
//			break;
		}
		$j++;
	}
	
	
	
/*	if ( !$diff )
		$TheSameArr[] = $v;*/
		
	/*if ( $diff )
	{
		$j = 0;
		$diff = false;
		foreach ( $v['users'] AS $name => $result )
		{
			if ( $j == 0 )
				$compare =  DiffScore( $result );
			elseif ( DiffScore( $result ) != $compare )	
			{
				$diff = true;
				break;
			}
			$j++;
		}
		
		if ( !$diff )
			$RaznArr[] = $v;
	}*/
	
	/*if ( $diff )
	{
		$j = 0;
		$diff = false;
		foreach ( $v['users'] AS $name => $result )
		{
			if ( $j == 0 )
				$compare =  sign( DiffScore( $result ) );
			elseif ( sign ( DiffScore( $result ) ) != $compare )	
			{
				$diff = true;
				break;
			}
			$j++;
		}
		
		if ( !$diff )
			$IshodArr[] = $v;
	}*/
	
		
	/*elseif ( DiffScore( $v['serg'] ) == DiffScore( $v['alex'] ) && DiffScore( $v['serg'] )  == DiffScore( $v['alena'] ) ) 
		$RaznArr[] = $v;
		
	elseif ( sign(DiffScore( $v['serg'] ) ) == sign( DiffScore( $v['alex'] ) ) && sign( DiffScore( $v['serg'] ) ) == sign( ( $v['alena'] ) ) && sign(DiffScore( $v['alena'] ) ) == sign( DiffScore( $v['alex'] ) ) )
	{
		$IshodArr[] = $v;
	}*/
	


	/*if ( $i % 6 == 0 )
	{
		$t++;
		$letter = chr ( $t );
		
 	}
 	
 	if ( !is_array( $GroupsArr[$letter] ) )
 		$GroupsArr[$letter]  = array();
		
	$arr2 = explode ( '--', $v['who'] );
	
	$first_team = trim ( $arr2[0] );
	$second_team = trim ( $arr2[1] );
	
	if ( !$GroupsArr[$letter][$first_team] )
		$GroupsArr[$letter][$first_team] = 1;
		
	if ( !$GroupsArr[$letter][$second_team] )
		$GroupsArr[$letter][$second_team] = 1;
		
	foreach ( $v['users'] AS $name => $result )
	{
		$arr = explode ( ':', $result );
		
//		if ( $name = 'serg' && $first_team == 'Украина' || )
		
		$GroupsResults[$letter][$name][$first_team]['goals'] += $arr[0];
		$GroupsResults[$letter][$name][$first_team]['goals_p'] += $arr[1];
		$GroupsResults[$letter][$name][$first_team]['points'] += ( sign ( DiffScore( $result ) ) == 1 ? 3 : ( sign ( DiffScore( $result ) ) == -1 ? 0 : 1 ) );
		
		$GroupsResults[$letter][$name][$second_team]['goals'] += $arr[1];
		$GroupsResults[$letter][$name][$second_team]['goals_p'] += $arr[0];
		$GroupsResults[$letter][$name][$second_team]['points'] += ( sign ( DiffScore( $result ) ) == 1 ? 0 : ( sign ( DiffScore( $result ) ) == -1 ? 3 : 1 ) );
		
	}*/
	
	
	$i++;
}


$EndResults = array();

foreach ( $TotalSums AS $match_numb => $v )
{
	foreach ( $v AS $name => $sum )
	{
		$EndResults[$match_numb][$name] =  CountSums ( $v, $sum, $name );
	}
	
}

	foreach ( $EndResults AS $match_numb => $v )
	{
		foreach ( $v as $name => $v1 ) 
		{
			$SuperTotal[$name] += $v1['total'];
		}
	}
}

?>
<table width="600">
<?
?>
<tr bgcolor="Yellow" style="font-weight:bold;">
<td colspan="2">$SuperTotal</tr>	
<?
foreach ( $SuperTotal as $name => $sum ) 
	{
		
?>
<tr style="font-weight:bold;"><td><?= $name?></td><td <?= $sum < 0 ? 'style="color:red; font-weight:bold;"' : ''?>><?= $sum?></td></tr>


<?
	}
?>

</table>
<?

exit();


?>

<table width="600">

<?
$Totals = array();

foreach ( $EndResults AS $match_numb => $v )
{
?>
<tr bgcolor="Lime" style="font-weight:bold;">
<td colspan="2"><?= $MatchNames[$match_numb]?></tr>	
<tr style="font-weight:bold;"><td>Name</td><td>Sum</td></tr>

<?
	

	foreach ( $v as $name => $v1 ) 
	{
		$Totals[$name] += $v1['total'];
?>
<tr style="font-weight:bold;"><td <?= $name == $select_user ? 'bgcolor="Gray"' : '' ?>><?= $name?></td>
<td <?= $v1['total'] < 0 ? 'style="color:red; font-weight:bold;"' : ''?>><?= $v1['total']?></td></tr>


<?
	}
?>
	
	
<?	
}

?>
<tr bgcolor="Yellow" style="font-weight:bold;">
<td colspan="2">TOTAL</tr>	
<?
foreach ( $Totals as $name => $sum ) 
	{
		
?>
<tr style="font-weight:bold;"><td><?= $name?></td><td <?= $sum < 0 ? 'style="color:red; font-weight:bold;"' : ''?>><?= $sum?></td></tr>


<?
	}
?>

</table>

<table border="1" width="600" style="border-collapse:collapse; border:1px solid black;">

<?
foreach ( $GroupsResults AS $letter => $v )
{
?>
<tr>
<td colspan="4" bgcolor="Aqua"><b>GROUP <?= $letter?></b></td>
</tr>

<tr style="font-weight:bold;">
<td>Команда</td>
<td>Забито</td>
<td>Пропущено</td>
<td>Очков</td>
</tr>
<?	
	foreach ( $v AS $name => $v1 )
	{
?>

<tr>
<td colspan="4" bgcolor="Yellow">&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $name?></b></td>
</tr>



<?
//		new d( $v1, 'before' );
		
		$sortAux  = array();
		foreach( $v1 as $res )
    		$sortAux[] = $res['points'];
    		
    	array_multisort( $sortAux, SORT_DESC, $v1 );
    	
    	foreach ( $v1 AS $country_name => $v2 )
    	{
?>

<tr>
<td><?= $country_name?></td>
<td><?= $v2['goals']?></td>
<td><?= $v2['goals_p']?></td>
<td><?= $v2['points']?></td>
</tr>

<?
    	}

		
		/*new d( $v1, 'after' );
		exit();*/

	}
	
}

//echo '$RealResults = array ( \'' . implode ( "','", $RealResults ) . '\' )';

?>

</table>
<br>

<center><a href="stavki.php">Go Back</a></center>
<br>

<?
exit();
new d( $GroupsResults, '$GroupsResults' );
exit();



/*new d( $TheSameArr, '$TheSameArr' );
new d( $RaznArr, '$RaznArr' );
new d( $IshodArr, '$IshodArr' );*/

new d( $GroupsArr, '$GroupsArr' );
	
echo 'ok';


}

else 
{
?>
<html>
<body>
<form method="post" name="form" action="stavki.php">

<input type="hidden" name="todo" value="form_2">
<select name="select_user">
<option value="serg">Сергей
<option value="alex">Алексей
<option value="alena">Алена
<option value="father">Папа
<option value="random">Случайно

</select>


<input type="submit"  value="Go!" >
</form>
</body>
</html>

<?
}



?>
