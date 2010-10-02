<?php
# TODO:
# Check SQL injure
# Jianhua classes (class -> string)
# Deal with "输入班级" string

# TODO improve:
# Use spaces instead of tabs
# Deal with no result
# Make search result clickable

require('inc/common.php');
require('inc/admin_common.php');

$login = is_login();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $event_shortname; ?>分数查询系统</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
#column1 {
    width: 200px;
    margin-left: 50px;
}
#column2 {
    width: 220px;
    margin-left: 40px;
}
#column3 {
    margin-left: 15px;
    width: 220px;
}
    </style>
    <script type="text/javascript">
    function show_login() {
        var login_form = document.getElementById("login_form");
        login_form.style.display = "block";
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
        <p class="small"><a href="http://www.shiyihcc.com">HCC</a> » <a href="index.php">分数查询系统</a> » 首页</p>
        <hr />
        <?php
        if ($login) {
            echo '<p class="small"><a href="manage.php">管理面版</a> | <a href="logout_action.php">登出</a></p><hr />';
        }
        ?>
        <div class="warn left"><p>大家好，我今天一个误操作，导致整个数据库被 drop。在此，我表示最诚挚的歉意。我真的错了…输分的同志们，我对不起你们…原谅我。你们辛苦了～</p><p>另外如果大家遇到什么问题，可以邮件联系我：liu.dongyuan@gmail.com。再次对你们表示感谢。</p><p>关于建华的班级，请先写为 10x 班。如建华2班写为 102 班。</p><p>关于并列的成绩，名次那个框内容是可以改的。把名次改成一样的就行了。</p><p class="xsmall" style="text-align: right;">柳东原 2010年9月30日</p></div>
        <hr />
        <div class="column" id="column1">
            <h2>按年级查询</h2>
            <ul>
                <?php
                $query = "SELECT * FROM $table_grade;";
                $result = $dbc->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href=\"list_match.php?grade_id={$row['id']}\">{$row['name']}</a></li>\n";
                }
                ?>
            </ul>
            <hr />
            <h2>查看全部</h2>
            <ul>
                <li><a href="list_match.php">查看所有比赛</a></li>
                <li><a href="list_score.php">查看所有成绩</a></li>
            </ul>
        </div>
        <div class="column" id="column2">
            <h2>按项目查询</h2>
            <ul>
                <?php
                $query = "SELECT * FROM $table_event ORDER BY name;";
                $result = $dbc->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href=\"list_match.php?event_id={$row['id']}\">{$row['name']}</a></li>\n";
                }
                ?>
            </ul>
        </div>
        <div class="column" id="column3">
            <h2>按运动员查询</h2>
            <form action="list_score.php" method="get">
                <p>
                    <input type="text" class="input" name="name" id="name" value="输入姓名" onFocus="if(this.value=='输入姓名')this.value=''" onBlur="if(this.value=='')this.value='输入姓名'" />
                </p>
                <p>
                    <input type="submit" value="查询" />
                </p>
            </form>
            <hr />
            <h2>按年级和班级查询</h2>
            <form action="list_score.php" method="get">
                <p class="small">若需查询某年级的全部成绩，<br />请不用填写班级。</p>
                <p>
                    <select name="grade">
                        <?php
                        $query = "SELECT * FROM $table_grade;";
                        $result = $dbc->query($query);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"{$row['id']}\">{$row['name']}</option>\n";
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <input type="text" class="input" name="class" id="class" value="输入班级" onFocus="if(this.value=='输入班级')this.value=''" onBlur="if(this.value=='')this.value='输入班级'" />
                </p>
                <p>
                    <input type="submit" value="查询" />
                </p>
            </form>
        </div>
        <hr />
        <?php
        if (!$login) {
            echo <<<EOF
        <form id="login_form" action="login_action.php" method="get" style="display: none;">
            <p><input type="password" name="password" /></p>
            <p><input type="submit" value="管理登录" /></p>
            <hr />
        </form>
EOF;
        }
        ?>
        <p class="xsmall"><a onclick="show_login()">♥</a> <?php echo $footer_string; ?></p>
    </div>
</body>
</html>
