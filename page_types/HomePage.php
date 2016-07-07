<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomePage
 *
 * @author rostom
 */
class HomePage {

    private $_mysqli;
    private $_db;
    public $categories;
    public $frontenddata;
    public $random_data;

    public function __construct() {
        $this->_db = DB_Connect::getInstance();
        $this->_mysqli = $this->_db->getConnection();
        $this->frontenddata = new FrontEndLogic();
    }

    public function MainHomePage($data) {
        ?>
        <div class="container rock-main-container">


            <!--Carousel-->
            <?php
            echo $data['page_content'];
            ?>
            <div class="row">
                <div class="col-md-12">
                    <hr/>
                    <h1><?= CUSTOMER ?></h1>
                </div>
                <div class="col-md-12 rock-items-col-12">
                    <?php
                    $this->GetCategories("9");

                    foreach ($this->categories as $category) {
                        $page_parent_no_spaces = str_replace(" ", "-", $category['parent_page_name']);
                        $no_upper_case = strtolower($page_parent_no_spaces);
                        $no_ands = str_replace("&", "and", $no_upper_case);
                        $clean_parent_name = preg_replace('/[^a-zA-Z0-9,-]/', "-", $no_ands);

                        $page_name_no_spaces = str_replace(" ", "-", $category['page_name']);
                        $page_no_upper_case = strtolower($page_name_no_spaces);
                        $page_no_ands = str_replace("&", "and", $page_no_upper_case);
                        $clean_page_name = preg_replace('/[^a-zA-Z0-9,-]/', "-", $page_no_ands);

                        if ($this->frontenddata->GetPageAlias($category['page_id'])) {
                            foreach ($this->frontenddata->page_alias as $page_alias) {
                                $url = "/" . $page_alias['page_alias'];
                            }
                        } else {

                            $url = "/" . $clean_parent_name . "/" . $clean_page_name . "/" . $category['id'];
                        }
                        $this->frontenddata->page_alias = NULL;
                        if ($this->frontenddata->GetPageAlias($category['parent_page_id'])) {
                            foreach ($this->frontenddata->page_alias as $parent_page_alias) {
                                $parent_url = "/" . $parent_page_alias['page_alias'];
                    }
                        } else {
                            $parent_url = "/" . $clean_parent_name . "/" . $category['parent_page_uid'];
                        }


                        foreach ($category[1] as $products) {
                    ?>
                    <div class="col-md-4 rock-item-image-holder"> 

                        <div class="row">
                            <?php
                                    $item_no_spaces = str_replace(" ", "-", $products['item_name']);
                                    $item_no_upper_case = strtolower($item_no_spaces);
                                    $item_no_ands = str_replace("&", "and", $item_no_upper_case);
                                    $clean_item_name = preg_replace('/[^a-zA-Z0-9,-]/', "-", $item_no_ands);
                                    
                                    $item_url = "/" . $clean_parent_name . "/" . $clean_page_name . "/".trim($clean_item_name)."/".$products['page_id'];
                            ?>

                                    <a href="<?= $parent_url ?>" class="rock-brand-in-box"><?= $category['parent_page_name'] ?></a>
                                    <a  href="<?= $item_url ?> "  class="rock-product-link">
                                <span class="rollover" >                                                                            
                                </span>
                            </a>
                                    <?php
                                    ?>
                                    <img src="<?= $products['image_0'] ?>" class="rock-item-image">


                        </div>

                        <div class="row rock-item-captions">

                                    <p class="rock-item-name"><a href="<?= $url ?>" > <?= $category['page_name'] ?></a><p> 
                                    <p class="rock-item-name"><?= $products['item_name'] ?></p>  

                        </div>
                    </div>
                            <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>

        <?php
    }

    public function GetCategories($page_type) {

        $sql = "SELECT `id`,`page_name`, `page_type`, `page_id` FROM `pages` WHERE `page_type` ='" . $page_type . "'";
        $result = $this->_mysqli->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $this->frontenddata->page_data = NULL;
                $this->frontenddata->GetpageDataByID($row['id'], "homepage");
                $this->categories[] = $this->frontenddata->ReturnPageData();
            }
            return $this->categories;
        } else {
            return FALSE;
        }
    }

            
        
    

    public function GetRamdomDataForHomePage($limit) {

        $home_page = array();

        $sql = "SELECT DISTINCT `page_name`, `page_type`, `page_parent`, `page_id` FROM `pages` WHERE `page_type` ='10'  ORDER BY RAND() LIMIT {$limit}";

        $result = $this->_mysqli->query($sql);
        $num_rows = $result->num_rows;
        if ($num_rows > 0) {

            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {


                $rand_data = array();
                //$rand_data['id'] = $row['id'];
                $rand_data['page_name'] = trim($row['page_name']);
                $rand_data['page_type'] = $row['page_type'];
                $rand_data['page_parent'] = $row['page_parent'];
                $rand_data['page_id'] = $row['page_id'];
                $rand_data['parent_info'] = array();


                $get_parent_info = "SELECT `id`, `page_name`, `page_type`, `page_id`, `page_parent` FROM `pages` WHERE `id` = '" . $row['page_parent'] . "'";
                $get_parent_info_rest = $this->_mysqli->query($get_parent_info);

                while ($page_parent_info = $get_parent_info_rest->fetch_array(MYSQLI_ASSOC)) {
                    $p_data = array();
                    $p_data['parent_page_name'] = $page_parent_info['page_name'];
                    $p_data['parent_page_parnet'] = $page_parent_info['page_parent'];
                    $p_data['parent_page_type'] = $page_parent_info['page_type'];
                    $p_data['parent_page_id'] = $page_parent_info['page_id'];
                    $p_data['parent_page_uid'] = $page_parent_info['id'];
                    $p_data['item_info'] = array();


                    $get_products_info = "SELECT * FROM `pages_products` WHERE `page_id` ='" . $row['page_id'] . "'";
                    $get_products_info_res = $this->_mysqli->query($get_products_info);
                    while ($items = $get_products_info_res->fetch_array(MYSQLI_ASSOC)) {
                        $items_array = array();
                        $items_array['item_name'] = $items['item_name'];
                        $items_array['image_0'] = $items['image_0'];
                        $items_array['image_1'] = $items['image_1'];
                        $items_array['image_2'] = $items['image_2'];
                        $items_array['image_3'] = $items['image_3'];
                        $items_array['image_4'] = $items['image_4'];
                        $items_array['image_5'] = $items['image_5'];
                        $items_array['image_6'] = $items['image_6'];
                        $items_array['image_7'] = $items['image_7'];
                        $items_array['image_8'] = $items['image_8'];
                        $items_array['brand'] = $items['brand'];
                        $items_array['category'] = $items['category'];
                        $items_array['page_id'] = $items['page_id'];

                        array_push($p_data['item_info'], $items_array);
                    }
                    array_push($rand_data['parent_info'], $p_data);
                }
                array_push($home_page, $rand_data);
            }
        }

        $this->random_data[] = $home_page;
        return $this->random_data;
    }

}
