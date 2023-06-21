    <?php
        if(isset($script)) {
        ?>
            <script src="<?php echo \Modules\Settings\SCRIPTS_PATH ?><?php echo $script.'.js' ?>"></script>
        <?php
        }
    ?>
    
    <?php
    
    if($__currentUser != NULL) {
        ?>
            <script src="<?php echo \Modules\Settings\SCRIPTS_PATH ?>main.js"></script>
        <?php
    }
    
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</body>
</html>