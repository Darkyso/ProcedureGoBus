<?php
function listeLigne(){          //liste deroulante de la page planning
    $base = mysql_connect ('localhost', 'root', 'pwsio');
    mysql_select_db ('GoBus_v4', $base) ;
    $result = mysql_query("SELECT id FROM line ORDER BY id");
    while($row = mysql_fetch_row($result)){
        echo '<option value="'.$row['0'].'">'.$row['0'].'</option>';
    }
}

function calculEnd_time(){      //calcul entre l'heure de départ de le temps
    $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v4', 'root', 'pwsio');
        $sql = $conn->prepare('CALL view_week_line('.$_POST['listeLine'].')');
        $sql->execute();
        $resultat=$sql->fetchAll();
        foreach($resultat as $ligne){
            $h1= $ligne['start_time'];
            $h2= $ligne['time'];
        }
    echo $h1+$h2;
}

function afficherPlanning(){        //afficher le tableau du planning
    $html=' ';
    if(isset ($_POST['listeLine'])){
        $week=array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');
        $html='<table class="table table-bordered"><tr><th>Jour</th><th>Heure début</th><th>Heure fin</th></tr>';
        $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v4', 'root', 'pwsio');
        $sql = $conn->prepare('CALL view_week_line('.$_POST['listeLine'].')');
        $sql->execute();
        $resultat=$sql->fetchAll();
        foreach($resultat as $ligne){
            $html.='<tr>';
            $html.='<td>'.$week[$ligne['day']].'</td>';
            $html.= '<td>'.$ligne['start_time'].'</td>';
            $html.= '<td>'.$ligne['time'].'</td>';
            $html.='</tr>';
        }
        $html.='</table>';
    }
    return $html;
}

/*function clean(){   
     $conn = new PDO('mysql:host=127.0.0.1;dbname=GoBus_v4', 'root', 'pwsio');
     
}*/

