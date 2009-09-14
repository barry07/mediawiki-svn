<?php
/**
 * Internationalisation file for extension Commentbox.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'commentbox-desc' => 'Adds a commentbox to certain pages',
	'commentbox-prefill' => '',
	'commentbox-intro' => '== Add a comment... ==
You have a comment on this page? Add it here or <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} edit the page directly]</span>.',
	'commentbox-savebutton' => 'Save comment',
	'commentbox-name' => 'Name:',
	'commentbox-name-explanation' => '<small>(Tip: If you [[Special:UserLogin|log in]], you will not have to fill in your name here manually)</small>',
	'commentbox-log' => 'New comments',
	'commentbox-first-comment-heading' => '== Comments ==',
	'commentbox-regex' => '/\n==\s*Comments\s*==\s*\n/i', # should match the above heading
	'commentbox-errorpage-title' => 'Error while creating comment',
	'commentbox-error-page-nonexistent' => 'This page does not exist!',
	'commentbox-error-namespace' => 'Comments are not allowed in this namespace!',
	'commentbox-error-empty-comment' => 'Empty comments are not allowed!',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author EugeneZelenko
 * @author Fryed-peach
 */
$messages['qqq'] = array(
	'commentbox-desc' => '{{desc}}',
	'commentbox-name' => '{{Identical|Name}}',
	'commentbox-first-comment-heading' => '{{Identical|Comment}}',
	'commentbox-regex' => 'Regular expression that should match {{msg-mw|commentbox-first-comment-heading}}
{{Identical|Comment}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'commentbox-name' => 'Naam:',
	'commentbox-first-comment-heading' => '== Opmerkings ==',
	'commentbox-regex' => '/\\n==\\s*Opmerkings\\s*==\\s*\\n/i',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'commentbox-desc' => 'Дадае поле камэнтару для вызначаных старонак',
	'commentbox-intro' => '== Даданьне камэнтару... ==
Вы маеце камэнтар да гэтай старонкі? Дадайце яго тут альбо <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} непасрэдна адрэдагуйце старонку]</span>.',
	'commentbox-savebutton' => 'Захаваць камэнтар',
	'commentbox-name' => 'Імя:',
	'commentbox-name-explanation' => '<small>(Падказка: Калі Вы [[Special:UserLogin|ўвойдзеце ў сыстэму]], Вам не патрэбна будзе ўводзіць Ваша тут імя ўручную)</small>',
	'commentbox-log' => 'Новыя камэнтары',
	'commentbox-first-comment-heading' => '== Камэнтары ==',
	'commentbox-regex' => '/\\n==\\s*Камэнтары\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Памылка пад час стварэньня камэнтара',
	'commentbox-error-page-nonexistent' => 'Гэта старонка не існуе!',
	'commentbox-error-namespace' => 'У гэтай прасторы назваў камэнтары забароненыя!',
	'commentbox-error-empty-comment' => 'Пустыя камэнтары не дазволеныя!',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'commentbox-desc' => 'Dodaje kutiju za komentare na određene stranice',
	'commentbox-intro' => '== Dodajte komentar... ==
Želite komentirati na ovoj stranici? Dodajte ovdje ili <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} direktno uredite stranicu]</span>.',
	'commentbox-savebutton' => 'Sačuvaj komentar',
	'commentbox-name' => 'Ime:',
	'commentbox-name-explanation' => '<small>(Savjet: Ako se [[Special:UserLogin|prijavite]], nećete morati ovdje ručno popunjavati Vaše ime)</small>',
	'commentbox-log' => 'Novi komentari',
	'commentbox-first-comment-heading' => '== Komentari ==',
	'commentbox-regex' => '/\\n==\\s*Komentari\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Greška pri pravljenju komentara',
	'commentbox-error-page-nonexistent' => 'Ova stranica ne postoji!',
	'commentbox-error-namespace' => 'Komentari nisu dozvoljeni u ovom imenskom prostoru!',
	'commentbox-error-empty-comment' => 'Prazni komentari nisu dozvoljeni!',
);

