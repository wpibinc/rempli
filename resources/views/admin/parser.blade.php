
<div class="row">
    <div class="col-md-12">
        <h3>Дата последнего обновления:</h3>
        <span>Категории: {{ $cat_last_date }}</span><br>
        <span>Продукты: {{ $prod_last_date }}</span><br>
        <div class="col-md-4">
            <div class="info-box">
                @if(($cat_old_count==$cat_now_count))
                    <span class="info-box-icon bg-aqua"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Категории</span>
                        <span class="info-box-number">Обновление не требуется</span>
                    </div>
                @else
                    <span class="info-box-icon bg-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b>Категории</b></span>
                        <span class="info-box-text">Требуется<br> обновление<br><small>Значение: {{ $cat_now_count - $cat_old_count }}</small></span>
                    </div>
                @endif

            </div>
        </div>

        @if (isset($prod_diff_count))
        <div class="col-md-4">
            <div class="info-box">
                    @if($prod_diff_count==0)
                        <span class="info-box-icon bg-aqua"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Продукты</span>
                            <span class="info-box-number">Обновление не требуется</span>
                        </div>
                    @else
                        <span class="info-box-icon bg-red"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><b>Продукты</b></span>
                            <span class="info-box-text">Требуется<br> обновление<br><small>Значение: {{ $prod_diff_count }}</small></span>
                        </div>
                    @endif
            </div>
        </div>
        @endif
    </div>
</div>





{{--<a href="/admin/parser/start" class="btn btn-warning">Запустить парсер</a>--}}
<div id="status">
    <h3>Статус:</h3>
    <span>Остановлен</span>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            0%
        </div>
    </div>
</div>
<a class="btn btn-success" href="/admin/parser/category">Запустить парсер категорий</a> <button id="start" href="#" class="btn btn-warning">Запустить парсер продуктов</button>


<script>
    var timeout;
    $('#start').click(function () {
        timeout = setInterval(getStatus, 2000);
        $(this).prop("disabled", true);
        $('.progress-bar').css('width','0%');
        $('.progress-bar').html('0%');

        $.ajax({
            type: 'GET',
            url: '/admin/parser/all',
            success: function (data) {
                console.log('Parser start');
            },
            error: function (xhr, textStatus, thrownError) {
               // alert(thrownError);
            }
        });

    });


    function getStatus() {


        $.ajax({
            type: 'GET',
            url: '/admin/parser/status',
            success: function (data) {
                procent = data.procent;
                $('#status > span').html(data.status_message);
                $('.progress-bar').css('width', procent+'%');
                $('.progress-bar').html(procent+'%');
                if (data.procent === 100) {
                    clearInterval(timeout);
                    $('#start').prop("disabled", false);
                }
            },
            error: function (xhr, textStatus, thrownError) {
                clearInterval(timeout);
                alert(thrownError);
            }
        });
    };
</script>