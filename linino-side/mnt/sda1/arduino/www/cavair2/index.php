<?php
	require_once('incs/db.php');
?>
<?php include "incs/html_head.php" ?>

		<h1>Statistik</h1>
<?php
	if ($conn) {

                $sql = "SELECT * FROM `dht22_datas` ORDER BY `created_at` DESC LIMIT 100;";

                $rs = $conn->query($sql);
                if ($rs === false) {
                        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
                } else {
                        $rs->data_seek(0);
                        if ($rs->num_rows <= 0) {
?>
		<p class="text-message bg-warning">Keine Datensätze gefunden.<p>
<?php
			            }
?>
		<h2>Liste der letzten 100 Einträge</h2>
		<div class="panel filterable">
			<div class="table-responsive">
				<table class="table table-striped table-hover rwd-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Temperatur Keller</th>
							<th>Temperatur Außen</th>
							<th>Luftfeuchtigkeit Keller</th>
							<th>Luftfeuchtigkeit Außen</th>
							<th>Taupunkt Keller</th>
							<th>Taupunkt Außen</th>
							<th>Differenz der Taupunkte</th>
							<th>Ventilator-Status</th>
							<th>gespeichert am/um</th>
						</tr>
					</thead>
					<tbody>
<?php
			$rs->data_seek(0);
			while($row = $rs->fetch_assoc()){
?>
						<tr>
							<td data-th="ID"><?php echo $row['id'] ?></td>
							<td data-th="Temperatur Keller"><?php echo $row['temperature_inside'] ?>° C</td>
							<td data-th="Temperatur Außen"><?php echo $row['temperature_outside'] ?>° C</td>
							<td data-th="Luftfeuchtigkeit Keller"><?php echo $row['humidity_inside'] ?> %</td>
							<td data-th="Luftfeuchtigkeit Außen"><?php echo $row['humidity_outside'] ?> %</td>
							<td data-th="Taupunkt Keller"><?php echo $row['dewpoint_inside'] ?>° C</td>
							<td data-th="Taupunkt Außen"><?php echo $row['dewpoint_outside'] ?>° C</td>
							<td data-th="Differenz"><?php echo $row['dewpoints_difference'] ?></td>
							<td data-th="Ventilator-Status"><?php echo $row['fan_state'] ?></td>
							<td data-th="am/um"><?php echo $row['created_at'] ?></td>
						</tr>
<?php
			}
		}
?>
					</thead>
				</table>
			</div>
		</div>
<?php
	} else {
?>
		<p class="text-message has-error">Datenbank Verbindung fehlgeschlagen</p>
<?php
	}
?>

<?php include "incs/html_foot.php" ?>
