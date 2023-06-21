<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<div class="container mt-4">

    <div class="return-button mt-3 mb-3">
        <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
    </div>

    <h3>Данное действие нельзя будет отменить</h3>

    <?php

        echo \Modules\Form\LogoutForm::getRenderedForm($formData, 'Выйти из системы', 'logout-form');

    ?>
</div>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>