/** German (Deutsch) */
$messages['de'] = array(
	'commentbox-desc' => 'Fügt in bestimmte Seiten ein Kommentarfeld ein',
	'commentbox-intro' => '== Kommentar hinzufügen... ==
Du hast einen Kommentar zu dieser Seite? Trag ihn hier ein oder <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} bearbeite die Seite direkt]</span>.',
	'commentbox-savebutton' => 'Kommentar speichern',
	'commentbox-name' => 'Name:',
	'commentbox-name-explanation' => '<small>(Tipp: Wenn Du Dich [[Spezial:Anmelden|anmeldest]], musst Du nicht mehr hier Deinen Namen angeben)</small>',
	'commentbox-log' => 'Neuer Kommentar',
	'commentbox-first-comment-heading' => '== Kommentare ==',
	'commentbox-regex' => '/\\n==\\s*Kommentare\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Fehler bei der Erzeugung des Kommentars',
	'commentbox-error-page-nonexistent' => 'Die Seite existiert nicht!',
	'commentbox-error-namespace' => 'Kommentare sind in diesem Namensraum nicht erlaubt!',
	'commentbox-error-empty-comment' => 'Leere Kommentare sind nicht erlaubt!',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'commentbox-desc' => 'Pśidawa komentarowy kašćik do wěstych bokow',
	'commentbox-intro' => '== Komentar pśidaś... ==
Maš komentar na toś tom boku? Pśidaj jen sem abo <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} wobźěłaj bok direktnje]</span>.',
	'commentbox-savebutton' => 'Komentar składowaś',
	'commentbox-name' => 'Mě:',
	'commentbox-name-explanation' => '<small>(Tip: Jolic [[Special:UserLogin|se pśizjawjaš]], njetrjebaš swójo mě how manuelnje zapisaś)</small>',
	'commentbox-log' => 'Nowe komentary',
	'commentbox-first-comment-heading' => '== Komentary ==',
	'commentbox-regex' => '/\\n==\\s*Komentary\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Zmólka pśi napóranju komentara',
	'commentbox-error-page-nonexistent' => 'Toś ten bok njeeksistěrujo!',
	'commentbox-error-namespace' => 'Komentary njejsu dowólone w toś tom mjenjowem rumje!',
	'commentbox-error-empty-comment' => 'Prozne komentary njejsu dowólone!',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'commentbox-desc' => 'Προσθέτει ένα κουτί σχολίων σε συγκεκριμένες σελίδες',
	'commentbox-savebutton' => 'Αποθήκευση σχολίου',
	'commentbox-name' => 'Όνομα:',
	'commentbox-log' => 'Νέα σχόλια',
	'commentbox-first-comment-heading' => '== Σχόλια ==',
	'commentbox-regex' => '/\\n==\\s*Σχόλια\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Σφάλμα κατά τη δημιουργία σχολίου',
	'commentbox-error-page-nonexistent' => 'Αυτή η σελίδα δεν υπάρχει!',
	'commentbox-error-namespace' => 'Σχόλια δεν επιτρέπονται σε αυτόν τον ονοματικό χώρο!',
	'commentbox-error-empty-comment' => 'Κενά σχόλια δεν επιτρέπονται!',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'commentbox-savebutton' => 'Konservi komenton',
	'commentbox-name' => 'Nomo:',
	'commentbox-log' => 'Novaj komentoj',
	'commentbox-first-comment-heading' => '== Komentoj ==',
	'commentbox-error-page-nonexistent' => 'Ĉi tiu paĝo ne ekzistas!',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'commentbox-desc' => 'Agrega un cuadro de comentarios a ciertas páginas',
	'commentbox-intro' => '== Agregar un comentario... ==
