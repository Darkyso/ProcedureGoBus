<?php
function search(){
    $tab = 'Aucun resultat';
    if(isset($_POST['day']) && isset($_POST['hour'])){          //aller dedans si on à des valeurs dans les champs du formulaire
        $week=array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');
        $day = $_POST['day'];                                    //instanciation des variables
        $hour = $_POST['hour'];
        $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v1', 'root', 'pwsio');   //connexion db
        $sql = $conn->prepare("CALL view_start_city_per_time_and_day(:day, :hour)");    //appeler la db pour préparé l'appel à une procédure
        $sql->bindParam(":day",$day);       //transforme l'objet $day en :day
        $sql->bindParam(":hour",$hour);
        $sql->execute();                    //executer la procédure
        $tab = $sql->fetchAll();        //instanciation du tableau se référent à l'exécution de la procédure en lisant toute les lignes
        foreach($tab as $row){         //pour chaque ligne du tableau
            $tab = '<tr><td>'.$row[0].'</td><td>'.$week[$row[1]].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td></tr>';     //afficher ces valeurs dans le tableau
        }
    }
    return $tab;           
} 
             
function nbRoutePerDay(){
    if(isset($_POST['day'])){
        $day = $_POST['day'];
        $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v3', 'root', 'pwsio');
        $sql = $conn->prepare('CALL nb_route_per_day('.$day.')');//INSERT INTO REGISTRY (name, value) VALUES (?, ?)
        $sql->execute();
        $result = $sql->fetchAll();
        foreach($result as $r){
            return 'Il y a ' .$r[0]. ' au jour ' .$day;
        }
    }
}

function listeCity(){
    $connect = mysql_connect ('localhost', 'root', 'pwsio');
    mysql_select_db ('GoBus_v4', $connect) ;
    $result = mysql_query("SELECT id,name FROM city ORDER BY name");
    while($row = mysql_fetch_row($result)){
        echo '<option value="'.$row['1'].'">'.$row['1'].'</option>';
    } 
}

function insertLine(){
    if(isset($_POST['distance']) && isset($_POST['frequence']) && isset($_POST['price']) && isset($_POST['time']) && isset($_POST['listeCity1']) && isset($_POST['listeCity1'])){
        $distance = $_POST['distance'];
        $frequence = $_POST['frequence'];
        $price = $_POST['price'];
        $time = $_POST['time'];
        $start_point_id = $_POST['listeCity1'];
        $end_point_id = $_POST['listeCity2'];
        $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v3', 'root', 'pwsio');
        $sql = $conn->prepare('CALL insert_into_line('.$distance.','.$frequence.','.$price.',"'.$time.'","'.$start_point_id.'","'.$end_point_id.'")');      
        $exec = $sql->execute();
        if($exec == true){
            return 'La ligne a ete ajoutee';
        }else{
            return 'Une erreur est survenue';
        }
    }
}

function nbRoutePerHourPerDay(){
    if(isset($_POST['start_time']) && isset($_POST['date'])){
        $start_time = $_POST['start_time'];
        $date = $_POST['date'];
        $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v3', 'root', 'pwsio');
        $sql = $conn->prepare('CALL nb_route_per_hour_per_day ("'.$start_time.'","'.$date.'")');      
        $sql->execute();
        $result = $sql->fetchAll();
        foreach($result as $r){
            return 'Il y a ' .$r[0]. ' trajet(s) a la date du ' .$date. ' a l\'heure '.$start_time;
        }
    }
}

function avgRoutePerDay(){               
    if(isset($_POST['day'])){
        $day = $_POST['day'];
        $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v3', 'root', 'pwsio');
        $sql = $conn->prepare('CALL avg_route_such_day ('.$day.')');      
        $sql->execute();
        $result = $sql->fetchAll();
         var_dump($sql);
        foreach($result as $r){
            return 'Il y a ' .$r[0]. ' trajet(s) a la date du ' .$day;
        }
    }
}

function avgRouteLineDatePerDate(){
    
} 