<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆</title>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>

<?php
    // 如果有參數就按照參數來 沒有的話就用當前年月份
    if (isset($_GET['month'])) {
        $month = $_GET['month'];
    } else {
        $month = date("m");
    }
    if (isset($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        $year = date("Y");
    }
   
    // 一月份的上一個月會是去年的12月
    if ($month-1 <1) {
        $prevMonth=12;
        $prevYear = $year-1;
    // 其他月份的上一個月就是同一年的前一個月
    } else {
        $prevMonth = $month-1;
        $prevYear = $year;
    } 
    // 12月份的下一個月會是明年的1月
    if ($month+1 >12) {
        $nextMonth = 1;
        $nextYear = $year+1;
    // 其他月份的下一個月就是同一年的後一個月
    } else {
        $nextMonth = $month +1;
        $nextYear = $year;
    }

    // 特殊節日
    $spDate=['2024-11-07'=>"立冬", 
             '2024-11-22'=>"小雪"];

    // 每年固定的假日
    $holidays=['01-01'=>"元旦",
               '02-28'=>"二二八紀念日",
               '05-01'=>"勞動節",
               '10-10'=>"國慶日"];
?>
<?php
    // 當月第一天
    $firstInMonth = "$year-$month-1";
    $firstDayTime = strtotime($firstInMonth);
    // 當月第一天是週幾
    $firstDayWeek= date("w",$firstDayTime);
    // $firstDayWeek = date("w",strtotime(date("Y-m-1")));
?>
<div class='nav'>
    <!-- 連結前往去年、上一個月、今天、下一個月、以及明年 -->
    <table style="width:100%;">
        <tr>
            <td style='text-align:left'>
                <a href="calendar.php?year=<?=$year-1;?>&month=<?=$month;?>"> 去年 </a>
                <a href="calendar.php?year=<?=$prevYear;?>&month=<?=$prevMonth;?>"> 上一個月 </a>
            </td>
            <td>
            <?=date('Y年-m月',$firstDayTime);?>
            </td>
            <td style='text-align:right'>
                <a href="calendar.php?year=<?=$nextYear;?>&month=<?=$nextMonth;?>"> 下一個月 </a>
                <a href="calendar.php?year=<?=$year+1;?>&month=<?=$month;?>"> 明年 </a>
            </td>
        </tr>
</table>
</div>



<!-- 萬年曆的表格 -->
<table>
<?php
    
    // 印週幾
    $day=[' ','日','一','二','三','四','五','六'];
    echo "<tr>";
    foreach ($day as $key) {
        if ($key=='日' || $key =='六'){
            echo "<td class='holiday'> $key </td>";
        } else {
        echo "<td> $key </td>";
        }
    }
    echo "</tr>";


    // 印日期 
    for ($i=0; $i<6; $i++) { 
        echo "<tr>";
        // 印第幾周
        echo "<td class='days'>";
        echo $i+1;
        echo "</td>";

        for ($j=0; $j<7; $j++) { 
            // 幾號 當月第一天會是0
            $cell = $i*7 + $j - $firstDayWeek;
            // 當月第一天的日期
            $theDayTime = strtotime("$cell days".$firstInMonth);

            // 不是當月的話字會變灰
            $theMonth = (date("m",$theDayTime) == date("m",$firstDayTime))?'':'grey-text';
            // 是今天的話就高亮
            $isToday = (date("Y-m-d",$theDayTime) == date("Y-m-d"))?'today':'';
            // 判斷當天是否是週末
            $w = date("w",$theDayTime);
            $isHoliday = ($w==6 || $w==0)?'holiday':'';
            echo "<td class = '$theMonth $isToday $isHoliday'>";
            echo date('d',$theDayTime);
            // 如果今天的日期有在$spDate裡面 key
            // value
            if (isset($spDate[date('Y-m-d',$theDayTime)])) {
                echo "<br>{$spDate[date('Y-m-d',$theDayTime)]}";
            }
            if (isset($holidays[date('m-d',$theDayTime)])) {
                echo "<br>{$holidays[date("m-d",$theDayTime)]}";
            }
            echo "</td>";
        }
        echo "</tr>";
    }

?>
</table>
<div style="text-align:center; padding-top:5px;">
<a href="calendar.php?year=<?=date("Y");?>&month=<?=date('m');?>"> 今天 </a>
</div>
</body>
</html>