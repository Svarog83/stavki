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

<a href="live.php?ent=<?= $ent?>">��������� ������</a> | <a href="enter_results.php?ent=<?= $ent?>">���� �����������</a> | <a href="stavki.php?ent=<?= $ent?>">����</a>
<br>
<br>

<?

if ( $_REQUEST['todo'] == 'form_2' )
{

	require_once ( "$DOCUMENT_ROOT/incl_main/dBug.php" );
?>

<center><a href="stavki.php?ent=<?= $ent?>">Go Back</a></center>

<?
	
$file = file ( $file_res );

$ResultsArr  = array();

foreach ( $file AS $str )
{
	$arr_t = explode( '|', $str );
	$arr_t[0] = intval( $arr_t[0] );
	$ResultsArr[$arr_t[0]] = array( 'numb' => trim ( $arr_t[0] ), 'who' => trim ( $arr_t[1] ), 'where' => trim ( $arr_t[2] ), 'users' => array (  'serg' => trim ( $arr_t[3] ), 'alex' => trim ( str_replace ( '-', ':', $arr_t[4] ) ), 'father' => trim ( $arr_t[5] ), 'alena' => trim ( str_replace ( '-', ':', $arr_t[6] ) ) ) );
}

$i = 0;

	$arr_names = array( 'serg', 'alex', 'alena', 'father' );

	$str = file_get_contents( $file_real_res );
	$RealResults = unserialize( $str );

	$letter = 'A';
	$t = 64;	

	$result_sum 	= 200;
	$diff_score_sum = 140;
	$ishod_sum 		= 80;
	
	$SuperTotal = array();

	$TheSameArr  = $RaznArr = $IshodArr = $GroupsArr = $GroupsResults = $TotalSums = $MatchResults = $UsersResults = array();
	
$random_t = false;
foreach ( $ResultsArr AS $match_numb => $v )
{
	$real_result = $RealResults[$match_numb];

	$MatchNames[$match_numb] 	= $v['who'];
	$MatchResults[$match_numb]  = $real_result;
		
	$j = 0;
	$diff = false;
	foreach ( $v['users'] AS $name => $result )
	{
		if ( $real_result )
			$TotalSums[$match_numb][$name] = ( $result == $real_result ? $result_sum : ( DiffScore( $result ) == DiffScore( $real_result ) ? $diff_score_sum : ( sign2( DiffScore( $result ) ) == sign2( DiffScore( $real_result ) ) ? $ishod_sum : 0 ) ) );
		
		
		$UsersResults[$match_numb][$name] = $result;
			
		if ( $j == 0 )
			$compare = $result;
		elseif ( $result != $compare )	
		{
			$diff = true;
//			break;
		}
		$j++;
	}

	if ( $i % 6 == 0 )
	{
		$t++;
		$letter = chr( $t );
		
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
		
		
	if ( !isset ( $GroupsResults[$letter][$first_team]['points'] ) )
	{
		$GroupsResults[$letter][$first_team]['goals'] = 0;
		$GroupsResults[$letter][$first_team]['games'] = 0;
		$GroupsResults[$letter][$first_team]['won'] = 0;
		$GroupsResults[$letter][$first_team]['lost'] = 0;
		$GroupsResults[$letter][$first_team]['draw'] = 0;
		$GroupsResults[$letter][$first_team]['goals_p'] = 0;
		$GroupsResults[$letter][$first_team]['points'] = 0;
		
		$GroupsResults[$letter][$second_team]['goals'] = 0;
		$GroupsResults[$letter][$second_team]['games'] = 0;
		$GroupsResults[$letter][$second_team]['won'] = 0;
		$GroupsResults[$letter][$second_team]['lost'] = 0;
		$GroupsResults[$letter][$second_team]['draw'] = 0;
		$GroupsResults[$letter][$second_team]['goals_p'] = 0;
		$GroupsResults[$letter][$second_team]['points'] = 0;
	}
	
	$arr = explode ( ':', $real_result );
	
	$points = ( $real_result ? ( sign2 ( DiffScore( $real_result ) ) == 1 ? 3 : ( sign2 ( DiffScore( $real_result ) ) == -1 ? 0 : 1 ) ) : '' );

	$GroupsResults[$letter][$first_team]['goals'] += $arr[0];
	$GroupsResults[$letter][$first_team]['goals_p'] += $arr[1];
	$GroupsResults[$letter][$first_team]['games']  += ( $real_result ? 1 : 0 );
	$GroupsResults[$letter][$first_team]['won']  += ( $points == 3 ? 1 : 0 );
	$GroupsResults[$letter][$first_team]['lost']  += ( $points === 0 ? 1 : 0 );
	$GroupsResults[$letter][$first_team]['draw']  += ( $points === 1 ? 1 : 0 );
	$GroupsResults[$letter][$first_team]['points'] += $points;
	
	$points_2 = ( $real_result ?( sign2 ( DiffScore( $real_result ) ) == 1 ? 0 : ( sign2 ( DiffScore( $real_result ) ) == -1 ? 3 : 1 )  ) : '' );
	
	$GroupsResults[$letter][$second_team]['goals'] += $arr[1];
	$GroupsResults[$letter][$second_team]['goals_p'] += $arr[0];
	$GroupsResults[$letter][$second_team]['games']  += ( $real_result ? 1 : 0 );
	$GroupsResults[$letter][$second_team]['won']  += ( $points_2 == 3 ? 1 : 0 );
	$GroupsResults[$letter][$second_team]['lost']  += ( $points_2 === 0 ? 1 : 0 );
	$GroupsResults[$letter][$second_team]['draw']  += ( $points_2 === 1 ? 1 : 0 );
	$GroupsResults[$letter][$second_team]['points'] += $points_2;
		
	
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

$file = fopen( $file_graph, "w" );
fwrite( $file, serialize( $EndResults ) );
fclose( $file );

?>

<br>

<img src="graph.php" width="1024" height="600" border="0">

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

<?
	

	foreach ( $v as $name => $v1 ) 
	{
		$Totals[$name] += $v1['total'];
?>
<tr style="font-weight:bold;"><td <?= $name == $select_user && !$random_t ? 'bgcolor="gray"' : '' ?>><?= $name?> ( <?= $UsersResults[$match_numb][$name] ?> )</td>
<td <?= $v1['total'] < 0 ? 'style="color:red; font-weight:bold;"' : ''?>><?= $v1['total']?></td></tr>


<?
	}
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
<td colspan="7" bgcolor="Aqua"><b>GROUP <?= $letter?></b></td>
</tr>

<tr style="font-weight:bold;">
<td>�������</td>
<td>�</td>
<td>�</td>
<td>�</td>
<td>�</td>
<td>�</td>
<td>�����</td>
</tr>
<?
		$sortAux  = array();
		foreach( $v as $res )
    		$sortAux[] = $res['points'];
    		
    	array_multisort( $sortAux, SORT_DESC, $v );
    	
    	foreach ( $v AS $country_name => $v2 )
    	{
?>
<tr>
<td><?= $country_name?></td>
<td><?= $v2['games']?></td>
<td><?= $v2['won']?></td>
<td><?= $v2['lost']?></td>
<td><?= $v2['draw']?></td>
<td><?= $v2['goals']?> - <?= $v2['goals_p']?></td>
<td><?= $v2['points']?></td>
</tr>

<?
		}
	
}


?>

</table>
<br>

<?
}

else 
{
?>
<html>
<body>
<form method="post" name="form" action="live.php">

<input type="hidden" name="todo" value="form_2">
<input type="hidden" name="ent" value="<?= $ent?>">
<!--<select name="select_user">
<option value="serg">������
<option value="alex">�������
<option value="alena">�����
<option value="father">����

</select>-->

<input type="submit"  value="Go!" >

<br>
<br>

<table border="0" style="border-collapse:collapse; border: 1px solid black;" width="500">
<tr><td colspan="3"><b>��� ��������� �����</b></tr>
<?
$MatchNames = unserialize( 'a:48:{i:1;s:22:"�������� -- �����-����";i:2;s:17:"������ -- �������";i:17;s:18:"�������� -- ������";i:18;s:21:"������� -- �����-����";i:33;s:19:"������� -- ��������";i:34;s:20:"�����-���� -- ������";i:3;s:18:"������ -- ��������";i:4;s:27:"�������� � ������ -- ������";i:19;s:27:"������ -- �������� � ������";i:20;s:18:"������ -- ��������";i:35;s:16:"������ -- ������";i:36;s:29:"�������� -- �������� � ������";i:5;s:24:"��������� -- ���-�\'�����";i:6;s:32:"������ � ���������� -- ���������";i:21;s:32:"��������� -- ������ � ����������";i:22;s:24:"��������� -- ���-�\'�����";i:37;s:22:"��������� -- ���������";i:38;s:34:"���-�\'����� -- ������ � ����������";i:7;s:15:"������� -- ����";i:8;s:20:"������ -- ����������";i:23;s:17:"������� -- ������";i:24;s:18:"���������� -- ����";i:39;s:21:"���������� -- �������";i:40;s:14:"���� -- ������";i:9;s:14:"������ -- ����";i:10;s:12:"��� -- �����";i:25;s:13:"������ -- ���";i:26;s:13:"����� -- ����";i:41;s:15:"����� -- ������";i:42;s:11:"���� -- ���";i:11;s:20:"�������� -- ��������";i:12;s:19:"��������� -- ������";i:27;s:21:"�������� -- ���������";i:28;s:18:"������ -- ��������";i:43;s:18:"������ -- ��������";i:44;s:21:"�������� -- ���������";i:13;s:20:"������� -- ���������";i:14;s:13:"����� -- ����";i:29;s:16:"������� -- �����";i:30;s:17:"���� -- ���������";i:45;s:15:"���� -- �������";i:46;s:18:"��������� -- �����";i:15;s:18:"������� -- �������";i:16;s:26:"����� -- ���������� ������";i:31;s:16:"������� -- �����";i:32;s:28:"���������� ������ -- �������";i:47;s:28:"���������� ������ -- �������";i:48;s:16:"������� -- �����";}' );
	
	$str = file_get_contents( $file_real_res );
	$ResultsArr = unserialize( $str );

for ( $i = 1; $i < 49; $i++ )
{
	if ( $ResultsArr[$i] )
	{
?>

<tr>
<td><?= $i?></td>
<td><?= $MatchNames[$i]?></td>

<td><?= $ResultsArr[$i]?></td>
</tr>

<?
	}
}
?>
</table>

</form>
</body>
</html>

<?
}



?>