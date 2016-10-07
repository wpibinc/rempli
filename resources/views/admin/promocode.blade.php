
<div class="row">
    <div class="col-md-12">
        <a href="#" id="gen">Генерировать промо код</a>
        <span id="short_link"></span>
    </div>
</div>

<script>
    $(function() {
        function str_rand() {
            var result       = '';
            var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            var max_position = words.length - 1;
            for( i = 0; i < 1; ++i ) {
                position = Math.floor ( Math.random() * max_position );
                result = result + words.substring(position, position + 1);
            }
            return result;
        }

        $("#gen").click(function() {
            $("#short_link").text(str_rand()+str_rand()+str_rand()+'-'+str_rand()+str_rand()+str_rand()+'-'+str_rand()+str_rand()+str_rand()+'-'+str_rand()+str_rand()+str_rand());
        });
    });
</script>