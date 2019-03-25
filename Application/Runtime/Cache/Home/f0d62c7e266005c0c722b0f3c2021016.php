<?php if (!defined('THINK_PATH')) exit();?><form action="/index.php/home/user/save" method="post">
    <input type="text" name="id" id="id"/>
    <input type="text" name="name" id="name"/>
    <button type="submit">↑↑↑</button>
    <input type="button" onclick="ajax_submit()"value="ajax↑↑↑">
</form>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<script>
    function ajax_submit() {
        $.post(
            "/index.php/Home/user/save",
            {
                id:$('#id').val(),
                name:$('#name').val()
            },
            function (data) {
                console.log(data);
            }
        );
    }
</script>