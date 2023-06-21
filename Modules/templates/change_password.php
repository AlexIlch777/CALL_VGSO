<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<?php

$formBlocks = ['new-password' => ['blockLabel' => 'Установка нового пароля'], 'current-password' => ['blockLabel' => 'Подтверждение текущего пароля']];

?>

<div class="container mt-4">
    <div class="return-button mt-4 mb-4">
        <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
    </div>
    <h4>Это действие нельзя будет отменить</h4>
    <p class="error">После смены пароля Вам надо заново будет входить в аккаунт</p>
    <div>
    <?php
        echo \Modules\Form\ChangePasswordForm::getRenderedForm($formData, 'Подтвердить смену пароля', 'change-password-form', NULL, NULL, $formBlocks);
    ?>
    </div>
</div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>