Tienes un comentario a esta página? Agrégalo aquí o <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} edita la página directamente]</span>.',
	'commentbox-savebutton' => 'Grabar comentario',
	'commentbox-name' => 'Nombre:',
	'commentbox-name-explanation' => '<small>(Tip: Si [[Special:UserLogin|inicias sesión]], no tendrás que llenar tu nombre manualmente)</small>',
	'commentbox-log' => 'Nuevos comentarios',
	'commentbox-first-comment-heading' => '== Comentarios==',
	'commentbox-regex' => '/\\n==\\s*Comentarios\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Error cuando se creaba un comentario',
	'commentbox-error-page-nonexistent' => 'Esta página no existe!',
	'commentbox-error-namespace' => 'Los comentarios no estan permitidos en este espacio de nombre!',
	'commentbox-error-empty-comment' => 'Comentarios vacíos no están permitidos!',
);

/** French (Français)
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'commentbox-desc' => 'Ajoute une boîte de commentaire dans certaines pages',
	'commentbox-intro' => '== Ajouter un commentaire... ==

Vous avez un commentaire sur cette page ? Ajoutez-le ici ou <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} modifiez la page directement]</span>.',
	'commentbox-savebutton' => 'Enregistrer le commentaire',
	'commentbox-name' => 'Nom :',
	'commentbox-name-explanation' => "<small>(Astuce : si vous [[Special:UserLogin|vous connectez]], vous n'aurez pas à compléter votre nom ici manuellement)</small>",
	'commentbox-log' => 'Nouveaux commentaires',
	'commentbox-first-comment-heading' => '== Commentaires ==',
	'commentbox-regex' => '/\\n==\\s*Commentaires\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Erreur lors de la création du commentaire',
	'commentbox-error-page-nonexistent' => "Cette page n'existe pas !",
	'commentbox-error-namespace' => 'Les commentaires ne sont pas autorisés dans cet espace de noms !',
	'commentbox-error-empty-comment' => 'Les commentaires vides ne sont pas autorisés !',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'commentbox-desc' => 'Engade unha caixa de comentarios a determinadas páxinas',
	'commentbox-intro' => '== Engadir un comentario... ==
Quere facer un comentario sobre esta páxina? Engádao aquí ou <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} edite a páxina directamente]</span>.',
	'commentbox-savebutton' => 'Gardar o comentario',
	'commentbox-name' => 'Nome:',
	'commentbox-name-explanation' => '<small>(Consello: se [[Special:UserLogin|accede ao sistema]], non terá que encher manualmente o seu nome)</small>',
	'commentbox-log' => 'Novos comentarios',
	'commentbox-first-comment-heading' => '== Comentarios ==',
	'commentbox-regex' => '/\\n==\\s*Comentarios\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Erro ao crear o comentario',
	'commentbox-error-page-nonexistent' => 'Esta páxina non existe!',
	'commentbox-error-namespace' => 'Os comentarios non están permitidos neste espazo de nomes!',
	'commentbox-error-empty-comment' => 'Non se permiten comentarios baleiros!',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'commentbox-name' => 'Ὄνομα:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'commentbox-desc' => 'Fiegt in bstimmti Syte ne Aamerkigsfäld yy',
	'commentbox-intro' => '== Aamerkig zuefiege ... ==
Du hesch e Aamerkig zue däre Syte? Trag e do yy oder <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} bearbeit d Syte diräkt]</span>.',
	'commentbox-savebutton' => 'Aamerkig spychere',
	'commentbox-name' => 'Name:',
	'commentbox-name-explanation' => '<small>(Tipp: Wänn Du Di [[Special:UserLogin|aamäldsch]], muesch do nimmi Dyy Name yygee)</small>',
	'commentbox-log' => 'Neji Aamerkig',
	'commentbox-first-comment-heading' => '== Aamerkige ==',
	'commentbox-regex' => '/\\n==\\s*Aamerkige\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Fähler bim Aalege vu dr Aamerkig',
	'commentbox-error-page-nonexistent' => 'Die Syte git s nit!',
	'commentbox-error-namespace' => 'Aamerkige sin in däm Namensruum nit erlaubt!',
	'commentbox-error-empty-comment' => 'Lääri Aamerkige sin nit erlaubt!',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'commentbox-desc' => 'Přidawa komentarowy kašćik do wěstych stronow',
	'commentbox-intro' => '== Komentar přidać... ==
Maš komentar na tutej stronje? Přidaj jón tu abo <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} wobdźěłaj stronu direktnje]</span>.',
	'commentbox-savebutton' => 'Komentar składować',
	'commentbox-name' => 'Mjeno:',
	'commentbox-name-explanation' => '<small>(Tip: Jeli [[Special:UserLogin|so přizjewješ]], njetrjebaš swoje mjeno tu manuelnje zapisać)</small>',
	'commentbox-log' => 'Nowe komentary',
	'commentbox-first-comment-heading' => '== Komentary ==',
	'commentbox-regex' => '/\\n==\\s*Komentary\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Zmylk při wutworjenju komentara',
	'commentbox-error-page-nonexistent' => 'Tuta strona njeeksistuje!',
	'commentbox-error-namespace' => 'Komentary njejsu w tutym mjenowym rumje dowolene!',
	'commentbox-error-empty-comment' => 'Prózdne komentary njejsu dowolene!',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'commentbox-desc' => 'Hozzászólás beviteli mezőt ad egyes lapokhoz',
	'commentbox-intro' => '== Hozzászólás írása… ==

Hozzáfűznivalód van ehhez az oldalhoz? Írd le itt, vagy <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} szerkeszd a lapot közvetlenül.]</span>.',
	'commentbox-savebutton' => 'Hozzászólás mentése',
	'commentbox-name' => 'Név:',
	'commentbox-name-explanation' => '<small>(Tipp: ha [[Special:UserLogin|bejelentkezel]], nem kell kézzel beírnod a nevedet)</small>',
	'commentbox-log' => 'Új hozzászólások',
	'commentbox-first-comment-heading' => '== Hozzászólások ==',
	'commentbox-regex' => '/\\n==\\s*Hozzászólások\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Hiba a hozzászólás készítésekor',
	'commentbox-error-page-nonexistent' => 'Ez a lap nem létezik!',
	'commentbox-error-namespace' => 'A hozzászólások nincsenek engedélyezve ebben a névtérben!',
	'commentbox-error-empty-comment' => 'Az üres hozzászólás nem engedélyezett!',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 */
