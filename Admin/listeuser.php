<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listes users crées</title>
    <link rel="stylesheet" href="./accueil.css">
    
</head>

<body>
    <?php
        $file = fopen("../accueil/utilisateurs.csv", "r");
            $en_tete = fgetcsv($file); // Ignorer l'en-tête
            // Recherchez les index des colonnes spécifiques
            $col_Nom = array_search('Nom', $en_tete);
            $col_Prénom = array_search('Prénom', $en_tete);
            $col_Identifiant = array_search('Identifiant', $en_tete);
            $col_role = array_search('role', $en_tete);
            $col_actif = array_search('Actif',$en_tete);
            $col_id_utilisateur = array_search('id_utilisateur',$en_tete);
            $col_Paramètres = array_search('Paramètres',$en_tete);
            ?>
            <table>
            <tr> 
               <th>Nom</th>
               <th>Prénom</th>
               <th>Identifiant</th>
               <th>Role</th>
               <th>Actif</th>
               <th>Paramètres</th>
               
            </tr>
            <?php
            while (($data = fgetcsv($file)) !== FALSE) {
                ?>

        <tr>
            <td><?php echo $data[$col_Nom]?></td>
            <td><?php echo $data[$col_Prénom]?></td>
            <td><?php echo $data[$col_Identifiant]?></td>
            <td><?php echo $data[$col_role]?></td>
            <td><?php echo $data[$col_actif]?></td>
            

<td>

            <?php if ($data[$col_actif] !== "Activer") { ?>
                                    <form action="activation_user.php" method="post">
                                        <input type="hidden" name="id_utilisateur" value="<?php echo $data[$col_id_utilisateur]; ?>">
                                        <input type="hidden" name="actif" value="<?php echo $data[$col_actif]; ?>">
                                        <button type="submit">Activer</button>
                                    </form>
                                <?php } ?>
                                <?php if ($data[$col_actif] !== "Désactiver") { ?>
                                    <form action="desactivation_user.php" method="post">
                                        <input type="hidden" name="id_utilisateur" value="<?php echo $data[$col_id_utilisateur]; ?>">
                                        <input type="hidden" name="actif" value="<?php echo $data[$col_actif]; ?>">
                                        <button type="submit">Désactiver</button>
                                    </form>
                                <?php } ?>
        </tr></td>
        <?php
    }
    ?>
     </table>
     <?php
        fclose($file);
    ?>
        </div>
    </div>

</body>
</html>
 
    

    
     