<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="public/editor/css/editormd.css" />
		<script src="public/editor/js/jquery.min.js"></script>
		<script src="public/editor/editormd.min.js"></script>
		<script type="text/javascript">
			$(function() {
				testEditor = editormd("test-editormd", {
						width   : "65%",
						height  : 600,
						syncScrolling : "single",
						path    : "public/editor/lib/"
					});

			});
		</script>
	</head>
	<body style="background-image:url(public/register/img/img.jpg);">
		<form action='index.php?c=artical&a=send' method='post'>
			<div style="margin-left:586px;color:red;">标题：<input type='text' name='title'> &nbsp;&nbsp;&nbsp;
				<a href="index.php" style="text-decoration: none;">返回首页</a>
			</div>
			
				<div class="editormd" id="test-editormd" >
					<textarea style="display:none;" name="content"></textarea>
				</div>
			
			<div style="margin-left:586px;">
				版块选择：<select name="choice">
							<?php foreach ($result as $value): ?>
								<option value="<?=$value['id']; ?>"><?=$value['category']; ?></option>
							<?php endforeach; ?>
						</select>
				<input type="submit" value="提交">
			</div>
		</form>
	</body>
</html>