$messages['id'] = array(
	'commentbox-desc' => 'Menambahkan box komentar pada halaman tertentu',
	'commentbox-intro' => '== Tambah komentar ... ==
Anda memiliki komentar di halaman ini? Tambahkan di sini atau <span class="plainlinks"> [((fullurl:((FULLPAGENAME))|action=edit)) sunting halaman langsung] </span>.',
	'commentbox-savebutton' => 'Simpan komentar',
	'commentbox-name' => 'Nama:',
	'commentbox-name-explanation' => '<small> (Tip: Jika Anda [[Special:UserLogin|log in]], Anda tidak perlu mengisi nama Anda di sini secara manual) </small>',
	'commentbox-log' => 'Komentar baru',
	'commentbox-first-comment-heading' => '== Komentar ==',
	'commentbox-regex' => '/\\n==\\s*Komentar\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Kesalahan selagi membuat komentar',
	'commentbox-error-page-nonexistent' => 'Halaman ini tidak ada!',
	'commentbox-error-namespace' => 'Komentar tidak diperbolehkan pada ruang nama ini!',
	'commentbox-error-empty-comment' => 'Komentar kosong tidak diperbolehkan!',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'commentbox-desc' => 'Aggiunge una casella di commenti a determinate pagine',
	'commentbox-intro' => '== Aggiungere un commento ... ==
Si hanno commenti su questa pagina? Aggiungere qui o <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} modificare direttamente la pagina]</span>.',
	'commentbox-savebutton' => 'Salva commento',
	'commentbox-name' => 'Nome:',
	'commentbox-name-explanation' => "<small>(Suggerimento: Se si [[Special:UserLogin|effettua l'accesso]], non si deve inserire manualmente qui il proprio nome )</small>",
	'commentbox-log' => 'Nuovi commenti',
	'commentbox-first-comment-heading' => '== Commenti ==',
	'commentbox-regex' => '/\\n==\\s*Commenti\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Errore durante la creazione del commento',
	'commentbox-error-page-nonexistent' => 'Questa pagina non esiste',
	'commentbox-error-namespace' => 'Commenti non sono ammessi in questo namespace',
	'commentbox-error-empty-comment' => 'Commenti vuoti non sono ammessi!',
);

