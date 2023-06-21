<?php

require Modules\Helpers\getFragmentPath('__header');

?>


<div class="container mt-3">

    <div class="row ms-2 me-2">
        <div class="login-block card bg-warning-subtle pt-3 pb-3 ps-4 pe-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12 col-12">

        <div class="alert alert-light" role="alert" style="font-size: 20px;">
            <?php
            
            $currentTimezone = new \DateTimeZone('Europe/Moscow');

            $currentTimestamp = new \DateTime('now', $currentTimezone);
            
            $currentHour = $currentTimestamp->format('G');

            if ($currentHour >= 6 && $currentHour < 12) {
                echo "Доброе утро";
            } else if ($currentHour >= 12 && $currentHour < 18) {
                echo "Добрый день";
            } else if ($currentHour >= 18 && $currentHour < 22) {
                echo "Добрый вечер";
            } else {
                echo "Доброй ночи";
            }
            
            ?>! Вы попали на страницу входа в приложение «ВЫЗОВ ВГСЧ ЛНР» Авторизируйтесь в приложении для дальнейших действий.
        </div>

        <div class="mt-3">
            <h4 class="">Войти как ВГСВ</h4>
                <a class="btn btn-outline-primary" href="/CALL_VGSO/login/vgsv" type="button">Перейти на страницу входа ВГСВ</a>
        </div>
        
        <div class="mt-4">
            <h4 class="">Войти как администратор</h4>
            <a class="btn btn-outline-primary" href="/CALL_VGSO/login/admin" type="button">Перейти на страницу входа администратора</a>
        </div>

    </div>

</div>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>