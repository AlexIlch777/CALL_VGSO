<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<?php

$getParamsForHrefs = \Modules\Helpers\getGetParams(['all_changes'], ['change_item' => 'all_changes']);

?>

    <div class="container mt-4">

    <?php
    
    if(isset($_GET['all_changes'])) {
        $pageFromQuery = $_GET['all_changes'];

        if ($pageFromQuery == 'vgsv_item') {
            ?>
    
            <div class="return-button">
                <a href="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>" type="button" class="btn btn-outline-primary">Вернуться на странцу ВГСВ</a>
            </div>
    
            <?php
        }
    }
    
    ?>

        <div class="changes-table mt-5">
            <h2>Список смен ВГСВ</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Дата заступления</th>
                        <th scope="col">Дата окончания</th>
                        <th scope="col">Командир дежурного отделения</th>
                        <th scope="col">Командир резервного отделения</th>
                        <th scope="col"></th>
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
                
                            <td><?php echo $change['reserve_department_commander_name'] ?></td>
                
                            <td><a href="/CALL_VGSO/vgsv/<?php echo $vgsv['id'] ?>/change/<?php echo $change['id'], $getParamsForHrefs ?>">Подробнее</a></td>
                        </tr>
                    <?php
                    }
        
                    ?>
        
                </tbody>
            </table>
        </div>
    
    </div>

<?php

require Modules\Helpers\getFragmentPath('__footer');

?>