<?php
require_once '../include.php';
$pageSize = 2;
$page = @$_REQUEST['page'] ? (int) $_REQUEST['page'] : 1;
$sql = "select * from imooc_cate";
$totalRows = getResultNum($sql);
// 得到总页码数
$totalPage = ceil($totalRows / $pageSize);
if ($page > $totalPage) {
    $page = $totalPage;
}
if ($page == null || ! is_numeric($page) || $page < 0) {
    $page = 1;
}
$offset = ($page - 1) * $pageSize;
// limit index,length 好像就是位置和长度的意思
$sql = "select id,cName from imooc_cate order by id asc limit {$offset},{$pageSize}";
$rows = fetchAll($sql);
if (! $rows) {
    alertMes("sorry,没有分类,请添加!", "addCate.php");
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="style/backstage.css">
</head>
<body>
	<div class="details">
		<div class="details_operation clearfix">
			<div class="bui_select">
				<input type="button" value="添&nbsp;&nbsp;加" class="add"
					onclick="addAdmin.php">
			</div>
		</div>
		<!--表格-->
		<table class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th width="15%">编号</th>
					<th width="30%">类型名称</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($rows as $row):?>
				<tr>
					<!--这里的id和for里面的c1 需要循环出来-->
					<td><input type="checkbox" id="c1" class="check"><label for="c1"
						class="label"><?php echo $row['id']?></label></td>
					<td><?php echo $row["cName"];?></td>
					<td align="center"><input type="button" value="修改"
						onclick="editCate(<?php echo $row['id']?>)" class="btn"><input
						type="button" value="删除"
						onclick="delCate(<?php echo $row['id']?>)" class="btn"></td>
				</tr>
			<?php endforeach;?>
			<?php if ($totalRows>0):?>
    			<tr>
					<td colspan="4"><?php echo showPage($page,$totalPage)?></td>
				</tr>
			<?php endif;?>
			</tbody>
		</table>
	</div>
</body>
<script type="text/javascript">
function editCate(id) {
    window.location="editCate.php?id="+id;
}
function delCate(id) {
	if(window.confirm("您确定要删除吗？删除之后不可恢复!")) {
	    window.location="doAdminAction.php?act=delCate&id="+id;
	}
}
</script>
</html>