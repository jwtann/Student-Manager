<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'public/view/header.php' ?>
<div class="container">
    <div class="row">
        <?php include 'public/view/left.php' ?>
        <div class="col-lg-9">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="index.php?s=admin/student/index">stu list</a></li>
                <li><a href="index.php?s=admin/student/create">add stu</a></li>
            </ul>
            <div class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong class="tishi"></strong>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>id</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>年龄</th>
                    <th>手机</th>
                    <th>班级</th>
                    <th width="150">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($student as $k => $v){ ?>
                    <tr>
                        <td><?php echo $v['uid']; ?></td>
                        <td><?php echo $v['name']; ?></td>
                        <td><?php echo $v['sex']; ?></td>
                        <td><?php echo $v['age']; ?></td>
                        <td><?php echo $v['phone']; ?></td>
                        <td><?php echo $v['gname']; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="index.php?s=admin/student/edit&id=<?php echo $v['uid']; ?>" class="btn btn-primary">编辑</a>
                                <a href="javascript:;" onclick="del(<?php echo $v['uid']; ?>,this)" class="btn btn-danger">删除</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // function del(uid) {
        //     if(confirm('确定要删除该条学生的数据吗?')){
        //         location.href = 'index.php?s=admin/student/del&id=' + uid;
        //     }
        // }

        function del(uid,obj) {
            if (confirm('确定要删除该条学生的数据吗?')) {
                // 如果确定要删除,发送ajax
                $.ajax({
                    url:'index.php?s=admin/student/ajaxDel&id=' + uid,
                    type:'get', //如果请求方式是post,就需要data属性,如果是get可以不要
                    dataType:'json', //定义返回数据类型
                    success:function (phpData) {
                        if (phpData.valid){
                            //刷新当前页面
                            $('.alert').show();
                            $('.tishi').html(phpData.message);
                            var tr = obj.parentNode.parentNode.parentNode;
                            var tbody = tr.parentNode;
                            tbody.removeChild(tr);
                            // parent.location.reload();
                            // window.location.reload();
                        }else {
                            $('.alert').show();
                            $('.tishi').html(phpData.message);
                        }
                    }

                })
            }
        }
    </script>
    <?php include 'public/view/footer.php' ?>
</body>
</html>