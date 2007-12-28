<?php
/**
 * Internationalisation file for Farmer extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

# Original messages byGregory Szorc <gregory.szorc@gmail.com>
$messages['en'] = array (
	'farmer'=>'Farmer',
	'farmercantcreatewikis'  => 'You are unable to create wikis because you do not have the createwikis privilege',
	'farmercreateinstructions'  => "In the form below, you will need to fill out some information about your wiki.  Her",
	'farmercreateurl'   => 'URL',
	'farmercreatesitename'  => 'Site Name',
	'farmercreatenextstep'  => 'Next Step',
	'farmernewwikimainpage' =>  "== Welcome to Your Wiki ==\nIf you are reading this, your new wiki has been installed  correctly.  To customize your wiki, please visit [[Special:Farmer]].",
	'farmerwikiurl'    =>  'http://$1.myfarm',
	'farmerinterwikiurl'    => 'http://$1.myfarm/$2',
	'farmer-about' => 'About',
	'farmer-about-text' => 'MediaWiki Farmer always you to manage a farm of MediaWiki wikis.',
	'farmer-list-wikis' => 'List of Wikis',
	'farmer-list-wiki-link' => 'List',
	'farmer-list-wiki-text' => 'all wikis on this site',
	'farmer-createwiki' => 'Create a Wiki',
	'farmer-createwiki-link' => 'Create',
	'farmer-createwiki-text' => 'a new wiki now!',
	'farmer-administration' => 'Farm Administration',
	'farmer-administration-extension' => 'Manage Extensions',
	'farmer-administration-extension-link' => 'Manage',
	'farmer-administration-extension-text' => 'installed extensions.',
	'farmer-admimistration-listupdate' => 'Farm List Update',
	'farmer-admimistration-listupdate-link' => 'Update',
	'farmer-admimistration-listupdate-text' => 'list of wikis on this site',
	'farmer-administration-delete' => 'Delete a Wiki',
	'farmer-administration-delete-link' => 'Delete',
	'farmer-administration-delete-text' => 'a wiki from the farm',
	'farmer-administer-thiswiki' => 'Administer this Wiki',
	'farmer-administer-thiswiki-link' => 'Administer',
	'farmer-administer-thiswiki-text' => 'changes to this wiki',
	'farmer-notavailable' => 'Not Available',
	'farmer-notavailable-text' => 'This feature is only available on the main wiki',
	'farmer-wikicreated' => 'Wiki Created',
	'farmer-wikicreated-text' => 'Your wiki has been created.  It is accessible at ',
	'farmer-default' => 'By default, nobody has permissions on this wiki except you.  You can change the user privileges via',
	'farmer-wikiexists' => 'Wiki Exists',
	'farmer-wikiexists-text' => 'The wiki you are attempting to create, \'\'\'$1\'\'\', already exists.  Please go back and try another name.',
	'farmer-confirmsetting' => 'Confirm Wiki Settings',
	'farmer-confirmsetting-name' => 'Name: $1',
	'farmer-confirmsetting-title' => 'Title: $1',
	'farmer-confirmsetting-description' => 'Description : $1',
	'farmer-description' => 'Description',
	'farmer-confirmsetting-text' => 'Your wiki, \'\'\'$1\'\'\', will be accessible via http://$1.myfarm. The project namespace will be \'\'\'$2\'\'\'.  Links to this namespace will be of the form \'\'\'<nowiki>[[$2:Page Name]]</nowiki>\'\'\'.  If this is what you want, press the \'\'\'confirm\'\'\' button below.',
	'farmer-button-confirm' => 'Confirm',
	'farmer-button-submit' => 'Submit',
	'farmer-createwiki-form-title' => 'Create a Wiki',
	'farmer-createwiki-form-text1' => 'Use the form below to create a new wiki.',
	'farmer-createwiki-form-help' => 'Help',
	'farmer-createwiki-form-text2' => "; Wiki Name : The name of the wiki.  Contains only letters and numbers.  The wiki name will be used as part of the URL to identify your wiki.  For example, if you enter '''title''', then your wiki will be accessed via <nowiki>http://</nowiki>'''title'''.mydomain.",
	'farmer-createwiki-form-text3' => '; Wiki Title : Title of the wiki.  Will be used in the title of every page on your wiki.  Will also be the project namespace and interwiki prefix.',
	'farmer-createwiki-form-text4' => '; Description : Description of wiki.  This is a text description about the wiki.  This will be displayed in the wiki list.',
	'farmer-createwiki-user' => 'Username',
	'farmer-createwiki-name' => 'Wiki Name',
	'farmer-createwiki-title' => 'Wiki Title',
	'farmer-createwiki-description' => 'Description',
	'farmer-updatedlist' => 'Updated List',
	'farmer-notaccessible' => 'Not accessible',
	'farmer-notaccessible-test' => 'This feature is only available on the parent wiki in the farm',
	'farmer-permissiondenied' => 'Permission Denied',
	'farmer-permissiondenied-text' => 'You do not have permission to delete a wiki from the farm',
	'farmer-permissiondenied-text1' => 'You do not have permission to access this page',
	'farmer-deleting' => 'Deleting $1',
	'farmer-delete-title' => 'Delete Wiki',
	'farmer-delete-text' => 'Please select the wiki from the list below that you wish to delete',
	'farmer-delete-form' => 'Select a wiki',
	'farmer-delete-form-submit' => 'Delete',
	'farmer-listofwikis' => 'List of Wikis',
	'farmer-mainpage' => 'Main Page',
	'farmer-basic-title' => 'Basic Parameters',
	'farmer-basic-title1' => 'Title',
	'farmer-basic-title1-text' => 'Your wiki does not have a title.  Set one NOW',
	'farmer-basic-description' => 'Description',
	'farmer-basic-description-text' => 'Set the description of your wiki below',
	'farmer-basic-permission' => 'Permissions',
	'farmer-basic-permission-text' => 'Using the form below, it is possible to alter permissions for users of this wiki.',
	'farmer-basic-permission-visitor' => 'Permissions for Every Visitor',
	'farmer-basic-permission-visitor-text' => 'The following permissions will be applied to every person who visits this wiki',
	'farmer-basic-permission-view' => 'View all articles',
	'farmer-basic-permission-edit' => 'Edit all articles',
	'farmer-basic-permission-createpage' => 'Create new articles',
	'farmer-basic-permission-createtalk' => 'Create talk articles',
	'farmer-basic-permission-move' => 'Move articles',
	'farmer-basic-permission-upload' => 'Upload files',
	'farmer-basic-permission-reupload' => 'Re-upload files (overwrite existing upload)',
	'farmer-basic-permission-minoredit' => 'Allow minor edits',
	'farmer-yes' => 'Yes',
	'farmer-no' => 'No',
	'farmer-basic-permission-user' => 'Permissions for Logged-In Users',
	'farmer-basic-permission-user-text' => 'The follow permissions will be applied to every person who is logged into this wiki',
	'farmer-setpermission' => 'Set Permissions',
	'farmer-defaultskin' => 'Default Skin',
	'farmer-defaultskin-button' => 'Set Default Skin',
	'farmer-extensions' => 'Active Extensions',
	'farmer-extensions-button' => 'Set Active Extensions',
	'farmer-extensions-extension-denied' => 'You do not have permission to use this feature.  You must be a member of the farmeradmin group',
	'farmer-extensions-invalid' => 'Invalid Extension',
	'farmer-extensions-invalid-text' => 'We could not add the extension because the file selected for inclusion could not be found',
	'farmer-extensions-available' => 'Available Extensions',
	'farmer-extensions-noavailable' => 'No extensions are registered',
	'farmer-extensions-register' => 'Register Extension',
	'farmer-extensions-register-text1' => 'Use the form below to register a new extension with the farm.  Once an extension is registered, all wikis will be able to use it.',
	'farmer-extensions-register-text2' => "For the ''Include File'' parameter, enter the name of the PHP file as you would in LocalSettings.php.",
	'farmer-extensions-register-text3' => "If the filename contains '''\$root''', that variable will be replaced with the MediaWiki root directory.",
	'farmer-extensions-register-text4' => 'The current include paths are:',
	'farmer-extensions-register-name' => 'Name',
	'farmer-extensions-register-includefile' => 'Include File',
	'farmer-error-exists' => 'Cannot create wiki.  It already exists: $1',
	'farmer-error-nodirconfig' => 'configDirectory not found: ',
	'farmer-error-defnotset' => 'Default wiki must be set',
	'farmer-error-mapnotfound' => 'Function to map wiki name in farm not found: ',
	'farmer-error-nofileconfwrite' => 'MediaWikiFarmer could not write the default wiki configuration file.',
	'farmer-error-funcnotcall' => 'Could not call function: ',
	'farmer-error-noextwrite' => 'Unable to write out extension file: ',
	'farmer-error-wikicorrupt' => 'Stored wiki is corrupt',
);

# French traduction by Bertrand GRONDIN
$messages['fr'] = array (
	'farmer'=>'Administration Multi Wikis',
	'farmercantcreatewikis'  => 'Vous ne pouvez pas créer des wikis car vous n’avez pas l’habilitation « createwikis » nécessaire pour cela.',
	'farmercreateinstructions'  => "Dans le formulaire ci-dessous, il est nécessaire d'indiquer quelques informations au sujet de votre wiki.",
	'farmercreateurl'   => 'l’adresse',
	'farmercreatesitename'  => 'Nom du site',
	'farmercreatenextstep'  => 'Étape suivante',
	'farmernewwikimainpage' =>  "== Bienvenue dans votre Wiki ==\nSi vous lisez ce message, ceci indique que votre wiki a été installé correctement.  Pour individualiser votre wiki, vous êtes invité à visiter [[Special:Farmer]].",
	'farmerwikiurl'    =>  'http://$1.monsite',
	'farmerinterwikiurl'    => 'http://$1.monsite/$2',
	'farmer-about' => 'À propos',
	'farmer-about-text' => 'L’extension Mediawiki Farmer vous permet, en permanence, d’organiser un ensemble de wikis issu du logiciel Mediawiki.',
	'farmer-list-wikis' => 'Liste des Wikis',
	'farmer-list-wiki-link' => 'Liste',
	'farmer-list-wiki-text' => 'tous les wikis sur ce site.',
	'farmer-createwiki' => 'Créer un Wiki',
	'farmer-createwiki-link' => 'Créer',
	'farmer-createwiki-text' => 'maintenant un nouveau wiki.',
	'farmer-administration' => 'Administration générale',
	'farmer-administration-extension' => 'Organiser les extensions',
	'farmer-administration-extension-link' => 'Organise',
	'farmer-administration-extension-text' => 'Les extensions installées.',
	'farmer-admimistration-listupdate' => 'Mise à jour des la liste des Wikis',
	'farmer-admimistration-listupdate-link' => 'Mise à jour',
	'farmer-admimistration-listupdate-text' => 'de la liste des wikis sur ce site.',
	'farmer-administration-delete' => 'Supprimer un Wiki',
	'farmer-administration-delete-link' => 'Supprimer',
	'farmer-administration-delete-text' => 'un wiki depuis ce site d’administration générale',
	'farmer-administer-thiswiki' => 'Administrer ce Wiki',
	'farmer-administer-thiswiki-link' => 'Administrer',
	'farmer-administer-thiswiki-text' => 'les changements sur ce wiki.',
	'farmer-notavailable' => 'Non disponible',
	'farmer-notavailable-text' => 'Ce programme n’est disponible que sur le site principal',
	'farmer-wikicreated' => 'Wiki créé',
	'farmer-wikicreated-text' => 'Votre wiki a été créé. Il est disponible sur',
	'farmer-default' => 'Par défaut, personne ne dispose de permissions sur ce wiki à part vous. Vous pouvez changer les privilèges utiliteur sur',
	'farmer-wikiexists' => 'Le Wiki existe',
	'farmer-wikiexists-text' => 'Le wiki intitulé \'\'\'$1\'\'\' et que vous vouliez créer, existe déjà.  Nous vous invitons de retourner en arrière et d’essayer un nouveau nom.',
	'farmer-confirmsetting' => 'Confirmer les paramètres du Wiki',
	'farmer-confirmsetting-name' => 'Nom : $1',
	'farmer-confirmsetting-title' => 'Titre : $1',
	'farmer-confirmsetting-description' => 'Description : $1',
	'farmer-description' => 'Description',
	'farmer-confirmsetting-text' => 'Votre wiki, \'\'\'$1\'\'\', sera accessible depuis l’adresse http://$1.monsite.

Le nom de l’espace du projet sera \'\'\'$2\'\'\'.  Les liens vers cet espace aura la forme de \'\'\'<nowiki>[[$2:Nom de la page]]</nowiki>\'\'\'.  Si c’est bien ce que vous voulez,  presser le bouton \'\'\'Confirmer\'\'\' ci-dessous.',
	'farmer-button-confirm' => 'Confirmer',
	'farmer-button-submit' => 'Soumettre',
	'farmer-createwiki-form-title' => 'Créer un Wiki',
	'farmer-createwiki-form-text1' => 'Utilisez le formulaire ci-dessous pour créer un nouveau wiki.',
	'farmer-createwiki-form-help' => 'Aide',
	'farmer-createwiki-form-text2' => "; Nom du Wiki : Le nom du Wiki.  Il ne contient que des lettres et des chiffres. Le nom du wiki sera utilisé comme une partie de l'adresse afin de l'identifier. À titre d'exemple, si vous entrez '''titre''', votre wiki sera accessible sur <nowiki>http://</nowiki>'''titre'''.mondomaine.",
	'farmer-createwiki-form-text3' => '; Titre du Wiki : Le titre du wiki.  Il sera utilisé dans le titre de chaque page de votre wiki. Il prendra le nom de l’espace « Project » ainsi que le préfixe interwiki.',
	'farmer-createwiki-form-text4' => '; Description : Description du wiki. Ceci consiste en un texte décrivant le wiki. Il sera affiché dans la liste des wikis.',
	'farmer-createwiki-user' => 'Nom de l’utilisateur',
	'farmer-createwiki-name' => 'Nom du Wiki',
	'farmer-createwiki-title' => 'Titre du Wiki',
	'farmer-createwiki-description' => 'Description',
	'farmer-updatedlist' => 'Liste mise à jour',
	'farmer-notaccessible' => 'Non accessible',
	'farmer-notaccessible-test' => 'Ce programme est disponible uniquement sur le wiki principal de cet ensemble de projets.',
	'farmer-permissiondenied' => 'Permission refusée',
	'farmer-permissiondenied-text' => 'Vous n’avez pas la permission de supprimer un wiki depuis le site d’administration général.',
	'farmer-permissiondenied-text1' => 'Il ne vous est pas permis d’accéder à cette page.',
	'farmer-deleting' => 'Suppression de $1',
	'farmer-delete-title' => 'Supprimer un Wiki',
	'farmer-delete-text' => 'Veuillez sélectionner le wiki que vous désirez supprimer depuis la liste ci-dessous.',
	'farmer-delete-form' => 'Selectionnez un wiki',
	'farmer-delete-form-submit' => 'Supprimer',
	'farmer-listofwikis' => 'Liste des Wikis',
	'farmer-mainpage' => 'Accueil',
	'farmer-basic-title' => 'Paramètres de base',
	'farmer-basic-title1' => 'Titre',
	'farmer-basic-title1-text' => 'Votre wiki ne dispose pas de titre. Indiquez en un \'\'\'maintenant\'\'\'',
	'farmer-basic-description' => 'Description',
	'farmer-basic-description-text' => 'Indiquez dans le cadre ci-dessous la description de votre wiki.',
	'farmer-basic-permission' => 'Permissions',
	'farmer-basic-permission-text' => 'En utilisant le formulaire ci-dessous, il est possible de changer les habilitation des utilisateurs de ce wiki.',
	'farmer-basic-permission-visitor' => 'Habilitations pour chaque visiteur',
	'farmer-basic-permission-visitor-text' => 'Les habilitations suivantes seront applicables pour toutes les personnes qui visiteront ce wiki.',
	'farmer-basic-permission-view' => 'Visionner toutes les pages ',
	'farmer-basic-permission-edit' => 'Éditer toutes les pages ',
	'farmer-basic-permission-createpage' => 'Créer de nouvelles pages ',
	'farmer-basic-permission-createtalk' => 'Créer des pages de discussion ',
	'farmer-basic-permission-move' => 'Déplacer les pages ',
	'farmer-basic-permission-upload' => 'Télécharger des fichiers ',
	'farmer-basic-permission-reupload' => 'Retélécharger les fichiers (écrase les versions précédentes) ',
	'farmer-basic-permission-minoredit' => 'Autorise les correction mineures ',
	'farmer-yes' => 'Oui',
	'farmer-no' => 'Non',
	'farmer-basic-permission-user' => 'Habilitations pour les utilisateurs enregistrés',
	'farmer-basic-permission-user-text' => 'Les habilitations suivantes seront applicables à tous les utilisateurs enregistrés sur ce wiki.',
	'farmer-setpermission' => 'Configurer les habilitations',
	'farmer-defaultskin' => 'Apparences par défaut',
	'farmer-defaultskin-button' => 'Configurer l’apparence par défaut',
	'farmer-extensions' => 'Extensions actives',
	'farmer-extensions-button' => 'Configurer les Extensions actives',
	'farmer-extensions-extension-denied' => 'Vous n’êtes pas habilité pour l’utilisation de cette fonctionnalité. Vous devez être membre des administrateurs de l’administration multi wikis.',
	'farmer-extensions-invalid' => 'Extension invalide',
	'farmer-extensions-invalid-text' => 'Nous ne pouvons ajouter cette extension car le fichier sélectionné pour l’inclusion est introuvable.',
	'farmer-extensions-available' => 'Extensions disponibles',
	'farmer-extensions-noavailable' => 'Aucune extension n’est enregistrée.',
	'farmer-extensions-register' => 'Enregistrer une extension',
	'farmer-extensions-register-text1' => 'Utilisez le formulaire ci-dessous pour enregistrer une nouvelle extension avec cette fonctionnalité. Une fois l’extension enregistrée, tous les wikis pourront l’utiliser.',
	'farmer-extensions-register-text2' => "En ce qui concerne le paramètre ''Fichier Include'', indiquer le nom du fichier PHP que voudriez dans LocalSettings.php.",
	'farmer-extensions-register-text3' => "Si le nom du fichier contient '''\$root''', cette variable sera remplacée par le répertoire racine de Mediawiki.",
	'farmer-extensions-register-text4' => 'Les chemins actuels des fichiers include sont :',
	'farmer-extensions-register-name' => 'Nom',
	'farmer-extensions-register-includefile' => 'Fichier Include',
	'farmer-error-exists' => 'L’interface ne peut créer le Wiki.  Il existe déjà : $1',
	'farmer-error-nodirconfig' => 'configDirectory introuvable : ',
	'farmer-error-defnotset' => 'Le Wiki par défaut doit être défini.',
	'farmer-error-mapnotfound' => 'La fonction planifiant le nom du wiki est introuvable : ',
	'farmer-error-nofileconfwrite' => 'MediaWikiFarmer ne peut écrire le fichier de configuration du wiki par défaut.',
	'farmer-error-funcnotcall' => 'La fonction suivante est introuvable : ',
	'farmer-error-noextwrite' => 'Impossible d’écrire le fichier d’extension suivant : ',
	'farmer-error-wikicorrupt' => 'Le wiki stocké est corrompu',
);
