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


    // 每年固定的生日
    $twice=[
        '09-22'=>"林娜璉生日",
        '11-01'=>"俞定延生日",
        '11-09'=>"平井桃生日",
        '12-29'=>"湊崎紗夏生日",
        '02-01'=>"朴志效生日",
        '03-24'=>"名井南生日",
        '05-28'=>"金多賢生日",
        '04-23'=>"孫彩瑛生日",
        '06-14'=>"周子瑜生日"
    ];

    $bnd=[
        '09-04'=>"朴成淏生日",
        '10-22'=>"李常赫生日",
        '12-04'=>"明宰鉉生日",
        '08-10'=>"漢東旼生日",
        '10-22'=>"金桐儇生日",
        '11-29'=>"金雲鶴生日"
    ];
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

            // 如果今天的日期有人生日 key
            // 印xxx生日 value
            if (isset($twice[date('m-d',$theDayTime)])) {
                echo "<br>{$twice[date("m-d",$theDayTime)]}";
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
<div style="text-align:center; padding-top:5px;">
<a href="calendar.php?year=<?=date("Y");?>&month=<?=date('m');?>"> 今天 </a>
</div>
</body>
</html>