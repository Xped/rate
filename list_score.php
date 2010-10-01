<?php
require('inc/common.php');
require('inc/admin_common.php');

$login = is_login();

$grade = (int)$_REQUEST['grade'];
$class = (int)$_REQUEST['class'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<title>查询成绩 - <?php echo $event_shortname; ?>分数查询系统</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
    <style>
td {
	padding: 6px;
	font-size: 0.9em;
}
#match {
	width: 210px;
}
#rank {
	width: 50px;
}
#name {
	width: 100px;
}
#class {
	width: 50px;
}
#score {
	width: 120px;
}
#manage {
	width: 90px;
}
    </style>
	<script type="text/javascript">
    function delete_confirm(id) {
		r = confirm("您确认要删除该条成绩吗？这会导致比赛名次出现空缺，请尽量使用修改功能。如果一定要删除，请随后修改相关的名次数据。");
		if (r == true) {
			document.location = "delete_action.php?id=" + id;
		}
    }
    </script>
</head>
<body>
	<div id="wrapper">
		<h1><?php
		if ($event_prefix)
			echo $event_prefix . '<br />';
		echo $event_name;
		?>分数查询系统</h1>
		<p class="small"><a href="http://www.shiyihcc.com">HCC</a> » <a href="index.php">分数查询系统</a> » 查询成绩</p>
		<hr />
		<table>
			<tr><th id="match">比赛</th><th id="rank">名次</th><th id="name">姓名</th><th id="class">班级</th><th id="score">成绩</th><?php if ($login) echo "<th id=\"manage\">管理</th>" ?></tr>
			<?php
			$query = "SELECT
			         $table_score.id AS id,
			         $table_score.rank AS rank,
			         $table_score.name AS name,
			         $table_score.class AS class,
			         $table_score.score AS score,
			         $table_grade.name AS grade,
			         $table_event.name AS event
			         FROM
			         $table_score, $table_grade, $table_event, $table_match
			         WHERE
			         $table_score.match_id = $table_match.id AND
			         $table_match.grade_id = $table_grade.id AND
			         $table_match.event_id = $table_event.id";
			if ($class)
				$query .= " AND $table_score.class = $class";
			if ($grade)
				$query .= " AND $table_match.grade_id = $grade";
			if ($debug && $login)
				echo "<p>" . $query . "</p>";
			$result = $dbc->query($query);
			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>{$row['grade']}{$row['event']}</td>" .
				     "<td>{$row['rank']}</td>" .
					 "<td>{$row['name']}</td>" .
					 "<td>{$row['class']}</td>" .
					 "<td>{$row['score']}</td>";
				if ($login) {
					echo "<td><a href=\"edit.php?id={$row['id']}\">修改</a> · <a href=\"\" onclick=\"delete_confirm('{$row['id']}'); return false;\">删除</a></td>";
				}
				echo "</tr>";
			}
			?>
		</table>
		<hr />
		<p>♥ Proudly powered by Spoquery, made in HCC.</p>
  	</div>
</body>
</html>