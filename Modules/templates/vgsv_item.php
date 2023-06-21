<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<?php 

$getParamsForChangeHrefs = \Modules\Helpers\getGetParams([], ['change_item' => 'vgsv_item']);

$getParamsForAllChangesHrefs = \Modules\Helpers\getGetParams([], ['all_changes' => 'vgsv_item']);

$vgsosSelectOptions = \Modules\Helpers\getOptionsForSelect('Vgso', 'id, name');

?>

<div class="container">

<div class="return-button mt-5">
    <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
</div>

<div class="card mt-5">
  <div class="card-header" style="font-size: 30px;">
    Основная информация о ВСГВ
  </div>
  <div class="card-body">
    <h5 class="card-title">Название взвода:</h5>
    <p class="card-text" style="margin-top: -10px;">

        <div class="row" style="align-items: center;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                <?php
                    echo $vgsv['name'];
                ?>
            </div>
            <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">
            <?php 
            if($__userStatus == 'admin') {
                ?>
                <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-name">
                    Заменить название
                </button>
                <?php
            }
            ?>
            </div>
        </div>

    </p>
    <h5 class="card-title">Радиопозывной взвода:</h5>
    <p class="card-text" style="margin-top: -10px;">

        <div class="row" style="align-items: center;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                <?php
                    echo $vgsv['radio_call'];
                ?>
            </div>
            <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">
            <?php
            if($__userStatus == 'admin') {
                ?>
                <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-radio-call">
                    Заменить радиопозывной
                </button>
                <?php
            }
            ?>
            </div>
        </div>        
        
    </p>
    <h5 class="card-title">Относится к:</h5>
    <p class="card-text" style="margin-top: -10px;">   
        
        <div class="row" style="align-items: center;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                <?php
                    echo $vgsv['vgsoName'];
                ?>
            </div>
            <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">
            <?php
            if($__userStatus == 'admin') {
                ?>
                <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-vgso">
                    Заменить ВГСО
                </button>
                <?php
            }
            ?>
            </div>
        </div> 

    </p>
    <h5 class="card-title">Основной номер телефона ВГСВ:</h5>
    <p class="card-text" style="margin-top: -10px;">    
        
        <div class="row" style="align-items: center;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                <?php
                    echo $vgsv['telephone_number'];
                ?>
            </div>
            <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">
            <?php
            if($__userStatus == 'vgsv') {
                ?>
                <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-telephone-number">
                    Заменить номер
                </button>
                <?php
            }
            ?>
            </div>
        </div> 
        
    </p>
    <h5 class="card-title">Командир ВГСВ:</h5>
    <p class="card-text" style="margin-top: -10px;"> 
        
        <div class="row" style="align-items: center;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                <?php
                    echo $vgsv['senior_commander_name'];
                ?>
            </div>
            <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">

            <?php 
            if($__userStatus == 'vgsv') {
                ?>
                    <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-senior-commander-name">
                        Заменить командира
                    </button>
                <?php
            }
             ?>

            </div>
        </div>   

    </p>
    <h5 class="card-title">Номер телефона командира ВГСВ:</h5>
    <p class="card-text" style="margin-top: -10px;"> 
    
        <div class="row" style="align-items: center;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                <?php
                    echo $vgsv['senior_commander_telephone_number'];
                ?>
            </div>
            <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">
            <?php 
            if($__userStatus == 'vgsv') {
                ?>

                <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-senior-commander-telephone-number">
                    Заменить номер
                </button>

                <?php
            }
            ?>
            </div>
        </div> 

    </p>

    <?php
    
    if(isset($vgsv['apo_vehicle']) && $vgsv['apo_vehicle'] != '') {
        ?>
            <h5 class="card-title">
                Автомобиль пожарного оборудования:
            </h5>
            <p class="card-text" style="margin-top: -10px;">   
                            
            <div class="row" style="align-items: center;">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6 mt-1" style="font-size: 18px;">
                        <?php
                            echo $vgsv['apo_vehicle'];
                        ?>
                    </div>
                    <div class="mt-1 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right;">
                    <?php
                    if($__userStatus == 'vgsv') {
                        ?>
                        <button type="button" style="font-size: 17px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#change-vgsv-apo-vehicle">
                            Заменить АПО
                        </button>
                        <?php
                    }
                    ?>
                    </div>
                </div>      
            
            </p>
        <?php
    }
    
    ?>
  </div>
</div>


