<?php


function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
        array(
            PDO::ATTR_EMULATE_PREPARES          => false
        ,PDO::ATTR_ERRMODE                      => PDO::ERRMODE_EXCEPTION //에러가 일어났을때 에러관련 설정
        ,PDO::ATTR_DEFAULT_FETCH_MODE           =>PDO::FETCH_ASSOC // 패치할때 연상배열로 받아온다
        );
        
    try
    {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
    }
    catch( Exception $e)
    {
        $param_conn = null;
        throw new Exception( $e->getMessage() );
    }
}

function select_board_info_paging( &$param_arr )
{
    $sql =
    " SELECT "
	." board_no "
	." ,board_title "
	." ,board_write_date "
    ." FROM "
	." board_info "
    ." WHERE "
	." board_del_flg = '0' "
    ." ORDER BY "
	." board_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare =
        array(
            ":limit_num"    => $param_arr["limit_num"]
            ,":offset"      => $param_arr["offset"]
        );
    
    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    }
    catch ( Exception $e)
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    return $result;
}

// TODO : test Start
// $arr =
//     array(
//         "limit_num" =>5
//         ,"offset" => 0
//     );
// $result = select_board_info_paging( $arr);


// print_r($result);
// TODO : test End


function select_board_info_cnt()
{
    $sql =
        " SELECT "
        ."      COUNT(*) cnt "
        ." FROM "
        ."      board_info "
        ." WHERE "
        ."      board_del_flg = '0' "
        ;
    $arr_prepare = array();

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    }
    catch ( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}


function select_board_info_no( &$param_no )
{
    $sql =
    " SELECT "
	." board_no "
	." ,board_title "
	." ,board_contents "
    ." FROM "
	." board_info "
    ." WHERE "
	." board_no = :board_no "
    ;

    $arr_prepare =
        array(
            ":board_no"    => $param_no
        );
    
    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    }
    catch ( Exception $e)
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result[0];
}

// TODO : stard

// $i = 1;
// print_r(select_board_info_no( $i ));

// TODO : end


function update_board_info_no( &$param_arr )
{
    $sql =
        " UPDATE "
        ." board_info "
        ." SET "
        ." board_title = :board_title "
        ." ,board_contents = :board_contents "
        ." WHERE "
        ." board_no = :board_no "
        ;
    
    $arr_prepare =
            array(
                ":board_title" =>$param_arr["board_title"]
                ,":board_contents" =>$param_arr["board_contents"]
                ,":board_no" =>$param_arr["board_no"]
            );

    $conn = null;
    try
    {
        db_conn( $conn ); // PDO object set(DB연결)
        $conn->beginTransaction(); // Transaction 시작(commit이나 rollback을 만나면 종료됨)
        $stmt = $conn->prepare( $sql ); // statement object set
        $stmt->execute( $arr_prepare ); // DB request
        $result_cnt = $stmt->rowCount(); // query 적용 recode 객수 //  rowCount() : 영향받은 레코드의 숫자를 리턴해준다.
        $conn->commit();
    }
    catch ( Exception $e)
    {
        $conn->rollback(); // 리턴 전에 롤백을 해줘야 된다.
        return $e->getMessage();
    }
    finally
    {
        $conn = null; // DB 파기
    }

    return $result_cnt;
}


// TODO : stard
// $arr =
// array(
//     "board_no" => 1
//     ,"board_title" => "test1"
//     ,"board_contents"=>"testtest1"
// );

// echo update_board_info_no( $arr)


// TODO : end

function select_board_info_serch( &$param_arr )
{
    $sql =
    " SELECT "
	." board_no "
	." ,board_title "
	." ,board_write_date "
    ." FROM "
	." board_info "
    ." WHERE "
	." board_del_flg = '0' "
    ." AND board_title LIKE CONCAT('%',:serch,'%') "
    ." ORDER BY "
	." board_no DESC "
    ;

    $arr_prepare =
        array(
            ":serch"       => $param_arr["serch"]
        );
    
    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();

    }
    catch ( Exception $e)
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    return $result;
}


?>