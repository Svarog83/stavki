<?
//error_reporting(0);
require_once( 'files.php' );

function DiffScore( $val )
{
	$arr = explode ( ':', $val );
	
	$diff = $arr[0] - $arr[1];
	
	return $diff;
}

function sign2($a) 
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

?>


<a href="live.php">Настоящие данные</a> | <a href="enter_results.php">Ввод результатов</a> | <a href="stavki.php">Тест</a>
<br>
<br>

<?
if ( $_REQUEST['todo'] == 'form_2' )
{

	ob_start();
	require_once ( "$DOCUMENT_ROOT/incl_main/dBug.php" );
	
$file = file ( $file_res );

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

$arr_names = array_keys( $UserList );

$RealResults = array();

	$letter = 'A';
	$t = 64;	

	
$SuperTotal = array();

	$TheSameArr  = $RaznArr = $IshodArr = $GroupsArr = $GroupsResults = $TotalSums = $MatchNames = $MatchResults = array();
	
$random_t = false;
foreach ( $ResultsArr AS $match_numb => $v )
{
	if ( $select_user == 'random' || $random_t )
	{
		$random_t = true;
		$key = array_rand( $arr_names );
		$select_user = $arr_names[$key];
	}
	
	
	
	foreach ( $v['users'] AS $name => $result )
	{
		if ( $name == $select_user )
		{
			$real_result = $result;
			break;
		}
	}
	
	$MatchNames[$match_numb] 	= $v['who'];
	$MatchResults[$match_numb]  = $real_result;
	
	$j = 0;
	$diff = false;
	foreach ( $v['users'] AS $name => $result )
	{
		
		$TotalSums[$match_numb][$name] = ( $result == $real_result ? $result_sum : ( DiffScore( $result ) == DiffScore( $real_result ) ? $diff_score_sum : ( sign2( DiffScore( $result ) ) == sign2( DiffScore( $real_result ) ) ? $ishod_sum : 0 ) ) );
		
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
				$compare =  sign2( DiffScore( $result ) );
			elseif ( sign2 ( DiffScore( $result ) ) != $compare )	
			{
				$diff = true;
				break;
			}
			$j++;
		}
		
		if ( !$diff )
			$IshodArr[] = $v;
	}*/
	
		

	


	if ( $i % 6 == 0 )
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
		
		if ( !isset ( $GroupsResults[$letter][$name][$first_team]['points'] ) )
		{
			$GroupsResults[$letter][$name][$first_team]['goals'] = 0;
			$GroupsResults[$letter][$name][$first_team]['goals_p'] = 0;
			$GroupsResults[$letter][$name][$first_team]['points'] = 0;
			
			$GroupsResults[$letter][$name][$second_team]['goals'] = 0;
			$GroupsResults[$letter][$name][$second_team]['goals_p'] = 0;
			$GroupsResults[$letter][$name][$second_team]['points'] = 0;
		}

		$GroupsResults[$letter][$name][$first_team]['goals'] += $arr[0];
		$GroupsResults[$letter][$name][$first_team]['goals_p'] += $arr[1];
		$GroupsResults[$letter][$name][$first_team]['points'] += ( sign2 ( DiffScore( $result ) ) == 1 ? 3 : ( sign2 ( DiffScore( $result ) ) == -1 ? 0 : 1 ) );
		
		$GroupsResults[$letter][$name][$second_team]['goals'] += $arr[1];
		$GroupsResults[$letter][$name][$second_team]['goals_p'] += $arr[0];
		$GroupsResults[$letter][$name][$second_team]['points'] += ( sign2 ( DiffScore( $result ) ) == 1 ? 0 : ( sign2 ( DiffScore( $result ) ) == -1 ? 3 : 1 ) );
		
	}
	
	
	$i++;
}

$EndResults = array();

include ("./jpgraph/jpgraph.php");
include ("./jpgraph/jpgraph_line.php");

foreach ( $TotalSums AS $match_numb => $v )
{
	$buffer  = ob_get_clean();

	foreach ( $v AS $name => $sum )
	{
		$EndResults[$match_numb][$name] =  CountSums ( $v, $sum, $name );
	}
	
}

/*$TestArr = $TempArr = array();

foreach ($EndResults as $match_numb => $v ) 
{
	foreach ( $v  as $name => $value ) 
	{
		$TempArr[$name] += $value['total'];
		$TestArr[$name][]	= $TempArr[$name];
	}
}

//	$ydata = $v;
	
	// Create the graph. 
	$graph = new Graph(650,250,"auto");	
	$graph->SetScale("textlin");
//	$graph->img->SetMargin(30,90,40,50);
	$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
	$graph->xaxis->HideLabels();
	$graph->title->Set("Example 1.1 same y-values");
	
	$colors = array ( 'serg' => 'blue', 'alex' =>'green', 'father' =>'yellow', 'alena' =>'red' );
	
	foreach ( $TestArr AS $name => $arr )
	{
		$color = $colors[$name];
		// Create the linear plot
		$lineplot=new LinePlot($arr);
		$lineplot->SetLegend($name);
		$lineplot->SetColor($color);
		
//		$lineplot-> mark->SetType(MARK_UTRIANGLE );
		$lineplot->SetWeight(1);
		$graph->Add($lineplot);
		unset ( $lineplot );
	}		

	// Adjust the legend position
	$graph->legend->SetLayout(LEGEND_HOR);
	$graph->legend->Pos(0.4,0.95,"center","bottom");
	
	$graph->Stroke( );*/
	
	// Display the graph


?>

<?php



echo $buffer;
ob_end_clean();

?>
<br>
<br>

<table width="600">

<?
$Totals = array();

foreach ( $EndResults AS $match_numb => $v )
{
?>
<tr bgcolor="Lime" style="font-weight:bold;">
<td colspan="2"><?= $MatchNames[$match_numb]?>( <?= $MatchResults[$match_numb]?> )</tr>	
<tr style="font-weight:bold;"><td>Name</td><td>Sum</td></tr>

<?
	

	foreach ( $v as $name => $v1 ) 
	{
		$Totals[$name] += $v1['total'];
?>
<tr style="font-weight:bold;"><td <?= $name == $select_user && !$random_t ? 'bgcolor="gray"' : '' ?>><?= $name?></td>
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

<center><a href="stavki.php?ent=<?= $ent?>">Go Back</a></center>
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
	$str = file_get_contents( $file_res );
	
	$ResultsArr = unserialize( $str );
?>
<html>
<body>
<form method="post" name="form" action="stavki.php">
<input type="hidden" name="ent" value="<?= $ent?>">

<input type="hidden" name="todo" value="form_2">
<select name="select_user">
<? foreach ( $UserList AS $k => $v ): ?>

<option value="<?= $k?>"><?= $v?>
<? endforeach;?>
<option value="random">Случайно
</select>

<input type="submit"  value="Go!" >
</form>
</body>
</html>

<?
}