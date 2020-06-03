<?php session_start(); 

    

    session_unset();
    session_destroy();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulaire</tilte>
</head>
<body>

    <h1>Bienvenue sur votre profil</h1>

    <h2>login</h2>
    <form method="post">
        <input type="text" name="lemail" id="lemail" placeholder="Votre email" required><br/>
        <input type="text" name="lpseudo" id="lpseudo" placeholder="Votre pseudo" required><br/>
        <input type="text" name="lpassword" id="lpassword" placeholder="Votre mot de passe" required><br/>
        <input type="submit" name="formsend" id="formsend">
    </form>

    <?php
        if(isset($_POST['formlogin']))
        {
            extract($_POST);

            if(!empty($lemail) && !empty($lpassword))
            {
                $q = $db->prepare("SELECT * FROM users WHERE email = :email");
                $q->execute(['email' => $lemail]);
                $result = $q->fetch();

                if($result == true)
                {
                   $hpassword = $result['password'];
                   if(password_verify($lpassword, $result['password']))
                   {
                       echo "mot de passe correcte";
                       $_SESSION['email'] = $result['email'];
                       $_SESSION['password'] = $result['password'];


                   }
                   else
                   {
                       echo "le mot de passe est incorrecte";
                   }
                }
                else
                {
                    echo " Le compte ayant pour email" .$email."n'existe pas";                }
                }


            else
            {
                echo " Veuillez completer le champ indiqué.";
            }
        }
    

    ?>


    <h2>signin</h2>
    <form method="post">
        <input type="text" name="nom" id="nom" placeholder="Votre nom" required><br/>
        <input type="text" name="age" id="age" placeholder="Votre age" required><br/>
        <input type="text" name="email" id="email" placeholder="Votre email" required><br/>
        <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" required><br/>
        <input type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" required><br/>
        <input type="text" name="password" id="password" placeholder="Votre mot de passe" required><br/>
        <input type="text" name="cpassword" id="cpassword" placeholder="Confirmez votre mot de passe" required><br/>
        <input type="submit" name="formsend" id="formsend">
    </form>

    <?php

        if(isset($_POST['formsend'])){
            extract($_POST);
            if(!empty($nom)  && !empty($password) && !empty($cpassword) && !empty($pseudo) && !empty($prenom) && !empty($age) && !empty($email)){

                include 'motdepasse.php';
                include 'database.php';

                
        global $db;
        $q = $db->query("SELECT *   FROM users ORDER BY id ASC ");
        while ($user = $q->fetch()) {
            echo "pseudo : " . $user['pseudo'] . "<br/>";
        global $db;
        $c = $db->prepare("SELECT email FROM users WHERE email = :email");
        $c->execute(['email' => $email]);
        $result = $c->rowCount();
        
        echo $result;

        if($result == 0){
            $v = $db->prepare("INSERT INTO users(pseudo,age,email,nom,prenom,password) VALUES(:pseudo,:age,:email,:nom,:prenom,:password)");
            $v->execute([
            //'pseudo' => 'ijudéaux',
            //'nom' => 'judéaux',
            //'prenom' => 'idryss',
            //'age' => '18',
            //'password' => 'root'
                'email' => $email,
                'password' => $hashpass
        
            ]);
            echo "le compte est crée";
        }else{
            echo "l'email existe deja";

        }
        
        echo "Votre Nom : ".$_POST['nom'] . "<br/>";
        echo "Votre Prénom :".$_POST['prenom'] . "<br/>";
        echo "Votre Age : ".$_POST['age'] . "<br/>";
        echo "Votre Email : ".$_POST['email'] . "<br/>";
        echo "Votre Pseudo : ".$_POST['pseudo'] . "<br/>";

                
            }
        }

    ?>


</body>
</html>
