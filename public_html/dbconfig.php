<?php
    $host = "localhost";
    $dbid = "db2016320201";                    // 자신의 DB ID
    $dbpass = "nature228@naver.com";                  // 자신의 DB Password
    $dbname = "db2016320201";                  // 해당 프로젝트에서 사용하는 DB명
    
function dbconnect($host, $id, $pass, $db)
{
    $conn = mysqli_connect($host, $id, $pass, $db);

    if ($conn == false) {
        die('Not connected : ' . mysqli_error());
    }

    return $conn;
}

function msg($msg) // 경고 메시지 출력 후 이전 페이지로 이동
{
    echo "
        <script>
             window.alert('$msg');
             history.go(-1);
        </script>";
    exit;
}

function s_msg($msg) //일반 메시지 출력
{
    echo "
        <script>
            window.alert('$msg');
        </script>";
}
?>

