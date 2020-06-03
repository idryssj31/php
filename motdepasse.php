<?php

    if($password == $cpassword){
        $options = [
            'cost' => 12,
        
        ];

        $hashpass = password_hash($password, PASSWORD_BCRYPT, $options);
        
    }


?>