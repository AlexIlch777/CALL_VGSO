<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<div class="container mt-4">

    <h3><?php echo $__currentUser['name'] ?> уже заступил на смену</h3>
    <h6 class="mt-3">Можете завершить смену или вернуться на главную страницу</h6>

    <div class="return-button mt-2">
        <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
    </div>

    <div class="return-button mt-3">
        <a href="/CALL_VGSO/vgsv/<?php echo $__currentUser['id'] ?>/endchange" type="button" class="btn btn-outline-primary">Завершить смену</a>
    </div>

</div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>