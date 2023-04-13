<?php
	define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
	define( "URL_DB", SRC_ROOT."common/db_common.php" );
	define( "URL_HEADER", SRC_ROOT."board_header.php" );
	include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];

    if( $http_method === "POST")
    {
        $arr_post = $_POST;

        $return_cnt = insert_board_info( $arr_post );
        header( "Location: board_list.php" );
        exit();
    }
    

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel='stylesheet' href='css/common.css'>
    <title>게시글 작성</title>
</head>
<body>
<?php include_once( URL_HEADER );?>
	<div class="main_img">
		<form method="post" action="board_insert.php" class="div_base">
			<label  for="title">게시글 제목 : </label>
			<input type="text" name="board_title" id="title" required>
			<br>
			<label  for="contents">게시글 내용 : </label>
			<input type="text" name="board_contents" id="contents" required>
			<br>
			<button type="submit">
                작성
            </button>
			<button type="button">
				<a href="board_list.php">
				취소
				</a>
			</button>
		</form>
</div>
</body>
</html>