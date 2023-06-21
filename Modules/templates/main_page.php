<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<?php

?>

<div class="mt-5 mb-3">

    <?php 
    if($__userStatus == 'admin') {
        ?>
        <div id="admin-app" class="ms-2 me-2 pt-5 pb-5 ps-4 pe-4" style="background-color: #e3f2fd; border-radius: 15px;">
            <div class="row">
                <div class="widget bg-light">
                    <div class="time" id="current-time"></div>
                    <div class="date" id="current-date"></div>
                </div>
            </div>
            <div class="row">
                <div id="changes-table" class="bg-light pt-5 pb-5 pe-4 ps-4 mt-5 col-lg-5 col-md-12 col-sm-12 col-12 overflow-x-auto" style="border-radius: 15px;">
                    <!-- Тут будет выводиться таблица с информацией о всех ВСГВ на основе данных, полученных AJAX-запросом -->
                </div>
                <div id="admin-main-info" class="bg-light overflow-x-auto offset-lg-1 col-lg-6 col-md-12 col-sm-12 col-12 pt-5 pb-5 ps-4 pe-4 mt-5" style="border-radius: 15px; vertical-align: center;">
                    <!-- Тут будет отображаться информация об авариях -->
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div id="vgsv-app" class="ms-2 me-2 pt-5 pb-5 ps-4 pe-4" style="background-color: #e3f2fd; border-radius: 15px">
            <div class="widget bg-light mb-5">
                <div class="time" id="current-time"></div>
                <div class="date" id="current-date"></div>
            </div>
            <div id="statuses-table">
                <!-- Тут будет таблица со статусами текущего ВГСВ -->
            </div>

            <div id="vgsv-main-info">
                <div class="bg-light pt-4 pb-4 pe-4 ps-4 mt-5 overflow-x-auto" style="border-radius: 15px;">

                    <!-- форма отправки данных об аварии, реализованна как collapse -->
                    <?php if(empty($lastChange) || !is_null($lastChange['end_timestamp'])) {
                        ?>
                            <div id="empty-change-card-block">
                                <!-- Тут будет карточка с описанием текущей смены -->
                            </div>

                        <?php
                    } else {
                        ?>

                        <div class="row bg-warning-subtle" style="border-radius: 15px;">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                <div id="change-card-block">
                                    <!-- Тут будет карточка с описанием текущей смены -->
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-4">
                                <div id="accident-info-for-vgsv">
                                    <!-- тут должна быть информация об авариях-->
                                </div>
                                
                                <div id="accident-form-block">
                                    <div class="d-grid">
                                        <a class="btn btn-primary mb-4" data-bs-toggle="collapse" href="#accident-form" role="button" aria-expanded="false" aria-controls="accident-form">
                                            Отправить сообщение об аварии
                                        </a>
                                    </div>
                                    <div id="accident-form" class="collapse mb-4">
                                        <div class="card">
                                            <div class="accident-form">
                                                <div class="card-header" style="font-size: 22px;">
                                                    Сообщите об аварии в случае необходимости
                                                </div>
                                                <div class="card-body">
                                                    <?php echo \Modules\Form\AccidentForm::getRenderedForm($formData, 'Отправить сообщение', '', NULL,$accidentFormSelectOptions); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>

                        </div>

                    <?php
                    } 
                    ?>

                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>