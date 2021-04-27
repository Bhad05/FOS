<?php 
	session_start();
	include '../connect.php';

	$user_id = $_SESSION['user_id'];
 ?>
<!DOCTYPE html>
<html>
<head>

	<title>Food Ordering System - Admin</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<script src="../jquery-3.6.0.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<style>
		.col {
			float: left;
			width: 50%;
			padding: 40px;
			margin-left: 30px;
			border-radius: 10px;
			background-color: lightgray;
		}
		.row:after{
			content: "";
			display: table;
			clear: both;
			justify-content: center;
		}
		.col:hover {
			background-color: brown;
			color: white;
			transition: 0.7s;
			cursor: pointer;
		}
		p {
			/*pointer-events: none;*/
		}
	</style>
</head>
<body>
	<div class="container">
		<form action="submit-order.php" method="POST">
		<div class="row">
				<?php 
					$today = date("Y-m-d");
					$divID = 1;

					$sql = 'SELECT * FROM menu WHERE menu_type_id = 1 AND menu_date = "'.$today.'"';
					$result = mysqli_query($conn, $sql);
					
					while ($rows = mysqli_fetch_assoc($result)) {
					
					echo '
					<div class="col" id="main_chakula_div">
				 	<card class="chakula_div" id="'.$divID.'" data-id="'.$rows['menu_id'].'" style="font-weight: bold; font-size: 25px;">
				 		'.$rows['menu_name'].'
				    </div>';
				    $divID++;
					}
				 ?>
		</div>

		<div class="row" style="margin-top: 60px;">
				<?php 
					$today = date("Y-m-d");
					$divID_2 = 100;
					
					$sql1 = 'SELECT * FROM menu WHERE menu_type_id = 2 AND menu_date = "'.$today.'"';
					$result1 = mysqli_query($conn, $sql1);
					//print_r($result);
					while ($rows1 = mysqli_fetch_assoc($result1)) {
					
					echo '
					<div class="col">
				 	<p class="mboga_div" id="'.$divID_2.'" data-id="'.$rows1['menu_id'].'" style="font-weight: bold; font-size: 25px;">
				 		'.$rows1 ['menu_name'].'
				    </div>'; 
				    $divID_2++;
					}
				 ?>
		</div>

		<div class="row" style="margin-top: 60px;">
			<button class="btn btn-success" type="button" id="submit" name="submit">Order your lunch</button>
		</div>
	</form>
	</div>

	<script>		
// get all divs with class optionsecoptions
        var options = document.getElementsByClassName("chakula_div"); console.log(options )
// add click listener to them
        for(var i=0; i<options.length; ++i) {
            options[i].addEventListener("click", function(event){
                if(!this.active) {
                    this.setAttribute("active","active");
                    // remove all active attributes from other divs
                    for(var i=0; i<options.length; ++i) {
                        if(options[i] != this) {
                            options[i].removeAttribute("active");
                        }
                    }
                }
            }, false);
        }

		var countClick = 0;
		var order_items = [];
		//Translating uid session to JS arry
		order_items.push(JSON.parse('<?= json_encode($user_id); ?>'));

		$(document).ready(function () {

			const chakula_div_id = document.querySelectorAll('.chakula_div');
			chakula_div_id.forEach(function (chakulaDiv) {
				const id = chakulaDiv.getAttribute('data-id');
				chakulaDiv.addEventListener('click', function (event) {
					
					//Getting clicked element id and DB value
					var get_id = event.target.id; 
					var get_data_id = event.target.getAttribute('data-id');

					if(!this.active) {
                    this.setAttribute("active","active");
                    // remove all active attributes from other divs
                    for(var i=0; i<options.length; ++i) {
                        if(options[i] != this) {
                            options[i].removeAttribute("active");
                        }
                    }
                }
					// console.log(countClick.length)
					// if (countClick.length != 1 ) {
					// 	$('.chakula_div').css({
					// 		'pointer-events': 'none'
					// 	});	
					// }
					order_items.push(get_data_id);
					$('#'+get_id).css({
						'background-color': 'red'
					});
				}, false);
			});
		});

		$(document).ready(function () {
			const mboga_div_id = document.querySelectorAll('.mboga_div');
			mboga_div_id.forEach(function (mbogaDiv) {
				const id = mbogaDiv.getAttribute('data-id');
				mbogaDiv.addEventListener('click', function () {

					//Getting clicked element id and DB value
					var get_id2 = event.target.id; 
					var get_data_id2 = event.target.getAttribute('data-id');

					order_items.push(get_data_id2);
					$('#'+get_id2).css({
						'background-color': 'red'
					});
					//console.log(get_data_id2);
				});
			});
		});

		$(document).ready(function () {
			$('#submit').click(function () {
				//console.log(order_items);
				//var data_to_send = $.serialize(order_items);

				$.ajax({
					type: 'POST',			
					url: 'http://localhost/fos/admin/submit-order.php',
					data: {
							order_items: order_items
					},
					success: function (data) {
						console.log(data);
					}
				});
			});
		});
	</script>
</body>
</html>