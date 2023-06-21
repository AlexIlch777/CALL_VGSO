<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<div class="container mt-4">
    <div class="return-button mt-4 mb-4">
        <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
    </div>
    <h2>Страница завершения смены</h2>
    <p>Это действие нельзя будет отменить</p>

    <?php

        echo \Modules\Form\EndChangeForm::getRenderedForm($formData, 'Завершить смену', 'end-change-form');

    ?>
</div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>