/** Japanese (日本語)
 * @author Aotake
 */
$messages['ja'] = array(
	'commentbox-desc' => '指定したページにコメントボックスを追加する',
	'commentbox-intro' => '== 意見を投稿する ==
このページにご意見がありますか？ここに入力するか、あるいは<span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} 直接ページを編集]</span>してください。',
	'commentbox-savebutton' => '意見を保存',
	'commentbox-name' => 'お名前:',
	'commentbox-name-explanation' => '<small>(ヒント: [[Special:UserLogin|ログイン]]すると、手動で名前を入力しなくてよくなります)</small>',
	'commentbox-log' => '新しい意見',
	'commentbox-first-comment-heading' => '==意見==',
	'commentbox-regex' => '/\\n==\\s*意見\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => '意見を作成中にエラーが発生しました',
	'commentbox-error-page-nonexistent' => 'ページが存在しません！',
	'commentbox-error-namespace' => 'この名前空間では意見投稿を受け付けていません！',
	'commentbox-error-empty-comment' => '空の意見は受け付けていません！',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'commentbox-desc' => 'Deiht ene Kaßte för Aanmerkunge op beschtemmpte Sigge derbei.',
	'commentbox-intro' => '== Aanmerkung derbei donn ==
Häß De en Aamerkung zoh heh dä Sigg? Donn se heh enjävve, udder <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} donn heh di Sigg ändere]</span>.',
	'commentbox-savebutton' => 'Aanmerkung avshpeishere',
	'commentbox-name' => 'Name:',
	'commentbox-name-explanation' => '<small>(Opjepaß: Wann De [[Special:UserLogin|enjelog beß]], moß De nit immer heh Dinge Name entippe)</small>',
	'commentbox-log' => 'Neu Aanmerkunge',
	'commentbox-first-comment-heading' => '== Aanmerkunge ==',
	'commentbox-regex' => '/\\n==\\s*Aanmerkunge\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Ene Fähler es opjetrodde wi mer en Aanmerkunge aanlääje wullte',
	'commentbox-error-page-nonexistent' => 'Di Sigg jidd_et nit!',
	'commentbox-error-namespace' => 'Aanmerkunge nit zohjelohße en heh dämm Appachtemang!',
	'commentbox-error-empty-comment' => 'Aanmerkunge met nix dren nit zohjelohße!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'commentbox-desc' => 'Setzt op bestëmmte Säiten eng Këscht fir Bemierkungen derbäi',
	'commentbox-intro' => '== Eng Bemierkung derbäisetzen... ==
Dir hutt eng Bemierkung zu dëser Säit? Setzt ze hei derbäi oder <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} ännert d\'Säit direkt]</span>.',
	'commentbox-savebutton' => 'Bemierkung späicheren',
	'commentbox-name' => 'Numm:',
	'commentbox-name-explanation' => '<small>(Tip: Wann Dir [[Special:UserLogin|Iech umellt]], braucht Dir Ären Numm hei net manuell anzeginn)</small>',
	'commentbox-log' => 'Nei Bemierkungen',
	'commentbox-first-comment-heading' => '== Bemierkungen ==',
	'commentbox-regex' => '/\\n==\\s*Bemierkungen\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Feeler beim Uleeë vun der Bemierkung',
	'commentbox-error-page-nonexistent' => 'Dës Säit gëtt et net!',
	'commentbox-error-namespace' => 'Bemierkunge sinn an dësem Nummraum net erlaabt!',
	'commentbox-error-empty-comment' => 'Eidel Bemierkunge sinn net erlaabt!',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'commentbox-desc' => "Voegt een opmerkingenvenster toe aan bepaalde pagina's",
	'commentbox-intro' => '== U kunt een opmerking toevoegen... ==
