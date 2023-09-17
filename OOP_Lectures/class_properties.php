<?php 

class Cars {

    var $wheel_count = 4;
    var $door_count = 4;

    function car_detail(){
        return "This car has " . $this->wheel_count . " wheels";
    }


}

$bwm = new Cars();
$audi = new Cars();

echo $bwm->wheel_count = 10 . "<br>";
echo $audi->wheel_count . "<br>";
echo $audi->car_detail();


?>