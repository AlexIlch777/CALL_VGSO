<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<?php 

$getParamsForHrefs = \Modules\Helpers\getGetParams(['all_changes']);

?>

<div class="container mt-5">

<?php

if(isset($_GET['change_item'])) {
    $pageFromQuery = $_GET['change_item'];
    if($pageFromQuery == 'all_changes') {
        ?>

        <div class="return-button">
            <a href="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/allchanges<?php echo $getParamsForHrefs ?>" type="button" class="btn btn-outline-primary">Вернуться на список смен ВГСВ</a>
        </div>
    
        <?php
    } else if ($pageFromQuery == 'vgsv_item') {
        ?>

        <div class="return-button">
            <a href="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>" type="button" class="btn btn-outline-primary">Вернуться на страницу ВГСВ</a>
        </div>

        <?php
    } 
} else {
    ?>

    <div class="return-button">
        <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
    </div>

    <?php
}

?>

<div class="card mt-5 mb-5">
  <div class="card-header" style="font-size: 30px;">
    Основная информация о смене
  </div>
  <div class="card-body">
    
    <h4 class="mt-3">Информация о дежурной смене</h4>
    <h5 class="card-title ms-3 mt-4">Старший командир дежурной смены:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['duty_department_senior_commander_name'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Номер телефона старшего командира дежурной смены:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['duty_department_senior_commander_telephone_number'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Номер дежурного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['duty_department_number'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Командир дежурного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['duty_department_commander_name'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Номер телефона командира дежурного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['duty_department_commander_telephone_number'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Марка и госномер автомобиля дежурного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">        
        <?php
            echo $change['duty_department_vehicle'];
        ?>
    </p>
    
    <h4 class="mt-5">Инфомация о резервной смене</h4>
    <h5 class="card-title ms-3 mt-4">Старший командир резервной смены:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['reserve_department_senior_commander_name'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Номер телефона старшего командира резервной смены:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['reserve_department_senior_commander_telephone_number'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Номер резервного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['reserve_department_number'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Командир резервного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['reserve_department_commander_name'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Номер телефона командира резервного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">
        <?php
            echo $change['reserve_department_commander_telephone_number'];
        ?>
    </p>
    <h5 class="card-title ms-3 mt-4">Марка и госномер автомобиля резервного отделения:</h5>
    <p class="card-text ms-5" style="font-size: 18px;">        
        <?php
            echo $change['reserve_department_vehicle'];
        ?>
    </p>

                <?php
                    
                    if(isset($change['oto_duty_name']) && $change['oto_duty_name'] != '' || isset($change['oto_duty_telephone_number']) && $change['oto_duty_telephone_number'] != '') {
                        ?>
                        <h4 class="card-title mt-5">Информация об ОТО:</h4>
                        <?php
                        if(isset($change['oto_duty_name']) && $change['oto_duty_name'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Дежурный ОТО:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['oto_duty_name'] ?>
                            </p>
                            <?php
                        }

                        if(isset($change['oto_duty_telephone_number']) && $change['oto_duty_telephone_number'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Номер телефона дежурного ОТО:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['oto_duty_telephone_number'] ?>
                            </p>
                            <?php
                        }
                    }

                    ?>

                    <?php
                    
                    if(isset($change['sds_duty_name']) && $change['sds_duty_name'] != '' || isset($change['sds_duty_telephone_number']) && $change['sds_duty_telephone_number'] != '') {
                        ?>
                        <h4 class="card-title mt-5">Информация об СДС:</h4>
                        <?php
                        if(isset($change['sds_duty_name']) && $change['sds_duty_name'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Дежурный СДС:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['sds_duty_name'] ?>
                            </p>
                            <?php
                        }

                        if(isset($change['sds_duty_telephone_number']) && $change['sds_duty_telephone_number'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Номер телефона дежурного СДС:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['sds_duty_telephone_number'] ?>
                            </p>
                            <?php
                        }
                    }
                    
                    ?>

                    <?php
                    
                    if(isset($change['mber_duty_name']) && $change['mber_duty_name'] != '' || isset($change['mber_duty_telephone_number']) && $change['mber_duty_telephone_number'] != '' || isset($change['mber_vehicle']) && $change['mber_vehicle'] != '') {
                        ?>
                        <h4 class="card-title mt-5">Информация об МБЭР:</h4>
                        <?php
                        if(isset($change['mber_duty_name']) && $change['mber_duty_name'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Дежурный МБЭР:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['mber_duty_name'] ?>
                            </p>
                            <?php
                        }

                        if(isset($change['mber_duty_telephone_number']) && $change['mber_duty_telephone_number'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Номер телефона дежурного МБЭР:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['mber_duty_telephone_number'] ?>
                            </p>
                            <?php
                        }

                        if(isset($change['mber_vehicle']) && $change['mber_vehicle'] != '') {
                            ?>
                            <h5 class="ms-3 mt-4">Марка и госномер автомобиля МБЭР:</h5>
                            <p class="card-text mt-2 ms-5" style="font-size: 18px;">
                                <?php echo $change['mber_vehicle'] ?>
                            </p>
                            <?php
                        }
                    }
                    
                    ?>
    <h4 class="card-title mt-5">Группировка сил на смене:</h4>
    <h5 class="ms-3 mt-4">Человек</h5>
    <p class="card-text mt-2 ms-5" style="font-size: 18px;">
        <?php echo $change['people_forces'] ?>
    </p>
    <h5 class="ms-3 mt-4">Автомобилей</h5>
    <p class="card-text mt-2 ms-5" style="font-size: 18px;">
        <?php echo $change['auto_forces'] ?>
    </p>
    
  </div>
</div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>