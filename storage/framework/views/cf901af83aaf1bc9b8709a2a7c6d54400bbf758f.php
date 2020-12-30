<!DOCTYPE html>
<html>
<head>

</head>
<body>

	<table border="1">
		<tr>
			<td>ID</td>
			<td>NAME</td>
			<td>USERNAME</td>
			<td>CGPA</td>
			<td>Type</td>
			
		</tr>

		<?php for($i=0; $i < count($users); $i++): ?>
		<tr>
			<td><?php echo e($users[$i]['id']); ?></td>
			<td><?php echo e($users[$i]['username']); ?></td>
			<td><?php echo e($users[$i]['password']); ?></td>
			<td><?php echo e($users[$i]['name']); ?></td>
			<td><?php echo e($users[$i]['type']); ?></td>
			
		</tr>
		<?php endfor; ?>
	</table>

</body>
</html><?php /**PATH H:\ATP-3\Final\try\resources\views/home/userpdf.blade.php ENDPATH**/ ?>