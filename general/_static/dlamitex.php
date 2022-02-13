<?php
	$form=true;
	$soumis=false;
	$versionchoisie="";
     
    // clé aléatoire de limite
    $boundary = md5(uniqid(microtime(), TRUE));
?>

<h1 class="titretab"><b><?php echo $phraseLicence;?></b></h1>

<?php
	// Formulaire soumis & champs obligatoires correctement remplis
	if(
		isset($_POST['nom'])
		and isset($_POST['prenom'])
		and isset($_POST['email'])
		and isset($_POST['domaine'])
		and isset($_POST['autredomaine'])
		and isset($_POST['organisme'])
		and isset($_POST['autreorganisme'])
		and isset($_POST['lieu'])
		and isset($_POST['ville'])
		and isset($_POST['pole'])
		and isset($_POST['cadre'])
		and isset($_POST['acclic'])
		// JDT and isset($_POST['captcha'])
        //and (isset($_POST['win32']) or isset($_POST['win64']) or isset($_POST['lin32']) or isset($_POST['lin64']) or isset($_POST['mac']))
        //and ( isset($_POST['lin64']) )
		
		
		
		and !empty($_POST['nom'])
		and !empty($_POST['prenom'])
		and !empty($_POST['email'])
		
		// JDT and $_POST['captcha'] == $_SESSION['Captcha']
		// JDT and validemail($_POST['email'])
		
	) 
	{
		?>
		<!--p><?php echo $phraseVersionsChoisies; ?> :</p-->
		<ul>
		<?php
		$form=false;
		
		// Affichage des liens correspondant aux versions choisies
		/* JDT foreach($version as $cle=>$valeur) {
			if(isset($_POST[$cle]) and $_POST[$cle] == 'on') {
                
				echo "<li style=\"padding-bottom: 5px;\">" . $version[$cle]['nom'] . ": " . "<a href=\"" . $version[$cle]['url']  . "\">" . "Télécharger"  . "</a></li>";	
			}
		}		*/
		?>
		</ul>
		<?php
		
		// Envoi des mails
		
		$email = $_POST['email'];
		$destinatairescea = array('julien.derouillat@cea.fr','lionel.gelebart@cea.fr');
		//$destinatairescea = array('julien.derouillat@cea.fr');
		
		$objetclient = 'Telechargement de AMITEX';
		$objetcea = 'Notification de telechargement AMITEX';
		
		$headers ='From: "Site web AMITEX"<pasdereponse@noreply.fr>'."\n";
        $headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
        $headers .= "\r\n";


// Début avec changement pour pièce jointe : 
        $messagecea = '--'.$boundary."\r\n";
        $messagecea .= 'Content-type:text/plain;charset=utf-8'."\r\n";
        $messagecea .= 'Content-transfer-encoding:8bit'."\r\n";
// Pièce jointe
        $file_name = 'piecejointe.txt';

		$messagecea = "Notification de telechargement de AMITEX";
		$messagecea .= "\r\n\r\n\r\n\r\n";
		$messagecea .= "Nom : " . $_POST['nom'] . "\r\n" . "Prenom : " . $_POST['prenom'] .  "\r\n";
		$messagecea .= "Adresse e-mail : " . $email . "\r\n" . "\r\n";
		$messagecea .= "Lieu : " . $_POST['lieu'] . "\r\n" . "Ville : " . $_POST['ville'] . "\r\n" . "\r\n";
		$messagecea .= "Domaine d'utilisation : " . $_POST['domaine'] . "\r\r\n" ;
		$messagecea .= "Autre domaine d'utilisation : " . $_POST['autredomaine'] . "\r\r\n";		
		$messagecea .= "Type d'organisme : " . $_POST['organisme'] . "\r\r\n";
		$messagecea .= "Autre type d'organisme : " . $_POST['autreorganisme'] . "\r\r\n";
		$messagecea .= "Pole CEA : " . $_POST['pole'] . "\r\n" . "\r\n";
		$messagecea .= "Cadre d'utilisation : " . $_POST['cadre'] . "\r\n" . "\r\n";
		/*if (isset($_POST['accmail'])){
			$_POST['accmail']="o";
			$messagecea .= "Désire recevoir les mails Cast3M : oui"  . "\r\n";
		}		
		else {
			$_POST['accmail']="n";
			$messagecea .= "Désire recevoir les mails Cast3M : non"  . "\r\n";
		}	*/

		$messagecea .= "\r\n\r\n";
		$messagecea .= "Versions telechargees : \r\n";
		
		/* JDT foreach($version as $cle=>$valeur) {
			if(isset($_POST[$cle]) and $_POST[$cle] == 'on') {
				$messagecea .= $version[$cle]['nom'] . "\r\n";
				$versionchoisie .= $cle . " " ;	
			}
		} */
		$messagecea .= "\r\n\r\nLicence acceptee le " . $_POST['date'] . "\r\n";

		$messageclient .= "\r\n\r\nMerci d'avoir telecharge AMITEX_FFTP. le " . $_POST['date'] . "\r\n";

        if (file_exists($file_name))
            {
                $file_type = filetype($file_name);
                $file_size = filesize($file_name);
             
                $handle = fopen($file_name, 'r') or die('File '.$file_name.'can t be open');
                $content = fread($handle, $file_size);
                $content = chunk_split(base64_encode($content));
                $f = fclose($handle);
             
                /*$messagecea .= '--'.$boundary."\r\n";
                $messagecea .= 'Content-type:'.$file_type.';name='.$file_name."\r\n";
                $messagecea .= 'Content-transfer-encoding:base64'."\r\n";
                $messagecea .= $content."\r\n";*/
            }
 
        //$messagecea .= '--'.$boundary."\r\n";
		
		mail($email, $objetclient, $messageclient, $headers);
		
		foreach($destinatairescea as $destinataire) {
			mail($destinataire, $objetcea, $messagecea, $headers);
            //echo "Envoi du message" . "<br />";
            //echo $messagecea;
		}

		

// 	    Connexion à la base de données Cast3M
		// JDT mysql_connect("localhost", "root", "") or die ("Connexion impossible");
		// JDT mysql_select_db("cast3m") or die ("BDD inaccessible");
//		Envoi des requêtes de remplissage de la bdd
echo $versionchoisie;
		/*$Req = "INSERT INTO client(NomClient,PrenomClient,MailClient,DomaineClient,AutreDomaineClient,OrganismeClient,AutreOrganismeClient,LieuClient,VilleClient,PoleClient,CadreClient,VersionClient,AccMailClient,DateClient)
		VALUES('$_POST[nom]','$_POST[prenom]','$_POST[email]','$_POST[domaine]','$_POST[autredomaine]','$_POST[organisme]','$_POST[autreorganisme]','$_POST[lieu]','$_POST[ville]','$_POST[pole]','$_POST[cadre]','$versionchoisie','$_POST[accmail]','$_POST[date]')";*/
		$Req = "INSERT INTO client(NomClient,PrenomClient,MailClient,DomaineClient,AutreDomaineClient,OrganismeClient,AutreOrganismeClient,LieuClient,VilleClient,PoleClient,CadreClient,VersionClient,AccMailClient,DateClient)
		VALUES('$_POST[nom]','$_POST[prenom]','$_POST[email]','$_POST[domaine]','$_POST[autredomaine]','$_POST[organisme]','$_POST[autreorganisme]','$_POST[lieu]','$_POST[ville]','$_POST[pole]','$_POST[cadre]','$versionchoisie','$_POST[date]')";
		
		// JDT $oReq = mysql_query($Req) or die (mysql_error());
		
			
		
		
	// Formulaire soumis & champs obligatoires non remplis/incorrectement remplis
	} elseif(
		isset($_POST['nom'])
	){

		$form=true;
		$soumis=true;
	
	}
	
	// Affichage du formulaire ; Si la variable $soumis est à true, on vérifie également que certains champs sont correctement remplis
	// et on leur applique la classe css "invalide" si ce n'est pas le cas
	if($form) {
		//$_SESSION['Captcha'] = random_str(5);
		echo "Some data ara missing :" . "<br />";
                ?> <a href="http://www.maisondelasimulation.fr/projects/amitex/download_test/html/_static/download_amitex_fftp.html">Fill the AMITEX_FFTP form </a> <?php;
/*
		?>
		
		<form action="index.php?page=dlamitex" method="POST">

			<fieldset>
				<legend><?php echo $phraseTitreTel;?></legend>
			
				<table border="0" cellpadding="5" cellspacing="0" class="formtelechargement">
					<tr>
						<td><?php echo $termeDate; ?> : </td>
						<td><input type="text" name="date" value="<?php echo date('d/m/Y'); ?>" readonly="readonly" size="8" /></td>
					</tr>
					<tr>
						<td><?php echo $termeNom; ?> : </td>
						<td><input <?php echo (isset($_POST['nom']) and empty($_POST['nom']) and $soumis==true)?"class=\"invalide\"":""; ?> type="text" name="nom" <?php if(isset($_POST['nom'])) echo "value=\"".$_POST['nom']."\""; ?> size="30" /></td>
						<td><?php echo $termePrenom; ?> : </td>
						<td><input <?php echo (isset($_POST['prenom']) and empty($_POST['prenom']) and $soumis==true)?"class=\"invalide\"":""; ?> type="text" name="prenom" <?php if(isset($_POST['prenom'])) echo "value=\"".$_POST['prenom']."\""; ?> size="30" /></td>
					</tr>
					<tr>
						<td><?php echo $termeAdresseMail; ?> : </td>
						<td><input <?php echo (isset($_POST['email']) and !validemail($_POST['email']) and $soumis==true)?"class=\"invalide\"":""; ?> type="text" name="email" <?php if(isset($_POST['email'])) echo "value=\"".$_POST['email']."\""; ?> size="30" /></td>
					</tr>
				</table>	
			</fieldset>
			<fieldset>
				<legend><?php echo $phraseTitreGeo;?></legend>
				
				<table border="0" cellpadding="5" cellspacing="0" class="formtelechargement">
					<tr>
						<td><?php echo $termeLieu; ?> : </td>	
						<td>						
						<select name="lieu"><?php
						foreach($choixLieu as $value) {
								echo "<option value=\"$value\"";
								if(isset($_POST['lieu']) and $_POST['lieu'] == $value) echo " selected=\"selected\"";
								echo ">$value</option>";
							}
						?></td>
						</select>  
						<td><?php echo $termeVille; ?> : </td>
						<td><input type="text" name="ville" <?php if(isset($_POST['ville'])) echo "value=\"".$_POST['ville']."\""; ?> size="30" /></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><?php echo $phraseTitreAct;?></legend>	
					
					<table border="0" cellpadding="5" cellspacing="0" class="formtelechargement">
						<td colspan="1" style="padding-top: 20px;"><?php echo $phraseDomaine; ?></td>
						<td colspan="2" style="padding-top: 20px;">
						<select name="domaine"> <?php
							foreach($choixDomaine as $value) {
								echo "<option value=\"$value\"";
								if(isset($_POST['domaine']) and $_POST['domaine'] == $value) echo " selected=\"selected\"";
								echo ">$value</option>";
							}
							?></select>
					</tr>
					<tr>
						<td><?php echo $siAutre; ?> : </td>
			
						<td><input type="text" name="autredomaine" <?php if(isset($_POST['autredomaine'])) echo "value=\"".$_POST['autredomaine']."\""; ?> size="30" /></td>
					</tr>
					
					
					
					<tr>
						<td colspan="1" style="padding-top: 20px;"><?php echo $phraseOrganisme; ?></td>
						<td colspan="2" style="padding-top: 20px;">
						<select name="organisme"><?php
							foreach($choixOrganisme as $value) {
								echo "<option value=\"$value\"";
								if(isset($_POST['organisme']) and $_POST['organisme'] == $value) echo " selected=\"selected\"";
								echo ">$value</option>";
							}
							?></select>
					</tr>
					<tr>
						<td><?php echo $siAutre; ?> : </td>
						<td><input type="text" name="autreorganisme" <?php if(isset($_POST['autreorganisme'])) echo "value=\"".$_POST['autreorganisme']."\""; ?> size="30" /></td>
					</tr>
				
					<tr>
					
					<td colspan="1" style="padding-top: 20px;"><?php echo $phrasePole; ?></td>
					<td colspan="2" style="padding-top: 20px;">
					<select name="pole"><?php
						foreach($choixPole as $value) {
							echo "<option value=\"$value\"";
							if(isset($_POST['pole']) and $_POST['pole'] == $value) echo " selected=\"selected\"";
							echo ">$value</option>";
						}
						?></select>
					</tr> 
					
					<!-- NewTL fin-->
					<tr>
						<td colspan="1" style="padding-top: 20px;"><?php echo $phraseCadre; ?> </td>
						<td colspan="2" style="padding-top: 20px;">
							<select name="cadre"><?php
							// Affichage du menu déroulant : on boucle à l'intérieur du tableau $choixUtilisation (fichiers local_fr et local_en dans le répertoire inc)
							// pour afficher une option du menu pour chaque valeur
							// On regarde aussi quelle valeur du menu a été sélectionnée précédemment (si formulaire soumis au moins une fois)
							// pour la resélectionner automatiquement dans le cas où certaines valeurs manquaient dans d'autres champs
							foreach($choixUtilisation as $value) {
								echo "<option value=\"$value\"";
								if(isset($_POST['cadre']) and $_POST['cadre'] == $value) echo " selected=\"selected\"";
								echo ">$value</option>";
							}
							?></select>
						</td>
					</tr>

				</table>
					
			</fieldset>
			<fieldset>
				<legend><?php echo $phraseTitreVersion;?></legend>
				
				<p style="margin-bottom:20px;">
					<?php echo $phraseVersion; ?>
				</p>
				
				<table class="centre" style="margin-bottom: 20px;">
				
					<tr class="bordb">
						<td class="bordd"></td>
						<td>Windows 32 bits</td>
                        <td>Windows 64 bits</td>
						<td>Linux 32 bits</td>
                        <td>Linux 64 bits</td>
						<td>Mac</td>
					</tr>
							
									
					<tr>
						<td class="bordd"></td>
						<td><input type="checkbox" name="win32" <?php if(isset($_POST['win32'])) echo "checked=\"checked\""; ?> /></td>
                        <td><input type="checkbox" name="win64" <?php if(isset($_POST['win64'])) echo "checked=\"checked\""; ?> /></td>
						<td><input type="checkbox" name="lin32" <?php if(isset($_POST['lin32'])) echo "checked=\"checked\""; ?> /></td>
                        <td><input type="checkbox" name="lin64" <?php if(isset($_POST['lin64'])) echo "checked=\"checked\""; ?> /></td>
						<td><input type="checkbox" name="mac" <?php if(isset($_POST['mac'])) echo "checked=\"checked\""; ?> /></td>						
					</tr>
				</table>
				 <?php
                if (!isset($_POST['win32']) and !isset($_POST['win64']) and !isset($_POST['lin32']) and !isset($_POST['lin64']) and !isset($_POST['mac']) and $soumis==true){
                    ?><p class="invalide centre"><?php echo $phraseUneVersion?></p><?php     
                }
                
                ?> 
			</fieldset>
			<fieldset>
				<legend><?php echo $phraseTitreLicence;?></legend>
				
				<div class="licence"><?php include("inc/licence_" . $lang . ".txt"); ?></div>
				<p class="centre"><a href="CT_INTERNET_Cast3M_recherche_FR_ANG_2011_version_23032011_SP.pdf"><?php echo $phraseLicencePdf; ?></a></p>

				
				<p class="<?php echo (!isset($_POST['acclic']) and $soumis==true)?"invalide ":" "; ?>centre">
					
					<input type="checkbox" name="acclic" value="o"/> <?php echo $phraseAccepteLicence;?><br />
				
				</p>
				<!--p class="<?php echo (isset($_POST['accmail']) and $soumis==true)?"invalide ":" "; ?>centre">
					
					<input type="checkbox" name="accmail" value="o"/> <?php echo $phraseAccepteMail;?><br />
				</p-->				
				<!--p style="margin-top:30px;" class="<?php echo (isset($_POST['captcha']) and $_POST['captcha']!=$_SESSION['Captcha'] and $soumis==true)?"invalide ":" "; ?>centre"><?php echo $phraseTapezCode; ?> : <img src="inc/captcha.png.php?PHPSESSID=<?php echo session_id(); ?>" alt="Recopiez le code"/> <input type="text" name="captcha" /></p-->
				
				<p class="centre" style="margin-top: 20px;"><input type="submit" value="<?php echo $termeSuivant;?>"/></p>

			</fieldset>
		</form>

		
		<?php
                echo "End affichage" . "<br />";
		*/
	}
        else {
            ?> <a href="_download/amitex_fftp-v8.17.9.tar">Telecharger AMITEX_FFTP </a> <?php;
        }
	
?>
