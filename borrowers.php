<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Список заемщиков</b>
				</large>
				<button class="btn btn-primary btn-block col-md-2 float-right" type="button" id="new_borrower"><i class="fa fa-plus"></i> Добавить нового заемщика </button>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="borrower-list">
					<colgroup>
						<col width="10%">
						<col width="35%">
						<col width="30%">
						<col width="15%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center"> # ID: </th>
							<th class="text-center"> Заемщик: </th>
							<th class="text-center"> Текущий кредит: </th>
							<th class="text-center"> График следующего платежа: </th>
							<th class="text-center"> Действие: </th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
							$qry = $conn->query("SELECT * FROM borrowers order by id desc");
							while($row = $qry->fetch_assoc()):

						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<p> Имя: <b><?php echo ucwords($row['lastname'].", ".$row['firstname'].' '.$row['middlename']) ?></b></p>
						 		<p><small> Адрес: <b><?php echo $row['address'] ?></small></b></p>
						 		<p><small> Телефон номер: <b><?php echo $row['contact_no'] ?></small></b></p>
						 		<p><small> Электронная почта: <b><?php echo $row['email'] ?></small></b></p>
						 		<p><small> Идентификатор налогоплательщика: <b><?php echo $row['tax_id'] ?></small></b></p>
						 		
						 	</td>
						 	<td class="">None</td>
						 	<td class="">N/A</td>
						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_borrower" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 			<button class="btn btn-outline-danger btn-sm delete_borrower" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button>
						 	</td>

						 </tr>

						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#borrower-list').dataTable()
	$('#new_borrower').click(function(){
		uni_modal("Новый заемщик","manage_borrower.php",'mid-large')
	})
	$('.edit_borrower').click(function(){
		uni_modal("Изменить заемщика","manage_borrower.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_borrower').click(function(){
		_conf("Вы уверены, что хотите удалить этого заемщика?","delete_borrower",[$(this).attr('data-id')])
	})
function delete_borrower($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_borrower',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("borrower successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>