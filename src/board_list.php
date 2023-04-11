<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); // $_SERVER["DOCUMENT_ROOT"]에는 C:\Apache24\htdocs라는 값이 들어가 있다.
                                                         // $_SERVER["DOCUMENT_ROOT"]."/"을 DOC_ROOT에 상수로 정의해 준다.
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB );
    $http_method = $_SERVER["REQUEST_METHOD"]; //어떤식으로 요청했는지 값을 $http_method에 담는다


if($http_method === "GET")
{
    $flg_serch = array_key_exists("board_serch", $_GET);
    if( !$flg_serch )
    {
        //GET 체크
        if( array_key_exists ("page_num", $_GET)) // $_GET에 "page_num"이라는 키값이 있는지 확인하는 조건
        {
            $page_num = $_GET["page_num"]; // $_GET에 "page_num"이라는 키값이 있으면 "page_num"의 벨류값을 $page_num에 담는다.
        }
        else
        {
            $page_num = 1; // $_GET에 "page_num"이라는 키값이 없으면 $page_num에 1을 담는다.
        }
        $limit_num = 5;

        // 게시판 정보 테이블 전체 카운트 획득
        $result_cnt = select_board_info_cnt();

        // max page number
        $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );
        
        // 1페이지일때 0, 2페이지 일때 5, 3페이지 일때 10
        // offset
        $offset = ($page_num * $limit_num) - $limit_num;

        $arr_prepare =
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
        $result_paging = select_board_info_paging( $arr_prepare );
    }
    else
    {
        $arr_prepare =
        array(
            "serch"    => $_GET["board_serch"]
        );
        $result_paging = select_board_info_serch( $arr_prepare );
        $board_serch = $_GET["board_serch"];
    }

}
else
{
    $flg_serch = array_key_exists("board_serch", $_POST);
    $arr_prepare =
    array(
        "serch"    => $_POST["board_serch"]
    );
    $result_paging = select_board_info_serch( $arr_prepare );
    $board_serch = $_POST["board_serch"];
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
</head>
<body>
    <h1><a href="board_list.php">게시판</a></h1>
    <div class='tbl_div'>
        <table class='table table-dark table-striped'>
            <thead>
                <tr>
                <th class='td_no'>게시글 번호</th>
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
                        <td class='td_no'><?php echo $recode["board_no"] ?></td>
                        <td class='td_tit'><a href="board_update.php?board_no=<?php echo $recode["board_no"]; echo $flg_serch ? "&board_serch=".$board_serch : "" ?> " class="tit_a"><?php echo $recode["board_title"] ?></a></td>
                        <td class='td_date'><?php echo $recode["board_write_date"] ?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php
        if( !$flg_serch )
        {
    ?>
    <div class="a">
        <?php
        if ($page_num > 1)
        {
        ?>
            <a href='board_list.php?page_num=<?php echo $page_num-1 ?>'class="btn btn-outline-dark"><</a>
        <?php
        }
        else
        {
        ?>
            <a href='board_list.php?page_num=<?php echo $page_num ?>'class="btn btn-outline-dark"><</a>
        <?php
        }
        ?>
        <?php
            for( $i = 1; $i <= $max_page_num; $i++ )
            {
        ?>
                <a href='board_list.php?page_num=<?php echo $i ?>'class="btn btn-outline-dark"><?php echo $i ?></a>
        <?php
            }
        ?>
        <?php
        if ($page_num < $max_page_num )
        {
        ?>
            <a href='board_list.php?page_num=<?php echo $page_num +1 ?>'class="btn btn-outline-dark">></a>
        <?php
        }
        else
        {
        ?>
            <a href='board_list.php?page_num=<?php echo $page_num  ?>'class="btn btn-outline-dark">></a>
        <?php
        }
        ?>
    </div>
    <?php
        }
    ?>
    <form method="post" >
        <div class="serch">
            <label for="serch"></label>
            <input type="text" name="board_serch" id="serch">
            <button type="submit">검색</button>
        </div>
    </form>
</body>
</html>