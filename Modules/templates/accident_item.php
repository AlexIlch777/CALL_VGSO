<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<div class="container mt-3">
    <?php

    if(isset($_GET['accident_item'])) {
        $pageFromQuery = $_GET['accident_item'];
        
        if($pageFromQuery == 'all_accidents') {
        ?>

            <div class="return-button">
                <a href="/CALL_VGSO/accidentslist" type="button" class="btn btn-outline-primary">Вернуться на список аварий</a>
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
    <div class="card mt-4 mb-5">
        <div class="card-header" style="font-size: 30px">
            Основная информация об аварии
        </div>
        <div class="card-body">
            <div class="card-title" style="font-weight: bold; font-size: 17px">
                Кто сообщил:
            </div>
            <div class="card-text">
                <?php echo $accident['sender'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                Шахта:
            </div>
            <div class="card-text">
                <?php echo $accident['mine_name'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                Вид аварии:
            </div>
            <div class="card-text">
                <?php echo $accident['accident_name'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                ВГСО:
            </div>
            <div class="card-text">
                <?php echo $accident['vgso_name'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                Какой вгсв оповестил систему об аварии:
            </div>
            <div class="card-text">
                <?php echo $accident['vgsv_name'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                Дата и время аварии:
            </div>
            <div class="card-text">
                <?php echo $accident['accident_timestamp'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                Дата и время оповещения об аварии:
            </div>
            <div class="card-text">
                <?php echo $accident['send_timestamp'] ?>
            </div>

            <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                Статус аварии:
            </div>
            <?php   
                if($accident['is_liquidated'] == 1) {
                    echo '<div class="card-text">Ликвидирована</div>';
                } else {
                    echo '<div class="card-text" style="color: red;">Не ликвидирована</div>';
                }
            ?>

            <?php
            if($accident['status'] == 1) {
                ?>
                <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                    ВГСВ, принимавшие участие в ликвидации:
                </div>
                <div class="card-text">
                    <ul>
                        <?php
                            foreach ($vgsvsInAccident as $vgsvInAccident) {
                                ?>
                                    <li><?php echo $vgsvInAccident['name'] ?></li>
                                <?php
                            }
                        ?>
                    </ul>
                </div>
                <?php
                } else {
                    ?>
                    <div class="card-title mt-4" style="font-weight: bold; font-size: 17px">
                        Авария была <?php echo $accident['status'] ?> за день, поэтому показать чёткий список взводов-ликвидаторов невозможно
                    </div>
                    <?php
                }
                ?>
        </div>
    </div>
</div>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>