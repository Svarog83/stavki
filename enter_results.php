<?
require_once( 'files.php' );
//error_reporting(0);
if ( $_REQUEST['todo'] == 'form_2' )
{
	if ( $pass == $secret_pass )
	{
		$ResultsArr = array();
		foreach ( $match_result AS $match_numb => $result )
		{
			$ResultsArr[$match_numb] = str_replace ( '-', ':', $result );
		}
		
		$file = fopen( $file_real_res, "w" );
		fwrite( $file, serialize( $ResultsArr ) );
		fclose( $file );
		
		header( 'Location: enter_results.php?ent=' . $ent );
	}
	else 	
		echo 'Wrong pass!';

}

else 
{
	
	$str = file_get_contents( $file_real_res );
	$ResultsArr = unserialize( $str );
?>
<html>
<body>

<form method="post" name="form" action="enter_results.php">
<input type="hidden" name="ent" value="<?= $ent?>">

<input type="hidden" name="todo" value="form_2">
<h1><?= $title?></h1>
<a href="live.php?ent=<?= $ent?>">Настоящие данные</a> | <a href="enter_results.php?ent=<?= $ent?>">Ввод результатов</a> | <a href="stavki.php?ent=<?= $ent?>">Тест</a> | <a href="index.php">Домой</a>
<br>
<br>

Password: <input type="password" name="pass" size="10" value="preved">

<table>
<?
$count = count ( $MatchNames ) + 1;
for ( $i = 1; $i < $count; $i++ )
{
?>

<tr>
<td><?= $i?></td>
<td><?= $MatchNames[$i]?></td>

<td><input type="text" size="5" name="match_result[<?=$i?>]" value="<?= $ResultsArr[$i]?>" <?= $ResultsArr[$i] ? ' ' : '' ?>></td>
</tr>

<?
}
?>
</table>



<input type="submit"  value="Go!" >
</form>
</body>
</html>

<?
}



?>
