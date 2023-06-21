<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    global $requestPath;
        if(isset($style)) {
            ?>
                <link rel="stylesheet" href="<?php echo \Modules\Settings\STYLES_PATH ?><?php echo $style; ?>.css">
            <?php
        } 
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo \Modules\Settings\STYLES_PATH ?>main.css">

    <title><?php
    if(isset($siteTitle)) {
        echo $siteTitle;
    } else {
        echo 'ВЫЗОВ ВГСЧ ЛНР';
    }
    ?></title>

    <link rel="shortcut icon" href="src\<?php echo \Modules\Settings\IMAGES_FILE_PATH ?>vgso_icon.png" type="image/x-icon">
    
</head>
<body>
    <?php
    if(!is_null($__currentUser)) {
        ?>
            <div id="modal-block" class="">
                <!-- Тут будет выводиться модальные окна -->
            </div>  

            <!-- Modal for vgsv -->
            <div class="modal fade" id="vgsvAccidentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body overflow-x-auto">

                            <div style="text-align: center; font-size: 30px;">
                                Авария!!! Требуется незамедлительная реакция
                            </div>

                            <div class="lamp"></div>

                            <div id="vgsv-instruction" class="card mt-3">
                                <div class="card-header" style="font-size: 20px">
                                    Инструкция по аварии
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <ol>
                                            <?php
                                            
                                            if($requestPath != '') {
                                                ?>
                                                    <li class="mt-3">Вернуться на главную страницу для ознакомления с информацией об аварии</li>
                                                <?php
                                            }
                                            
                                            ?>
                                            <li class="mt-3">Подтвердить получение сообщения</li>

                                            <li class="mt-3">Ознакомиться с информацией об аварии</li>

                                            <li class="mt-3">
                                                Подготовить необходимые службы к выезду
                                                <ul>
                                                    <li class="mt-2">Если все необходимые силы и средства заступили на смену, всё отлично - выезжаем!!!</li>

                                                    <li class="mt-2">Если каких-то сил и средств нет, незамедлительно информируем админа для согласования дальнейших действий!!!</li>
                                                </ul>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header" style="font-size: 25px; text-align: center;">
                                    Успешной ликвидации!!!
                                </div>
                            </div>

                            <hr>

                            <div class="d-grid mt-3">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="font-size: 18px">Приступить к дальнейшим действиям</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for vgsv success_alert -->
            <div class="modal fade" id="vgsvSuccessAlertModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body overflow-x-auto">

                            <div style="text-align: center; font-size: 30px;">
                                Авария ликвидирована!!! Поздравляем!!!
                            </div>

                            <div class="modal-body">
                                <div class="green-lamp"></div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header" style="font-size: 25px; text-align: center;">
                                    Отпразднуйте как следует
                                </div>
                            </div>

                            <hr>

                            <form action="/CALL_VGSO/vgsv/<?php echo $__currentUser['id'] ?>/successalert" method="post">

                                <input type="hidden" name="__token" value="<?php echo \Modules\Helpers\generateToken() ?>">

                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" style="font-size: 18px">Подтвердить получение сообщения</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for admin -->
            <div class="modal fade" id="adminAccidentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body overflow-x-auto">

                            <div style="text-align: center; font-size: 30px;">
                                Авария!!! Требуется незамедлительная реакция
                            </div>

                            <div class="lamp"></div>

                            <div id="accident-instruction" class="card mt-4">
                                
                                <div class="card-header" style="font-size: 20px;">
                                    Инструкция по аварии
                                </div>
                                
                                <div class="card-body">
                                    <div class="card-text">
                                        <ol>
                                            
                                            <?php
                                            
                                            if($requestPath != '') {
                                                ?>
                                                    <li class="mt-3">Вернитесь на главную страницу для ознакомления с информацией об аварии</li>
                                                <?php
                                            }
                                            
                                            ?>

                                            <li class="mt-3">Подтвердите получение сообщения внизу информации об аварии</li>

                                            <li class="mt-3">Ознакомьтесь со всеми деталями аварии</li>

                                            <li class="mt-3">
                                                Просмотрите данные о диспозиции
                                                <ul>
                                                    <li class="mt-2">
                                                        Если авария первая в списке
                                                        <ul>
                                                            <li>
                                                                Если все взводы и их силы и средства готовы к выезду - приступайте к ликвидации
                                                            </li>
                                                            <li>
                                                                Если некоторые взводы не в сети - свяжитесь с ними в ручном режиме
                                                            </li>
                                                            <li>
                                                                Если отдельных сил и средств каких-то взводов нет в смене - свяжитесь в ручном режиме
                                                            </li>
                                                        </ul>
                                                    </li>
        
                                                    <li class="mt-2">
                                                        Если авария любая, но не первая
                                                        <ol>
                                                            <li>Оцените возможные силы в соотношении с диспозицией</li>
                                                            <li>Cвяжитесь со всеми взводами из диспозиции вручную</li>
                                                        </ol>
                                                    </li>

                                                </ul>
                                            </li>

                                        </ol>
                                    </div>

                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header" style="font-size: 25px; text-align: center;">
                                    Успешной ликвидации!!!
                                </div>
                            </div>

                            <hr>

                            <div class="d-grid mt-4">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="font-size: 18px">Приступить к дальнейшим действиям</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    <div class="header" style="background-color: #e3f2fd; padding-top: 10px; padding-bottom: 10px">
    <div class="container">
        <div class="row navbar">
                    <?php if (isset($__userStatus) && $__userStatus == 'vgsv' && isset($__currentUser['name']) && isset($__currentUser['id'])) {
                    ?>
                    <div class="nav-item dropdown-center userAbilitysButtonBlock col-lg-6 col-md-6 col-sm-6 col-6">
                        <button class="btn btn-primary dropdown-toggle" style="font-size: 18px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $__currentUser['name'] ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/CALL_VGSO/vgsv/<?php echo $__currentUser['id'] ?>/changepassword">Сменить пароль ВГСВ</a></li>
                            <li><a class="dropdown-item" href="/CALL_VGSO/logout">Выйти из аккаунта</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/CALL_VGSO/vgsv/<?php echo $__currentUser['id'] ?>">Перейти на страницу ВГСВ</a></li>
                        </ul>
                    </div>
                    <?php
                } else if (isset($__userStatus) && $__userStatus == 'admin') {
                    ?>
                    <div class="nav-item dropdown-center userAbilitysButtonBlock col-lg-6 col-md-6 col-sm-6 col-6">
                        <button class="btn btn-primary dropdown-toggle" type="button" style="font-size: 18px;" data-bs-toggle="dropdown" aria-expanded="false">
                            Меню админа
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/CALL_VGSO/admin/<?php echo $__currentUser['id'] ?>/changepassword">Сменить пароль</a></li>
                            <li><a class="dropdown-item" href="/CALL_VGSO/logout">Выйти из аккаунта</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/CALL_VGSO/accidentslist">Cписок аварий</a></li>
                        </ul>
                    </div>
                    <?php
                } else {
                    ?>
                        <div class="nav-item dropdown-center userAbilitysButtonBlock col-lg-6 col-md-6 col-sm-6 col-6"></div>
                    <?php
                }
                    ?>
                
                <div class="col-lg-5 project-name text-end" style="text-align: right;">
                    <a href="/CALL_VGSO" style="font-size: 33px; text-decoration: none;">Вызов ВГСЧ ЛНР</a>
                </div>
                <div class="col-lg-1 col-md-6 col-6 col-sm-6" style="text-align: right;">
                    <a href="/CALL_VGSO">
                    
                    <img src="src/<?php echo \Modules\Settings\IMAGES_FILE_PATH ?>main_vgso_logo.svg" alt="">

                    </a>
                </div>
        </div>
    </div>
    </div>

    <?php 
    }
    ?>