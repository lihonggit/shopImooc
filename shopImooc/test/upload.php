<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="style/backstage.css">
</head>
<body>
	<!-- enctype是告诉我们表单在发送数据之前是如何对文件进行编码的 -->
	<form action="doAction1.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
		<input type="file" name="myFile" accept="image/jpeg,image/gif"/> <br /> <input type="submit"
			value="上传" />
	</form>
</body>
</html>