<?php

require Modules\Helpers\getFragmentPath('__header');

?>

<?php

$getParamsForHrefs = \Modules\Helpers\getGetParams([], ['accident_item' => 'all_accidents']);

?>

<div class="container" style="border-radius: 7px;">

    <div class="return-button mt-3"> 
        <a href="/CALL_VGSO" type="button" class="btn btn-outline-primary">Вернуться на главную</a>
    </div>

    <div class="accidents-table bg-warning-subtle overflow-x-auto mt-4 p-5" style="border-radius: 7px;">
        <div class="card">
            <div class="card-header" style="font-size: 30px;">
                Cписок аварий
            </div>
            <div class="card-body overflow-x-auto">
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">Дата и время</span></th>
                    <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">Шахта</span></th>
                    <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">Вид аварии</span></th>
                    <th scope="col" style="text-align: center;"><span class="th-with-condition-620-rotate">Статус</span></th>
                    <th scope="col" style="text-align: center;"></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                <?php
                
                foreach ($accidents as $accident) {
                    ?>

                    <tr>
                        <td class="pe-5 pt-3" style="font-size: 15px; word-wrap: break-word;"><?php echo $accident['accident_timestamp'] ?></td>
                        <td class="pe-5 pt-3" style="font-size: 15px; word-wrap: break-word;"><?php echo $accident['mine_name'] ?></td>
                        <td class="pe-5 pt-3" style="font-size: 15px; word-wrap: break-word;"><?php echo $accident['accident_name'] ?></td>
                        <?php
                        
                        if($accident['is_liquidated'] == 1) {
                            ?>
                            <td class="pe-5 pt-3" style="font-size: 17px; word-wrap: break-word;">Ликвидирована</td>
                            <?php
                        } else {
                            ?>
                            <td class="pe-5 pt-3" style="font-size: 17px; color: red; word-wrap: break-word;">Не ликвидирована</td>
                            <?php
                        }
                        
                        ?>
                        <td class="pe-5 pt-3" style="font-size: 15px; word-wrap: break-word;"><a href="/CALL_VGSO/accident/<?php echo $accident['id'], $getParamsForHrefs ?>">Подробнее</a></td>
                    </tr>

                    <?php
                }
                
                ?>
                
            </tbody>
        </table>
            </div>
        </div>
    </div>
</div>


<?php

require Modules\Helpers\getFragmentPath('__footer');

?>