<?php
require("base.php");
class NutritionalValuesController extends BaseController
{
    public function setNutritionalValue($kcal,$fats,$saturated_fats,$carbohydrates,$sugars,$proteins,$fiber,$salt){
        $sql="insert into nutritional_value(kcal,fats,saturated_fats,carbohydrates,sugars,proteins,fiber ,salt)
        values(" . $kcal . "," . $fats . "," . $saturated_fats . "," . $carbohydrates . "," . $sugars . "," . $proteins . "," . $fiber . "," . $salt . ");";
        
        $this->conn->query($sql);
    }

    public function getNutritionalValue($nutritionalValue_id){
        $sql="select * 
        from nutritional_value n
        where n.id=$nutritionalValue_id";
        
        $result = $this->conn->query($sql);
        $this->SendOutput($result, JSON_OK);
    }

}