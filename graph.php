<?
include ("./jpgraph/jpgraph.php");
include ("./jpgraph/jpgraph_line.php");

require_once( 'files.php' );

$str = file_get_contents( $file_graph );
$EndResults = unserialize( $str );

$TestArr = $TempArr = $Xlabels = array();


function Translit( $text ) 
{
$search = array ("'À'","'Á'","'Â'","'Ã'","'Ä'","'Å'","'¨'","'Æ'","'Ç'", 
                 "'È'","'É'","'Ê'","'Ë'","'Ì'","'Í'","'Î'","'Ï'","'Ð'", 
                 "'Ñ'","'Ò'","'Ó'","'Ô'","'Õ'","'Ö'","'×'","'Ø'","'Ù'", 
                 "'Ú'","'Û'","'Ü'","'Ý'","'Þ'","'ß'","'à'","'á'","'â'", 
                 "'ã'","'ä'","'å'","'¸'","'æ'","'ç'","'è'","'é'","'ê'", 
                 "'ë'","'ì'","'í'","'î'","'ï'","'ð'","'ñ'","'ò'","'ó'", 
                 "'ô'","'õ'","'ö'","'÷'","'ø'","'ù'","'ú'","'û'","'ü'", 
                 "'ý'","'þ'","'ÿ'","' '","','","'\.'"); 

$replace = array ("A","B","V","G","D","E","E","Zh","Z", 
                  "I","J","K","L","M","N","O","P","R", 
                  "S","T","U","F","H","C","Ch","Sh","Sc", 
                  "","Y","","E","U","Ya","a","b","v", 
                  "g","d","e","e","j","z","i","i","k", 
                  "l","m","n","o","p","r","s","t","u", 
                  "f","h","c","ch","sh","sc","","y","", 
                  "e","u","ya", "_", "_", "_"); 

$text = preg_replace ($search, $replace, $text);
return $text;

} // function



foreach ( $EndResults as $match_numb => $v ) 
{
	foreach ( $v as $name => $value ) 
	{
		$TempArr[$name] += $value['total'];
		$TestArr[$name][]	= $TempArr[$name];
		$Xlabels[] = str_replace ( '--', '-', Translit( $MatchNames[$match_numb] ) );
	}
}

//	$ydata = $v;
	
	// Create the graph. 
	$graph = new Graph(1024,600,"auto");	
	$graph->SetScale("textlin");
//	$graph->img->SetMargin(30,90,40,50);
	$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
	
	// Labels
	
//	$graph->xaxis->SetTickLabels( $Xlabels );
//	$graph->xaxis->SetLabelAngle(90);
//	$graph->xaxis->HideLabels();
	$graph->title->Set("Results");
	
	foreach ( $TestArr AS $name => $arr )
	{
		$color = $ColorList[$name];
		// Create the linear plot
		$lineplot=new LinePlot($arr);
		$lineplot->SetLegend($name);
		$lineplot->SetColor($color);
		
		if ( $name == 'serg' )
			$lineplot-> mark->SetType( MARK_STAR );
		else 
			$lineplot-> mark->SetType( MARK_DTRIANGLE );
		

		$lineplot->value->show();
		$lineplot->value->SetColor('darkred');
		
		$lineplot->SetWeight(2);
		$graph->Add($lineplot);
		unset ( $lineplot );
	}		

	// Adjust the legend position
	$graph->legend->SetLayout(LEGEND_HOR);
	$graph->legend->Pos(0.4,0.95,"center","bottom");
	
	// Display the graph
	$graph->Stroke( );
	
	
?>