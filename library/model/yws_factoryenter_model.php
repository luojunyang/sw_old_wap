<?php

/**
 * 新零售申请模型
 */
class yws_factoryenter_model extends base_model
{

    public function add($data)
    {
        return $this->db->data($data)->add();
    }

}