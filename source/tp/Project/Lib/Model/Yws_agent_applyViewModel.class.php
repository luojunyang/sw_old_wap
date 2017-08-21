<?php

class Yws_agent_applyViewModel extends ViewModel
{
    protected $viewFields = array(
        'Yws_agent_apply'         => array('*'),
        'Store'         => array('approve' => 'approve', '_on' => 'Yws_agent_apply.store_id = Store.store_id')
    );
}
