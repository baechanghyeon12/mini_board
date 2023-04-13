<?php
define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
define( "URL_DB", SRC_ROOT."common/db_common.php" );
include_once( URL_DB );

// Request Parameter 획득(GET)
$arr_get = $_GET;

// DB에서 게시글 정보 획득
$result_info = select_board_info_no( $arr_get["board_no"] );


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel='stylesheet' href='css/common.css'>
    <title>Detail</title>
</head>
<body>
<h1>
    <a href="board_list.php">
        <img src="./img/리그오브레전드로고-300x138.png" alt="로고">
    </a>
</h1>
    <div class="main_img">
        <div class="div_base">
            <p>게시글 번호 : <?php echo $result_info["board_no"] ?> </p>
            <p>작성일 : <?php echo $result_info["board_write_date"] ?> </p>
            <p>게시글 제목 : <?php echo $result_info["board_title"] ?></p>
            <p>게시글 내용 : <?php echo $result_info["board_contents"] ?></p>
        </div>
        <br>
        <button type="button">
            <a href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>" class="page_button">
            수정
            </a>
        </button>
        <button type="button">
            <a href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>" class="page_button_del">
                삭제
            </a>
        </button>
    </div>
</body>
</html>