<?php
function getRandomToken(){
    $token = generateTokenLogin('2', 'marcos', 'conserje');
    return json_encode($token);
}
?>