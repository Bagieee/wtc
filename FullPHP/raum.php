<!DOCTYPE html>

<html>
    <head>
    <title>WTC - WorkstationToolCheck</title>
    <link href="Styles/raum.css" rel="stylesheet">

    <!-- UIKIT und BOOTSTRAP EINBINDUNG -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit-icons.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body>
    <div id="titel">
            <a href="index.php"><h1>WTC - WorkstationToolCheck</h1></a>  
        </div>
<?php

    require_once("dbCon.php");
   
    

    $tischRaumId = $_GET['raumid'];
    $counter = 1;
    $stmt = $pdo->prepare("SELECT * FROM tblTisch where tischRaumId = ? ORDER BY tischNummer");
    $stmt->execute([$tischRaumId]);      
    foreach ($stmt->fetchAll() as $row){
        if ($counter === 1){
            echo "<div id='tische'>";
        }
        echo "<a class='tisch_e' href='tisch.php?tischId=".$row['tischId']."&tischNummer=".$row['tischNummer']."'> Tisch -"  .$row['tischNummer'] . "</a>";
        if ($counter === 3){
            echo "</div>";
        }
        $counter += 1;
        if ($counter === 4){
            $counter = 1;
        }

    }
    
?>
</body>
</html>