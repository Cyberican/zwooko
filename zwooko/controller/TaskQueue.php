<?php

class TaskQueue {
	private $logged_in;
	function __construct($logged_in){
		$this->logged_in = $logged_in;
	}

	function runTaskQueue($tableData){
		if ($this->logged_in == "true"):
			echo "<table class='table'>";
			echo  "<thead>";
			echo    "<tr>";
			echo      "<th scope='col'>ID</th>";
			echo      "<th scope='col'>Task Type</th>";
			echo      "<th scope='col'>Name</th>";
			echo      "<th scope='col'>Product</th>";
			echo      "<th scope='col'>Description</th>";
			echo      "<th scope='col'>Task Status</th>";
			echo    "</tr>";
			echo  "</thead>";
			echo  "<tbody>";
			if (!empty($tableData)):
				$id = 1;
				foreach ($tableData as $items):
					echo "<tr>";
					echo "<td><a class='no-underline-link' href='update_task.php?task_uid=".$items['task_uuid']."'>".$id++."</a></td>";
					echo "<td>".$items['task_type']."</td>";
					echo "<td>".$items['task_name']."</td>";
					echo "<td>".$items['asset_name']."</td>";
					echo "<td>".$items['description']."</td>";
					echo "<td><a class='no-underline-link' href='update_task.php?task_uid=".$items['task_uuid']."'>". $items['task_status']."</a></td>";
					echo "</tr>";
				endforeach;
			else:
				echo "<tr>";
				// echo "<td colspan=5 style='background-color:lightgray;'><center><span style='color:gray;'>No Data</span></center></td>";
				for ($i=0; $i < 5; $i++){
					echo "<td style='background-color:lightgray;'><span style='color:gray;'>No Data</span></td>";
				}
				echo "</tr>";
			endif;

			echo "</tbody>";
			echo "</table>";
		else:
			echo "<a href='../index.php'>User is not logged In</a>";
		endif;
	}

	function scanQueue($queryLimit, $dbObject, $current_user){
		// echo "Query Limit: " . $queryLimit;
		$sql = "select * from task_queue where employee = '". $current_user."' limit $queryLimit";
		$tableData = array();
		$item = 0;
		foreach ($dbObject->query($sql) as $rs){
			$uuid = $rs["task_uuid"];
			$status = $rs["status"];
			$task_type = $rs["task_type"];
			$asset_name = $rs["product_name"];
			$description = $rs["description"];
			$task_name = $rs["task_name"];
			$tableData[$item++] = array(
				"task_uuid" => $uuid,
				"task_status" => $status,
				"task_name" => $task_name,
				"task_type" => $task_type,
				"asset_name" => $asset_name,
				"description" => $description
			);
		}
		return $tableData;
	}
}


?>
