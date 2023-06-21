<?php

namespace Modules\Controller;
class ChangeController extends BaseController
{
    public function item($params) 
    {
        $this->checkUser();

        $vgsvs = new \Modules\Model\MainVgsv;
        $changes = new \Modules\Model\Vgsv;

        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'id', 'id, telephone_number', NULL);

        if($this->userStatus == 'vgsv' && $vgsv['id'] != $this->currentUser['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $change = $changes->getOr404($params['changeId'], 'vgsvs.id', '*');

        $context = 
        [
            'siteTitle' => 'Страница смены',
            'change' => $change,
            'vgsv' => $vgsv,
        ];

        $this->render('change_item', $context);

    }

    public function getAll($params) 
    {
        $this->checkUser();

        $vgsvs = new \Modules\Model\MainVgsv;
        $changes = new \Modules\Model\Vgsv;

        $vgsv = $vgsvs->getOr404($params['vgsvId'], 'id', 'id, name');

        if($this->userStatus == 'vgsv' && $vgsv['id'] != $this->currentUser['id']) {
            throw new \Modules\Exception\Page403Exception;
        }

        $changes->select('*', NULL, 'vgsv = ?', [$vgsv['id']]);

        $context = 
        [
            'siteTitle' => 'Страница смены',
            'changes' => $changes,
            'vgsv' => $vgsv,
        ];

        $this->render('all_changes', $context);
    }
}

?>