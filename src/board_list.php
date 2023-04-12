<?php
	define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
	define( "URL_DB", SRC_ROOT."common/db_common.php" );
	include_once( URL_DB );

	// GET 체크
	if( array_key_exists( "page_num", $_GET ) )
	{
		$page_num = $_GET["page_num"];
	}
	else
	{
		$page_num = 1;
	}

	$limit_num = 5;

	// 게시판 정보 테이블 전체 카운트 획득
	$result_cnt = select_board_info_cnt();

	// max page number
	$max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );

	// offset
	$offset = ( $page_num * $limit_num ) - $limit_num;

	$arr_prepare =
		array(
			"limit_num"	=> $limit_num
			,"offset"	=> $offset
		);

	// 페이징용 데이터 검색
	$result_paging = select_board_info_paging( $arr_prepare );
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel='stylesheet' href='css/common.css'>
	<title>게시판</title>
</head>
<body>
	<h1><a href="board_list.php"><img src="./img/리그오브레전드로고-300x138.png" alt="로고"></a></h1>
	<div class="main_img">
		<h2>자유게시판</h2>
		<div class='div_base'>
			<table  class="table_cs">
				<thead class="thead_cs">
					<tr class="th_tr_cs">
						<th>게시글 번호</th>
						<th>게시글 제목</th>
						<th>작성일자</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach( $result_paging as $recode )
						{
					?>
							<tr>
								<td><?php echo $recode["board_no"] ?></td>
								<td><a href="board_detail.php?board_no=<?php echo $recode["board_no"] ?>"><?php echo $recode["board_title"] ?></a></td>
								<td><?php echo $recode["board_write_date"] ?></td>
							</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
			<!-- 페이징 번호 -->
			<div class="a">
				<?php
				if ($page_num > 1)
				{
				?>
					<a href='board_list.php?page_num=<?php echo $page_num-1 ?>'class="page_button"><</a>
				<?php
				}
				else
				{
				?>
					<a href='board_list.php?page_num=<?php echo $page_num ?>'class="page_button"><</a>
				<?php
				}
				?>
				<?php
					for( $i = 1; $i <= $max_page_num; $i++ )
					{
				?>
						<a href='board_list.php?page_num=<?php echo $i ?>'class="page_button"><?php echo $i ?></a>
				<?php
					}
				?>
				<?php
				if ($page_num < $max_page_num )
				{
				?>
					<a href='board_list.php?page_num=<?php echo $page_num +1 ?>'class="page_button">></a>
				<?php
				}
				else
				{
				?>
					<a href='board_list.php?page_num=<?php echo $page_num  ?>'class="page_button">></a>
				<?php
				}
				?>
			</div>
	</div>
	<div class="foot_div">
		<span>이용 약관</span>
	</div>

</body>
</html>