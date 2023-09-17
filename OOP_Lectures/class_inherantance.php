<?php 

class Cars {

    var $wheels = 4;


    function gretting(){
        return "hello";
    }

}

$bwm = new Cars();


class Trucks extends Cars{
}

$tacoma = new Trucks();
echo $tacoma->wheels;
?>