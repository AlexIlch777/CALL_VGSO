<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<div class="container">
    <div class="row ms-2 me-2">
        <div class="login-block card bg-warning-subtle pt-4 pb-4 ps-4 pe-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12 col-12">
            <?php

                echo \Modules\Form\VgsvLoginForm::getRenderedForm($formData, 'Войти в систему в качестве ВГСВ', 'login-form');

            ?>
        </div>
    </div>
</div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>