Hebt u een opmerking over deze pagina?
Voeg deze hier toe of <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} bewerk deze pagina direct]</span>.',
	'commentbox-savebutton' => 'Opmerking opslaan',
	'commentbox-name' => 'Naam:',
	'commentbox-name-explanation' => '<small>Tip: Als u zich [[Special:UserLogin|aanmeld]], hoeft u uw naam hier niet in de voeren.</small>',
	'commentbox-log' => 'Nieuwe opmerkingen',
	'commentbox-first-comment-heading' => '== Opmerkingen ==',
	'commentbox-regex' => '/\\n==\\s*Opmerkingen\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Er is een fout opgetreden bij het opslaan van de opmerking',
	'commentbox-error-page-nonexistent' => 'Deze pagina bestaat niet!',
	'commentbox-error-namespace' => 'Opmerkingen zijn niet toegestaan in deze naamruimte!',
	'commentbox-error-empty-comment' => 'Lege opmerkingen zijn niet toegestaan!',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Simny
 */
$messages['no'] = array(
	'commentbox-name' => 'Navn:',
	'commentbox-error-page-nonexistent' => 'Denne siden finnes ikke!',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'commentbox-desc' => "Apond una bóstia de comentari dins d'unas paginas",
	'commentbox-intro' => '== Apondre un comentari... ==

Avètz un comentari sus aquesta pagina ? Apondètz-o aicí o <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} modificatz la pagina dirèctament]</span>.',
	'commentbox-savebutton' => 'Enregistrar lo comentari',
	'commentbox-name' => 'Nom :',
	'commentbox-name-explanation' => '<small>(Astúcia : se [[Special:UserLogin|vos connectatz]], auretz pas de completar vòstre nom aicí manualament)</small>',
	'commentbox-log' => 'Comentaris novèls',
	'commentbox-first-comment-heading' => '== Comentaris ==',
	'commentbox-regex' => '/\\n==\\s*Comentaris\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Error al moment de la creacion del comentari',
	'commentbox-error-page-nonexistent' => 'Aquesta pagina existís pas !',
	'commentbox-error-namespace' => 'Los comentaris son pas autorizats dins aqueste espaci de noms !',
	'commentbox-error-empty-comment' => 'Los comentaris voids son pas autorizats !',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'commentbox-desc' => 'Dodaje okienko komentarzy do niektórych stron',
	'commentbox-intro' => '== Dodawanie komentarza... ==
Masz komentarz na tej stronie? Dodaj ten komentarz lub <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} wyedytuj treść strony]</span>.',
	'commentbox-savebutton' => 'Zapisz komentarz',
	'commentbox-name' => 'Imię i nazwisko',
	'commentbox-name-explanation' => '<small>(Podpowiedź – jeśli [[Special:UserLogin|się zalogujesz]] nie będziesz musiał wypełniać podpisu ręcznie)</small>',
	'commentbox-log' => 'Nowe komentarze',
	'commentbox-first-comment-heading' => '== Komentarze ==',
	'commentbox-regex' => '/\\n==\\s*Komentarze\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Wystąpił błąd w trakcie tworzenia komentarza',
	'commentbox-error-page-nonexistent' => 'Strona nie istnieje!',
	'commentbox-error-namespace' => 'W tej przestrzeni nazw nie można umieszczać komentarzy!',
	'commentbox-error-empty-comment' => 'Komentarz nie może być pusty!',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'commentbox-desc' => 'A gionta na pàgina ëd coment a serte pàgine',
	'commentbox-intro' => '== Gionta un coment... ==
