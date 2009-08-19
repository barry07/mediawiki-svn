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
 * @author Fryed-peach
 */
$messages['qqq'] = array(
	'commentbox-desc' => '{{desc}}',
	'commentbox-name' => '{{Identical|Name}}',
	'commentbox-regex' => 'Regular expression that should match {{msg-mw|commentbox-first-comment-heading}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'commentbox-name' => 'Naam:',
);

$messages['de'] = array(
	'commentbox-desc' => 'Fügt in bestimmte Seiten ein Kommentarfeld ein',
	'commentbox-prefill' => '',
	'commentbox-intro' => '== Kommentar hinzufügen... ==
Du hast einen Kommentar zu dieser Seite? Trag ihn hier ein oder <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=edit}} bearbeite die Seite direkt]</span>.',
	'commentbox-savebutton' => 'Kommentar speichern',
	'commentbox-name' => 'Name:',
	'commentbox-name-explanation' => '<small>(Tipp: Wenn Du Dich [[Spezial:Anmelden|anmeldest]], musst Du nicht mehr hier Deinen Namen angeben)</small>',
	'commentbox-log' => 'Neuer Kommentar',
	'commentbox-first-comment-heading' => '== Kommentare ==',
	'commentbox-regex' => '/\n==\s*Kommentare\s*==\s*\n/i',
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

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'commentbox-name' => 'Nama:',
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

