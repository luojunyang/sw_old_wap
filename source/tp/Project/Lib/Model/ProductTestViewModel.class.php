<?php

class ProductTestViewModel extends ViewModel
{
    protected $viewFields = array(
        'Product_test'         => array('*'),
        'ProductCategory' => array('cat_name' => 'category', '_on' => 'Product_test.category_id = ProductCategory.cat_id'),
        'Store'           => array('name' => 'store', '_on' => 'Product_test.store_id = Store.store_id'),
        'User'            => array('nickname' => 'createUName', 'uid' => 'createUid', '_on' => 'Product_test.create_uid = User.uid'),
    );
}