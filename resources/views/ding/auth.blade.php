<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<input type="hidden" value="{{$url}}" id="link">
</body>
</html>
<script src="https://cdn.bootcss.com/jquery/3.4.0/jquery.js"></script>
<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.7.13/dingtalk.open.js"></script>
<script>
    dd.ready(function () {
        dd.runtime.permission.requestAuthCode({
            corpId: 'dingfd5fb640a30488ee35c2f4657eb6378f', // 企业id
            onSuccess: function (info) {
                alert(info);
                code = info.code; // 通过该免登授权码可以获取用户身份
                var url = $("#link").val();
                window.location.href = url + code;
            },
            onFail: function (error) {
                alert('系统异常'+error);
            }
        });

    });
</script>
