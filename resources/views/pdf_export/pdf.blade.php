<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
	table {
    border-collapse: collapse;
}
td{
	text-align:center;
	vertical-align: top;
}

</style>
 
</head>
<body>
<h2 align='center'>{{$name}}</h2>
<table align="center" border="1px">
<?php
foreach($export_data as $key=>$value)
					{
						echo "<tr>";
						foreach ($value as $value_key => $value_value) {
							$data=str_split($value_value,20);
							echo "<td>";
							foreach ($data as $column_value) {
								echo $column_value."<br>";
							}
							echo "</td>";
						}
						echo "</tr>";

					}
					if(count($export_data)==1)
						echo "<tr><td colspan='6' align='center'>No Data To Show</td></tr>";
					


?>
</table>
</body>
</html>