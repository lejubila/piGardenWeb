    <div class="text-right">
        <a class="btn btn-app btn-primary btn-table-refresh" href="#" data-state="stop" onclick="followLogChangeState(this)">
            <i class="fa fa-play"></i> <span class="button-zone-text follow-play">{{__('Follow Log')}}</span>
            <span class="button-zone-text follow-stop hide">{{__('Stop Log')}}</span>
        </a>
    </div>

    <script>
        if (typeof followLogChangeState != 'function') {
            function followLogChangeState(button) {
                if($(button).data('state') == 'stop') {
                    $(button).data('state', 'play');
                    $(button).find('i').removeClass('fa-play').addClass('fa-stop');
                    $(button).find('.follow-play').addClass('hide');
                    $(button).find('.follow-stop').removeClass('hide');
                } else {
                    $(button).data('state', 'stop');
                    $(button).find('i').removeClass('fa-stop').addClass('fa-play');
                    $(button).find('.follow-stop').addClass('hide');
                    $(button).find('.follow-play').removeClass('hide');
                }
            }

            setInterval(function(){
                    if($('.btn-table-refresh').data('state') == 'play')
                        //crud.table.ajax.reload();
                        crud.table.order([5,'desc']).page('first').draw();
            },
                10000
            );
        }

    </script>