It l\'has-to un coment an sta pàgina-sì? Giontlo sì o <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} modìfica la pàgina diretament]</span>.',
	'commentbox-savebutton' => 'salva coment',
	'commentbox-name' => 'Nòm:',
	'commentbox-name-explanation' => "<small>(Tip: S'it [[Special:UserLogin|intre]], it l'avras pa da anserì tò nòm manualment)</small>",
	'commentbox-log' => 'Coment neuv',
	'commentbox-first-comment-heading' => '== Coment ==',
	'commentbox-regex' => '/\\n==\\s*Coment\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Eror an creand un coment',
	'commentbox-error-page-nonexistent' => 'Sta pàgina-sì a esist pa!',
	'commentbox-error-namespace' => 'Ij coment a son pa possìbij an sto spassi nominal-sì!',
	'commentbox-error-empty-comment' => 'Coment veuid a son pa possìbij!',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'commentbox-desc' => 'Adiciona uma caixa de comentários a certas páginas',
	'commentbox-intro' => '== Adicione um comentário... ==
Você tem um comentário sobre esta página? Adicione-o aqui ou <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} edite a página diretamente]</span>.',
	'commentbox-savebutton' => 'Salvar comentário',
	'commentbox-name' => 'Nome:',
	'commentbox-name-explanation' => '<small>(Dica: Se você se [[Special:UserLogin|autenticar]], você não terá que preencher seu nome aqui manualmente)</small>',
	'commentbox-log' => 'Novos comentários',
	'commentbox-first-comment-heading' => '== Comentários ==',
	'commentbox-regex' => '/\\n==\\s*Commentários\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Erro ao criar comentário',
	'commentbox-error-page-nonexistent' => 'Esta página não existe!',
	'commentbox-error-namespace' => 'Comentários não são permitidos neste domínio!',
	'commentbox-error-empty-comment' => 'Comentários vazios não são permitidos!',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'commentbox-desc' => 'Добавляет к определённым страницам поле комментария',
	'commentbox-intro' => '== Добавление комментария… ==
У вас есть замечание к этой странице?
Запишите его здесь или <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} непосредственно отредактируйте страницу]</span>.',
	'commentbox-savebutton' => 'Сохранить комментарий',
	'commentbox-name' => 'Имя:',
	'commentbox-name-explanation' => '<small>(Подсказка. Если вы [[Special:UserLogin|представитесь системе]], вам не придётся указывать ваше имя вручную)</small>',
	'commentbox-log' => 'Новые комментарии',
	'commentbox-first-comment-heading' => '== Комментарии ==',
	'commentbox-regex' => '/\\n==\\s*Комментарии\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Ошибка при создании комментария',
	'commentbox-error-page-nonexistent' => 'Этой страницы не существует!',
	'commentbox-error-namespace' => 'В данном пространстве имён комментарии не разрешены!',
	'commentbox-error-empty-comment' => 'Пустые комментарии не допускаются!',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'commentbox-desc' => 'Pridáva na určité stránky pole na komentár',
	'commentbox-intro' => '== Pridať komentár... ==
Chcete túto stránku okomentovať? Napíšte to sem alebo <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} priamo stránku upravte]</span>.',
	'commentbox-savebutton' => 'Uložiť komentár',
	'commentbox-name' => 'Meno:',
	'commentbox-name-explanation' => '<small>(Tip: Ak sa [[Special:UserLogin|prihlásite]], nebudete sem musieť vypĺňať svoje meno ručne)</small>',
	'commentbox-log' => 'Nové komentáre',
	'commentbox-first-comment-heading' => '== Komentáre ==',
	'commentbox-regex' => '/\\n==\\s*Komentáre\\s*==\\s*\\n/i',
	'commentbox-errorpage-title' => 'Chyba pri vytváraní komentára',
	'commentbox-error-page-nonexistent' => 'Táto stránka neexistuje!',
	'commentbox-error-namespace' => 'Komentáre nie sú v tomto mennom priestore povolené!',
	'commentbox-error-empty-comment' => 'Prázdne komentáre nie sú povolené!',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 */
$messages['te'] = array(
	'commentbox-savebutton' => 'వ్యాఖ్యని భద్రపరచు',
	'commentbox-name' => 'పేరు:',
	'commentbox-log' => 'కొత్త వ్యాఖ్యలు',
	'commentbox-first-comment-heading' => '== వ్యాఖ్యలు ==',
);

