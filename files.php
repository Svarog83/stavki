<?

$arr_t = array ( 'wc2006', 'euro2008' );

if ( !isset ( $ent ) || !in_array( $ent, $arr_t ) )
{
	header( "Location: /" );
}
if ( $ent == 'wc2006' )
{
	$title = '��������� ���� 2006';
	$file_res 		= './files/results_wc2006.txt';
	$file_real_res  = './files/real_results_wc2006.txt';
	$file_graph 	= './files/for_graph_wc2006.txt';
	
	$MatchNames = unserialize( 'a:48:{i:1;s:22:"�������� -- �����-����";i:2;s:17:"������ -- �������";i:17;s:18:"�������� -- ������";i:18;s:21:"������� -- �����-����";i:33;s:19:"������� -- ��������";i:34;s:20:"�����-���� -- ������";i:3;s:18:"������ -- ��������";i:4;s:27:"�������� � ������ -- ������";i:19;s:27:"������ -- �������� � ������";i:20;s:18:"������ -- ��������";i:35;s:16:"������ -- ������";i:36;s:29:"�������� -- �������� � ������";i:5;s:24:"��������� -- ���-�\'�����";i:6;s:32:"������ � ���������� -- ���������";i:21;s:32:"��������� -- ������ � ����������";i:22;s:24:"��������� -- ���-�\'�����";i:37;s:22:"��������� -- ���������";i:38;s:34:"���-�\'����� -- ������ � ����������";i:7;s:15:"������� -- ����";i:8;s:20:"������ -- ����������";i:23;s:17:"������� -- ������";i:24;s:18:"���������� -- ����";i:39;s:21:"���������� -- �������";i:40;s:14:"���� -- ������";i:9;s:14:"������ -- ����";i:10;s:12:"��� -- �����";i:25;s:13:"������ -- ���";i:26;s:13:"����� -- ����";i:41;s:15:"����� -- ������";i:42;s:11:"���� -- ���";i:11;s:20:"�������� -- ��������";i:12;s:19:"��������� -- ������";i:27;s:21:"�������� -- ���������";i:28;s:18:"������ -- ��������";i:43;s:18:"������ -- ��������";i:44;s:21:"�������� -- ���������";i:13;s:20:"������� -- ���������";i:14;s:13:"����� -- ����";i:29;s:16:"������� -- �����";i:30;s:17:"���� -- ���������";i:45;s:15:"���� -- �������";i:46;s:18:"��������� -- �����";i:15;s:18:"������� -- �������";i:16;s:26:"����� -- ���������� ������";i:31;s:16:"������� -- �����";i:32;s:28:"���������� ������ -- �������";i:47;s:28:"���������� ������ -- �������";i:48;s:16:"������� -- �����";}' );
	
	$UserList = array();
	$UserList['serg'] 		= '������';
	$UserList['alex'] 		= '�������';
	$UserList['alena'] 		= '�����';
	$UserList['father'] 	= '����';
	
	$ColorList = array();
	$ColorList['serg'] 		= 'blue';
	$ColorList['alex'] 		= 'green';
	$ColorList['alena'] 	= 'yellow';
	$ColorList['father'] 	= 'red';
	
	$secret_pass = 'preved';
	
	$result_sum 	= 200;
	$diff_score_sum = 140;
	$ishod_sum 		= 80;
	
}

else if ( $ent == 'euro2008' )
{
	$title = '��������� ������ 2008';
	
	$MatchNames = unserialize( 'a:24:{i:1;s:18:"����������--������";i:2;s:20:"�����������--�������";i:3;s:19:"��������--���������";i:4;s:18:"���������--�������";i:5;s:18:"��������--��������";i:6;s:20:"�����������--�������";i:7;s:17:"��������--�������";i:8;s:16:"�������--�������";i:9;s:19:"������--�����������";i:10;s:19:"����������--�������";i:11;s:20:"���������--���������";i:12;s:17:"��������--�������";i:13;s:17:"�������--��������";i:14;s:21:"�����������--��������";i:15;s:17:"�������--��������";i:16;s:16:"�������--�������";i:17;s:23:"����������--�����������";i:18;s:15:"�������--������";i:19;s:18:"������--���������";i:20;s:19:"��������--���������";i:21;s:21:"�����������--��������";i:22;s:17:"��������--�������";i:23;s:17:"�������--��������";i:24;s:16:"�������--�������";}' );
	
	$file_res 		= './files/results_euro2008.txt';
	$file_real_res  = './files/real_results_euro2008.txt';
	$file_graph 	= './files/for_graph_euro2008.txt';
	
	$UserList = array();
	$UserList['serg'] 	 = '������';
	$UserList['alex']	 = '�������';
	$UserList['vladimir'] = '��������';
	$UserList['father']  = '����';
	
	$ColorList = array();
	$ColorList['serg'] 		= 'blue';
	$ColorList['alex'] 		= 'green';
	$ColorList['vladimir']  = 'yellow';
	$ColorList['father'] 	= 'red';
	
	$secret_pass = 'preved';
	
	$result_sum 	= 300;
	$diff_score_sum = 200;
	$ishod_sum 		= 100;
	
}