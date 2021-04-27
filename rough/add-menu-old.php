<div class="container">
		<div class="row">
			<div>
				<form name="add_food" id="add_food">
					<div class="form-group">
						<p>
							Date: <input type="text" name="food_date" id="datepick">
						</p>

						<script>
							$(function () {
								$('#datepick').datepicker();
							});
						</script>
					</div>
					<div class="form-group" id="chakula_field">
						<label for="Chakula">Chakula</label>
						<input type="text" name="chakula[]" class="form-control" id="chkl">
						<button type="button" name="add" id="add" class="btn btn-info"> Add more</button>
					</div>
					<div class="form-group" id="mboga_field">
						<label for="Mboga">Mboga</label>
						<input type="text" name="mboga[]" class="form-control" id="mboga">
						<button type="button" name="add_mboga" id="add_mboga" class="btn btn-info"> Add more Mboga</button>
					</div>
					<!-- <div class="form-group">
						<label for="Mboga">Mboga</label>
						<input type="text" name="mboga[]" class="form-control" id="chkl">
					</div> -->
					<div>
						<button type="button" id="submit" name="submit" class="btn btn-success"> Submit </button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			var i = 1;
			//Adding button
			$('#add').click(function () {
				i++;
				$('#chakula_field').append('<input type="text" name="chakula[]" class="form-control" id="row'+i+'"> <button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"> Remove</button>');
			});

			//Removing button
			$(document).on('click', '.btn_remove', function () {
				var btn_id = $(this).attr('id');
				$("#row"+btn_id+"").remove();
			});

			//Adding mboga
			var i = 1;
			
			$('#add_mboga').click(function () {
				i++;
				$('#mboga_field').append('<input type="text" name="mboga[]" class="form-control" id="row_mboga'+i+'"> <button type="button" name="remove_mboga" id="'+i+'" class="btn btn-danger btn_remove"> Remove</button>');
			});

			$(document).on('click', '.btn_remove', function () {
				var btn_id = $(this).attr('id');
				$("#row_mboga"+btn_id+"").remove();
			});


			$('#submit').click(function () {
				$.ajax({

					url:'submit-menu.php',
					method: 'POST',
					data: $('#add_food').serialize(),
					success: function (data) {
						alert(data);
						$('#add_food')[0].reset();
					}
				});
			});
		});
	</script>