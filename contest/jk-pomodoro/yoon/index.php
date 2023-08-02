<?php
        ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>가위바위보!</title>
</head>

<body>
    <h1>재미있는 가위바위보 게임을 즐겨보세요.</h1>
    <form action="index.php" method="GET">
        입력 :
        <input type=radio name="me" value="1" id="gawi"><label for="gawi">가위</label>
        <input type=radio name="me" value="2" id="bawi"><label for="bawi">바위</label>
        <input type=radio name="me" value="3" id="bo"><label for="bo">보</label>
        <input type="submit">
    </form>

        <?php
    $expTime = time() + (60 * 60 * 2);
    $gameCode = 0;
    define("WIN", 1, false);
    define("LOSE", 2, false);
    define("DRAW", 3, false);

    $com = rand(1, 3);
    $na = $_GET['me'];
        $today_data = array(0, 0, 0, 0); // 전체, 승, 패, 무
    loadTodayData();
    $rsp_index = array("", "가위", "바위", "보");

    if ($na == $com) {
        $gameCode = DRAW;
    } else {
        if (($com == 1 && $na == 2) || ($com == 2 && $na == 3) || ($com == 3 && $na == 1))
            $gameCode = WIN;
        else if (($com == 2 && $na == 1) || ($com == 3 && $na == 2) || ($com == 1 && $na == 3))
            $gameCode = LOSE;
          }

    if ($na != 0) {
                updateTodayData($gameCode);

                echo "당신은<b> ", $rsp_index[$na], "</b>를 냈습니다.<br/>\n";
        echo "컴퓨터는 <b> ", $rsp_index[$com], "</b>를 냈습니다.<br/>\n";

        $results = array("", "이겼습니다!!", "졌습니다ㅜㅜ", "비겼습니다.");
        echo "$results[$gameCode] <br/> \n";
                printTodayData();
    }

        function loadTodayData(){
        global $today_data;
        $strs = $_COOKIE['myrecord'];
        if ($strs == '') {
            for ($i = 0; $i < 4; $i++)
                $today_data[$i] = 0;
        } else
            $today_data = explode('/', $strs);
          }

    function updateTodayData($gCode) {
        global $today_data, $expTime;
        ++$today_data[0];
        ++$today_data[$gCode];
        setcookie('myrecord', implode('/', $today_data), $expTime);
         }

    function printTodayData() {
        global $today_data, $userID, $userName;
        $today_rate = round($today_data[1] / $today_data[0] * 100, 2);
        echo "방문자님은 오늘  $today_data[0]회 시도하여  $today_data[1]승,$today_data[2]패, $today_data[3] 번의 무승부 를 기록중입니다. 승률은 $today_rate%입니다.<br/>";
        }
    ?>
</body>
</html>
