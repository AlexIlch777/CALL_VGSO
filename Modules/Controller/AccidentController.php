<?php

namespace Modules\Controller;
class AccidentController extends BaseController
{
    public function item($params) 
    {
        $this->checkAdmin();

        $accidentsList = new \Modules\Model\AccidentsList;

        $vgsvsInAccidents = new \Modules\Model\VgsvsInAccident;

        $accident = $accidentsList->getOr404($params['accidentId'], 'accidents_list.id', 'accidents_list.id, mines.name AS mine_name, accidents.name AS accident_name, sender, vgsos.name AS vgso_name, main_vgsv.name AS vgsv_name, accident_timestamp, send_timestamp, is_liquidated, status', ['mines', 'accidents', 'vgsos', 'main_vgsv']);

        if($accident['status'] == 1) {
            $vgsvsInAccidents->select('vgsvs_in_accidents.id, main_vgsv.name', ['main_vgsv'], 'accident = ?', [$accident['id']]);
        } else {
            $vgsvsInAccidents = NULL;
        }

        $context = 
        [
            'accident' => $accident,
            'siteTitle' => 'Информация об аварии',
            'vgsvsInAccident' => $vgsvsInAccidents,
        ];

        $this->render('accident_item', $context);
    }
}

?>