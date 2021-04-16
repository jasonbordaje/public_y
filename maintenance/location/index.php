<?php
session_start();
$id = $_SESSION['id'];
error_reporting(0);
$successSession = $_SESSION["success"];
$errorSession = $_SESSION["error"];
include('../../includes/global.php');

?>
<!DOCTYPE html>
<html>
<head>
	<link href="<?php echo $url_home ?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $url_home ?>/css/admin.css">
    <link rel="stylesheet" href="<?php echo $url_home ?>/css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $url_home ?>/favicon.ico">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
    <script src="<?php echo $url_home;?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo $url_home;?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $url_home;?>/js/admin.js"></script>
    
    <style type="text/css">
    	.navbar-fixed-top{
    		position: initial;
    	}
    	.page .navbar-fixed-top{
    		margin-bottom: 45px;
    	}
    </style>
</head>

<body>
	
	<div class="page">
		<?php include('../../layout/header.php') ?>
		<div class="container">
			<table class="table table-striped" id="table">
	            <thead>
	                <tr>
	                    <th>No.</th>
	                    <th>Name</th>
	                    <th>Lat Index</th>
	                    <th>Long Index</th>
	                    <th>Rate</th>
	                </tr>
	            </thead>
	        </table>
		</div>
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel"><strong>Modal title</strong></h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form method="post" action="#" id="locationUpdate">
							<div class="row">
								<div class="col col-md-6">
									<div clas="form-group">
										<label>Location Latitude</label>
										<input type="number" name="location_lat" class="form-control">
									</div>
								</div>
								<div class="col col-md-6">
									<div class="form-group">
										<label>Location Longitude</label>
										<input type="number" name="location_long" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col col-md-6">
									<div class="form-group">
										<label>Rate</label>
										<input type="number" name="rate" step=".01" class="form-control">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="btn-update">Save changes</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
			var url = '<?php echo $url_home;?>';
			var dataTable = $('#table').DataTable({
			    'processing': true,
			    'serverMethod': 'post',
			    'searching': true, 
			    'ajax': url+'/locations.php',
			     "columnDefs": [ {
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        } ],
			    'columns': [
			    	{data: 'count'},
			    	{data: 'location_name'},
			    	{data: 'location_lat'},
			    	{data: 'location_long'},
			    	{data: 'rate'}
			    ],
			       
			});
			var locationLat;
			var locationLong;
			var locationId;
			var rate;
			$(document).on('click','#table tr',function(){
				var table = $('#table').DataTable();

				var data = table.row( this ).data();
				locationId = data.id;
				locationLat = data.location_lat;
				locationLong = data.location_long;
				rate = data.rate;

				$('input[name=location_lat]').val(locationLat);
				$('input[name=location_long]').val(locationLong);
				$('input[name=rate]').val(rate);
				$('.modal-title').html('<strong>'+data.location_name+'</strong>');
				$
				$('.modal').modal('show');
			})
			
			$('#btn-update').click(function(){
				locationLat = $('input[name=location_lat]').val();
				locationLong = $('input[name=location_long]').val();
				rate = $('input[name=rate]').val();
				$.ajax({
					url: url+'/updateLocation.php',
					type: 'get',
					data: 'id='+locationId+'&location_lat='+locationLat+'&location_long='+locationLong+"&rate="+rate,
					success: function(data){
						$('.modal').modal('hide');
						$('#table').DataTable().ajax.reload();
						console.log(data);
					}	

				});
				
			});
			
		});
		
	</script>
</body>
</html>