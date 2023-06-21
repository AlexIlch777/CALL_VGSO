<?php

require Modules\Helpers\getFragmentPath('__header');

$openButtons = ['add-oto' => ['blockName' => 'oto', 'buttonName' => 'Указать информацию об ОТО'], 'add-sds' => ['blockName' => 'sds', 'buttonName' => 'Указать информацию об СДС'], 'add-mber' => ['blockName' => 'mber', 'buttonName' => 'Указать информацию об МБЭР']];

$formBlocks = ['duty-department-info' => ['blockLabel' => 'Информация о дежурном отделении'], 'reserve-department-info' => ['blockLabel' => 'Информация о резервном отделении'], 'forces-info' => ['blockLabel' => 'Информация об итоговом количестве оперативного состава'], 'additional_department' => ['blockLabel' => 'Отметьте наличие дополнительных служб']];

?>

<div class="container mb-3">
    <?php

    echo \Modules\Form\NewChangeForm::getRenderedForm($formData, 'Отправить информацию о заступлении ВГСВ на смену', 'vgsv-form', NULL, $selectOptions, $formBlocks, $openButtons);

    ?>  
</div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>