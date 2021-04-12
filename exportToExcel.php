<!DOCTYPE html>
<html>
<head>
  <!--meta-->
  <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
  <!--scripts-->
  <script src="js/jquery-3.2.1.min.js"></script>  
    <script src="js/bootstrap.min.js"></script>
    <script src="js/admin.js"></script>
    <script src="js/jquery.playSound.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/exportToExcel.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Admin Panel</title>
</head>
<body class="body">
    <div class="container">
    <h2>Pick App's Request Completed</h2>
     <table class="table table-striped table-responsive" id="dataPreview">
          <thead>
            <tr class="reqHeader">
              <th>No.</th>
              <th>Driver Assigned</th>
              <th>Requested By</th>
              <th>Item Requested</th>
              <th>Origin Address</th>
              <th>Destination Address</th>
              <th>Distance</th>
              <th>Cost</th>
              <th>Date Requested</th>
              <th>Date Delivered</th>
              <th>Hours / Minutes Completed</th>
            </tr>
          </thead>
          <tbody id="tableData">
          </tbody>
    </table>
    <form action="export.php" method="POST">
    	
        <input type="submit" name="export_to_excel" value="Export" class="btn btn-success btn-lg">    
    </form>
    </div>
    <script>

       function loadRequestCompleted(){
        $.ajax({
          type: "GET",
          url: "dataPreview.php",
          success: function(data){
            obj = jQuery.parseJSON(data);
            count = obj.length;
            var noCount = 0;

              $("#tableData").empty();
              for(i=0;i<count;i++){
              noCount++;
              $("#tableData").append("<tr><td>"+noCount+"</td><td>"+obj[i].driverAssigned+", "+obj[i].driverAssigned1+"</td><td>"+obj[i].requestedBy+", "+obj[i].requestedBy1+"</td><td>"+obj[i].itemRequested+"</td><td>"+obj[i].originAddress+"</td><td>"+obj[i].destinationAddress+"</td><td>"+obj[i].distance+"</td><td>"+obj[i].cost+"</td><td>"+obj[i].dateRequested+"</td><td>"+obj[i].dateDelivered+"</td><td>"+obj[i].timeCompleted+"</td></tr>");
            }
            
          }
        });
       }

       loadRequestCompleted();

    </script>
</body>
</html>