<?php
// header("Content-Type: application/vnd.ms-excel");
// header("Content-disposition: attachment; filename=Week of Week Report as of ".$_POST['sd']." to ".$_POST['ed'].".xls");

$sd = $_POST['sd'];
$ed = $_POST['ed'];

$getweeks = getDateRangeForAllWeeks($sd, $ed);
$array_count = count($getweeks);

$get_wow = get_wow($array_count, $getweeks);

$wow_count = count($get_wow);

$generate = generate($get_wow, $wow_count, $sd, $ed);

function generate($get_wow, $wow_count, $sd, $ed){
require('PHPExcel/PHPExcel.php');
$phpExcel = new PHPExcel;
$phpExcel ->getProperties()->setTitle("Wow Logis");
$phpExcel ->getProperties()->setCreator("Admin");
$phpExcel ->getProperties()->setDescription("Week on Week Reports");
$phpExcel->setActiveSheetIndex(0)->mergeCells('A1:B1');
$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
$sheet = $phpExcel ->getActiveSheet();
$sheet->setTitle('Week on Week Report');
$sheet ->getCell('A1')->setValue('Date');
$sheet ->getCell('A2')->setValue('From');
$sheet ->getCell('B2')->setValue('To');
$sheet ->getCell('C2')->setValue('No. of Deliveries');
$sheet ->getCell('D2')->setValue('Total Delivery Cost');
$sheet ->getCell('E2')->setValue('Yell X Share');

$j = 3;
for($i=0;$i<$wow_count;$i++){   
    $sheet ->getCell('A'.$j.'')->setValue($get_wow[$i]["from"]);
    $sheet ->getCell('B'.$j.'')->setValue($get_wow[$i]["to"]);
    $sheet ->getCell('C'.$j.'')->setValue($get_wow[$i]["no_deliveries"]);
    $sheet ->getCell('D'.$j.'')->setValue($get_wow[$i]["total_cost"]);
    $sheet ->getCell('E'.$j.'')->setValue($get_wow[$i]["y_share"]);
    $j++;
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Week on Week report for '.$sd.' to '.$ed.'.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
}

function get_wow($array_count, $getweeks){
    $servername = "localhost";
    $username = "yellohot_yellox";
    $password = "3aFchBj}.0=!";
    $dbname = "yellohot_yelloxdb";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $wow = [];
    for($i=0;$i<$array_count; $i++){
        $monday = $getweeks[$i]["monday"];
        $sunday = $getweeks[$i]["sunday"];

        $get_costs = "SELECT COUNT(*) AS no_deliveries ,SUM(rd.cost) AS total_cost, ((SUM(rd.cost) * 0.3)) as y_share FROM request_header as rh JOIN request_details as rd ON rh.id = rd.request_header_id WHERE dateTime_requested BETWEEN '$monday' AND '$sunday' AND status = 'COMPLETED'";
        $get_costs = $conn->query($get_costs);
        if($get_costs->num_rows > 0){
            $result = mysqli_fetch_assoc($get_costs);
            $wow[$i]["no_deliveries"] = $result["no_deliveries"]; 
            $wow[$i]["total_cost"] = $result["total_cost"]; 
            $wow[$i]["y_share"] = $result["y_share"]; 
            $wow[$i]["from"] = $monday; 
            $wow[$i]["to"] = $sunday; 
        }
    }

    return $wow;
}

function getDateRangeForAllWeeks($start, $end){
    $fweek = getDateRangeForWeek($start);
    $lweek = getDateRangeForWeek($end);
    $week_dates = [];
    while($fweek['sunday']!=$lweek['sunday']){
        $week_dates [] = $fweek;
        $date = new DateTime($fweek['sunday']);
        $date->modify('next day');

        $fweek = getDateRangeForWeek($date->format("Y-m-d"));
    }
    $week_dates [] = $lweek;

    return $week_dates;
}

function getDateRangeForWeek($date){
    $dateTime = new DateTime($date);
    $monday = clone $dateTime->modify(('Sunday' == $dateTime->format('l')) ? 'Monday last week' : 'Monday this week');
    $sunday = clone $dateTime->modify('Sunday this week'); 
    return ['monday'=>$monday->format("Y-m-d"), 'sunday'=>$sunday->format("Y-m-d")];
}

?>