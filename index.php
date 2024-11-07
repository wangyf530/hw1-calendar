<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>萬年曆作業</title>
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

    
?>
    <!-- 生日表 -->
<?php
    include "birthday.php"; 
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
    <table>
        <tr>
            <td style='text-align:left'>
                <a href="index.php?year=<?=$year-1;?>&month=<?=$month;?>"> 去年 </a>
                <a href="index.php?year=<?=$prevYear;?>&month=<?=$prevMonth;?>"> 上一個月 </a>
            </td>
            <td>
            <?=date('Y年-m月',$firstDayTime);?>
            </td>
            <td style='text-align:right'>
                <a href="index.php?year=<?=$nextYear;?>&month=<?=$nextMonth;?>"> 下一個月 </a>
                <a href="index.php?year=<?=$year+1;?>&month=<?=$month;?>"> 明年 </a>
            </td>
        </tr>
    </table>
</div>



<!-- 萬年曆的表格 -->
<table>
<?php
    
    // 印週幾
    $day=['日','一','二','三','四','五','六'];
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

            // 如果今天的日期有人生日 key
            // 印xxx生日 value
            if (isset($twice[date('m-d',$theDayTime)])) {
                echo "<br class='birth'>{$twice[date("m-d",$theDayTime)]}";
            }
            if (isset($bnd[date('m-d',$theDayTime)])) {
                echo "<br>{$bnd[date("m-d",$theDayTime)]}";
            }
            
            echo "</td>";
        }
        echo "</tr>";
    }

?>
</table>

<div class="goToday">
<a href="index.php?year=<?=date('Y');?>&month=<?=date('m');?>"> 今天 </a>
</div>

</body>
</html>