<?php if (count($changes) > 0) { ?>
<div class="changes-table mt-5 overflow-x-auto">
    <h2>Краткая информация о последних сменах</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Дата заступления</th>
                <th scope="col">Дата окончания</th>
                <th scope="col">Старший командир дежурной смены</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>


<?php

foreach ($changes as $change) {
    ?>
    <tr>
        <td><?php echo $change['start_timestamp'] ?></td>
        <?php if($change['end_timestamp'] != NULL) {
            ?>
                <td><?php echo $change['end_timestamp'] ?></td>
            <?php
        } else {
            ?>
                <td>В процессе</td>
            <?php
        }
        ?>
        <td><?php echo $change['duty_department_commander_name'] ?></td>
        <td><a href="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/change/<?php echo $change['id'], $getParamsForChangeHrefs ?>">Подробнее</a></td>
    </tr>
    <?php
}

?>

        </tbody>
    </table>
    <h4 class="d-grid mt-4 mb-5"><a type="button" class="btn btn-primary" href="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/allchanges<?php echo $getParamsForAllChangesHrefs ?>">Посмотреть полный список смен</a></h4>
</div>
<?php } else {
    ?>
    <div class="mt-5 mb-5"><h4>ВГСВ не заступал на смены. После первого заступления на смену тут будет отображаться информация о текущих и завершённых сменах.</h4></div>
    <?php
} ?>

<!-- Блок с модальными окнами -->

<?php
if($__userStatus == 'admin') {
    ?>

<!-- Модальное окно для смены названия ВГСВ -->
<div class="modal fade mt-2" id="change-vgsv-name" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Смена названия</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                    <div class="mt-2">
                        <input style="font-size: 18px;" type="text" name="name" class="form-control" placeholder="Введите ФИО командира">
                        <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                    </div>
                    <hr>
                    <div class="d-grid">
                        <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить название</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно для смены радиопозывного ВГСВ -->
<div class="modal fade mt-2" id="change-vgsv-radio-call" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Смена радиопозывного</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                    <div class="mt-2">
                        <input style="font-size: 18px;" type="text" name="radio_call" class="form-control" placeholder="Введите новый радиопозывной">
                        <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                    </div>
                    <hr>
                    <div class="d-grid">
                        <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить радиопозывной</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно для смены отношения ВГСВ к ВГСО -->
<div class="modal fade mt-2" id="change-vgsv-vgso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Смена отношения к ВГСО</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                    <div class="mt-2">
                        <?php echo \Modules\Helpers\getRenderedSelect('vgso', [], $vgsosSelectOptions) ?>
                        <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                    </div>
                    <hr>
                    <div class="d-grid">
                        <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить отношение к ВГСО</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php
}
?>

<?php

if($__userStatus == 'vgsv') {
    ?>

    <!-- Модальное окно для смены основного номера ВГСВ -->
    <div class="modal fade mt-2" id="change-vgsv-telephone-number" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Смена основного номера телефора</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                        <div class="mt-2">
                            <input style="font-size: 18px;" type="text" name="telephone_number" class="form-control" placeholder="Введите новый номер">
                            <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить номер телефона</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Модальное окно для смены ФИО командира ВГСВ -->
    <div class="modal fade mt-2" id="change-vgsv-senior-commander-name" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Смена ФИО командира</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                        <div class="mt-2">
                            <input style="font-size: 18px;" type="text" name="senior_commander_name" class="form-control" placeholder="Введите ФИО нового командира">
                            <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить ФИО командира</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Модальное окно для смены номера телефона командира ВГСВ -->
    <div class="modal fade mt-2" id="change-vgsv-senior-commander-telephone-number" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Смена номера телефона командира</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                        <div class="mt-2">
                            <input style="font-size: 18px;" type="text" name="senior_commander_telephone_number" class="form-control" placeholder="Введите новый номер командира">
                            <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить номер телефона командира</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Модальное окно для смены названия АПО -->
    <div class="modal fade mt-2" id="change-vgsv-apo-vehicle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Смена информации об АПО</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/updateinfo" class="overflow-x-auto">
                        <div class="mt-2">
                            <input style="font-size: 18px;" type="text" name="apo_vehicle" class="form-control" placeholder="Введите информацию об АПО">
                            <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">
                        </div>
                        <hr>
                        <div class="d-grid">
                            <button type="submit" data-bs-dismiss="modal" style="font-size: 18px;" class="btn btn-primary mb-3">Изменить информацию об АПО</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
}

?>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>