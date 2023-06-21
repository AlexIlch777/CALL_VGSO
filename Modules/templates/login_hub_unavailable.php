<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<div class="container mt-4">
    <div>
        <h1>Вы уже вошли в аккаунт на этом устройстве</h1>
    </div>
    <div>
        <h3>Прежде чем войти в другой акканут Вам надо выйти из текущего
        </h3>
    </div>
    <div class="d-grid">
        <a class="btn btn-primary mt-4" href="/CALL_VGSO/logout" type="button">Перейти на страницу выхода из акканута</a>
    </div>
</div>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>