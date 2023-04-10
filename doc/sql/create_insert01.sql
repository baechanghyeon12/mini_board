USE board;
-- 
-- CREATE TABLE board_info(
-- 	board_no INT PRIMARY KEY AUTO_INCREMENT
-- 	,board_title VARCHAR(100) NOT NULL
-- 	,board_contents VARCHAR(1000) NOT NULL
-- 	,board_write_date DATETIME NOT NULL
-- 	,board_del_flg CHAR(1) DEFAULT ("0") NOT NULL
-- 	,board_del_date DATETIME
-- );


-- **n은 숫자**
-- 게시글 제목 : 제목n
-- 게시글 내용 : 내용n
-- 작성일 : 현재일자

INSERT INTO board_info (
	board_title
	,board_contents
	,board_write_date
)
VALUES(
	'제목 20'
	,'내용 20'
	,NOW()
);


SELECT * FROM board_info;


COMMIT;

