<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>WTC - WorkstationToolCheck</title>
        <link href="Styles\tisch.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="favicon.png">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">

        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/130527/qrcode.js"></script>  
    </head>
    <body>

    <?php 
        require_once("ver.php")
    ?>

    <div id="ver" class="ver"><?=$ver?></div>

    <?php
        require_once("dbCon.php");
        $tischId = $_GET['tischId'];
        $tischNummer = $_GET['tischNummer'];
    ?>
        <div id="titel">
            <a href="index.php"><h1>WTC - WorkstationToolCheck</h1></a>  
        </div>

        <div id="tisch_id">
            <h1>TISCH - <?=$tischNummer?></h1>    
        </div>     
            
        <div id="log_title">
            <h1>Scan-Protokoll</h1>
        </div>

        <div id="output1">
            <div id="tablediv">
                <table id="tables">
                    <tr>
                        <th>Datum/Uhrzeit</th>
                        <th>Name</th>
                        <th>Ergebniss</th>
                        <th>Kommentar</th>
                        <th>Einträge löschen?</th>
                    </tr>
                <?php

                $stmt = $pdo->prepare("SELECT * FROM tblscan where scanTischId = ? ORDER BY scanTime DESC limit 20");
                $stmt->execute([$tischId]);
                foreach($stmt->fetchAll() as $row){
                    if ($row['scanErgebniss'] === 1){
                        $ergebniss = "Vollständig";
                        $class = "backgroundGreen";
                    }
                    else {
                        $ergebniss = "Unvollständig";
                        $class = "backgroundRed";
                    }
                    echo "<tr id='".$class."'>";
                    echo "<td>".(date("d.m.Y H.i", strtotime($row['scanTime'])))."</td>";
                    echo "<td>".$row['scanName']."</td>";
                    echo "<td>".$ergebniss."</td>";
                    echo "<td>".$row['scanKommentar']."</td>";
                    echo "<td style='background-color:white;text-decoration:none;'><a id='del_btnT' class='btn_table' href='loeschen.php?id=".$row['scanId']."'>Löschen?</a></td>";
                    echo "</tr>";
                }

                ?>
                
                </table>
            </div>

        </div>
        <div id="output2">
            <div id="tabledivv">

            <h1>Informationen</h1>

                <table id="tables2">
                <tr>
                    <th>Datum/Uhrzeit</th>
                    <th>Name</th>
                    <th>Kommentar</th>
                    <th>Einträge löschen?</th>
                </tr>
                <?php

                $stmt = $pdo->prepare("SELECT * FROM tblkommentar where kommentarTischId = ? ORDER BY kommentarTime limit 20");
                $stmt->execute([$tischId]);

                $ComCol = "backgroundBlue";

                foreach($stmt->fetchAll() as $row){
                    echo "<tr id='".$ComCol."'>";
                    echo "<td>".$row['kommentarTime']."</td>";
                    echo "<td>".$row['kommentarName']."</td>";
                    echo "<td>".$row['kommentarText']."</td>";
                    echo "<td style='background-color:white;text-decoration:none;'><a id='del_btnT' class='btn_table' href='ComLoeschen.php?id=".$row['kommentarId']."'>Löschen?</a></td>";
                    echo "</tr>";
                }

                ?>
                </table>
            </div>

            <div id="delTableBtn">
                <a id="del_btn" class="btn_d" onclick="return confirm('Wollen Sie den Tisch wirklich löschen?');" href="tischLoeschen.php?id=<?php echo $tischId ?>"><span>TISCH LÖSCHEN </span></a>
            </div>

        </div>     
   </body>
</html>