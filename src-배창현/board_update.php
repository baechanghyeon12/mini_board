<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB );

    // Request Method를 획득
    $http_method = $_SERVER["REQUEST_METHOD"];
    $board_serch = "";

    //GET 체크
    if($http_method === "GET")
    {
        $board_no = 1;
        if( array_key_exists ( "board_no", $_GET ) )                                           
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );

        if( array_key_exists("board_serch", $_GET) )
        {
            $board_serch = "?board_serch=".$_GET["board_serch"];
        }
    }
    // POST 일때
    else
    {
        $arr_post = $_POST;
        $arr_info =
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );
        // update
        $result_cnt = update_board_info_no($arr_info);
        // select
        $result_info = select_board_info_no( $arr_post["board_no"] );
    }

?>




<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./common/miniproject.css">
    <title>게시판</title>
    <style>
        form{
            text-align:center;
            margin:20 auto;
        }
    </style>
</head>
<body>
    <form method="post" action="board_update.php">
    <label for="bno">게시글 번호 : </label>
    <!-- name값이 키값이 된다. -->
    <input type="text" name="board_no" id="bno" value="<?php echo $result_info['board_no']?>" readonly>
    <br>
    <label for="title">게시글 제목 : </label>
    <input type="text" name="board_title" id="title" value="<?php echo $result_info['board_title']?>" >
    <br>
    <label for="contents">게시글 내용 : </label>
    <input type="text" name="board_contents"  id="contents" value="<?php echo $result_info['board_contents']?>">
    <br>
    <button type="submit">수정</button>
    <button type="button" ><a href='board_list.php<?php echo $board_serch ?>'>리스트</a></button>
    </form>
</body>
</html>