<?php
include('includes/dbconfig.php');
$record_per_page = 10;
$page = '';
$output = '';

if(isset($_POST["page"])){
	$page = $_POST["page"];

}else{
	$page = 1;

}

$start_from = ($page-1)*$record_per_page;

$page_query = "SELECT request_header.dateTime_requested, request_header.dateTime_delivered,request_header.requested_by, mst_user.firstname, mst_user.lastname, package_type.package_name, request_details.origin_address, request_details.destination_address, request_details.distance, request_details.cost, mst_admin_user.fname, mst_admin_user.lname FROM request_header INNER JOIN request_details ON request_header.id = request_details.request_header_id INNER JOIN mst_user ON request_header.requested_by = mst_user.id INNER JOIN package_type ON request_details.package_type = package_type.id INNER JOIN mst_admin_user ON request_header.assigned_driver = mst_admin_user.id WHERE request_header.status = 'COMPLETED' ORDER BY request_header.dateTime_requested DESC";
$page_result = $conn->query($page_query);
$total_records = mysqli_num_rows($page_result);
$total_pages = ceil($total_records/$record_per_page);


if($total_pages == 0){

}
else {
$output .= "<div class='row' style='margin: 0'><div class='col-sm-1' style='padding-right: 0'><div><div><span class='panner fa fa-chevron-circle-left fa-2x' id='arr-left' data-scroll-modifier='-1' style='margin: 25px'></span></div></div></div><div class='col-sm-10' style='padding: 0'><div class='pagination-wrapper' >
<div class='pagination-wrapper1' id='element'>
";
for($i=1;$i<=$total_pages;$i++){
    if($i == $page){
        $output .= "
    <ul class='pagination'>
        <li class='pagination_link' id='".$i."' ><a href='#' >".$i."</a></li>
    </ul>


    ";
    }else{
        $output .= "
    <ul class='pagination'>
        <li class='pagination_link' id='".$i."' ><a href='#' >".$i."</a></li>
    </ul>


    ";
    }
    
}
$output .= "</div></div></div><div class='col-sm-1' style='padding-left: 0; text-align: right'><div><div><span class='panner fa fa-chevron-circle-right fa-2x' id='arr-right' data-scroll-modifier='1' style='margin: 25px'></span></div></div></div></div>
<script>



    var scrollHandle = 0,
        scrollStep = 10,
        parent = $('.pagination-wrapper');

    //Start the scrolling process
    $('.panner').on('mouseenter', function () {
        var data = $(this).data('scrollModifier'),
            direction = parseInt(data, 10);

        $(this).addClass('active');

        startScrolling(direction, scrollStep);
    });

    //Kill the scrolling
    $('.panner').on('mouseleave', function () {
        stopScrolling();
        $(this).removeClass('active');
    });

    //Actual handling of the scrolling
    function startScrolling(modifier, step) {
        if (scrollHandle === 0) {
            scrollHandle = setInterval(function () {
                var newOffset = parent.scrollLeft() + (scrollStep * modifier);

                parent.scrollLeft(newOffset);
            }, 10);
        }
    }

    function stopScrolling() {
        clearInterval(scrollHandle);
        scrollHandle = 0;
    }


</script>


";


echo $output;
}


?>