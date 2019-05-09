<?php
    function pruebasPhp(){
        $date = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s").".000000";
        
        return json_encode(["hola"=> $date]);
    }
?>