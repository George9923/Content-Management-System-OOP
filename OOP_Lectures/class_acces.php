<?php 

class Cars {

    public $wheel_count = 4;
    private $door_count = 4;
    protected $seat_count = 2;

    function car_detail(){
        echo $this->wheel_count;
        echo $this->door_count;
        echo $this->seat_count;

    }


}

$bwm = new Cars();
// echo $bwm->wheel_count;
// echo $bwm->door_count;
// echo $bwm->seat_count;

$bwm->car_detail();
?>