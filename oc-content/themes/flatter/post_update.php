<?php

require '../../../oc-load.php';
require 'functions.php';

$db_prefix = DB_TABLE_PREFIX;
$user_id = 729;
$item_desc['s_title'] = $_REQUEST['p_title'];
$item_desc['s_description'] = $_REQUEST['p_disc'];

$item_data = new DAO();
$item_data->dao->update("{$db_prefix}t_item_description", $item_desc, array('fk_i_item_id' => $user_id));

$country = Country::newInstance()->findByCode($_REQUEST['countryId']);
$region = Region::newInstance()->findByName($_REQUEST['s_region_name']);
$city = City::newInstance()->findByName($_REQUEST['s_city_name'], $region['pk_i_id']);

$item_location['fk_i_item_id'] = $user_id;
$item_location['fk_c_country_code'] = $country['pk_c_code'];
$item_location['s_country'] = $country['s_name'];
$item_location['s_address'] = $_REQUEST['s_address'];
$item_location['fk_i_region_id'] = $region['pk_i_id'];
$item_location['s_region'] = $region['s_name'];
$item_location['fk_i_city_id'] = $city['pk_i_id'];
$item_location['s_city'] = $city['s_name'];
$item_location['s_city_area'] = $_REQUEST['s_city_area_name'];

$item_data->dao->update("{$db_prefix}t_item_location", $item_location, array('fk_i_item_id' => $user_id));

osc_redirect_to(osc_base_url());
die;
?>