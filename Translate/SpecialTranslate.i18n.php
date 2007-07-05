<?php
/**
 * Internationalisation file for Translate extension.
 *
 * @addtogroup Extensions
*/

$wgTranslateMessages = array();

$wgTranslateMessages['en'] = array(
	'translate' => 'Translate',
	'translate-show-label' => 'Show:',
	'translate-opt-review' => 'Review mode',
	'translate-opt-trans' => 'Untranslated only',
	'translate-opt-optional' => 'Optional',
	'translate-opt-changed' => 'Changed only',
	'translate-opt-ignored' => 'Ignored',
	'translate-opt-database' => 'In database only',
	'translate-messageclass' => 'Message class:',
	'translate-sort-label' => 'Sort:',
	'translate-sort-normal' => 'Normal',
	'translate-sort-alpha'  => 'Alphabetical',
	'translate-fetch-button' => 'Fetch',
	'translate-export-button' => 'Export',
	'translate-edit-message-format' => 'The format of this message is <b>$1</b>.',
	'translate-edit-message-in' => 'Current string in <b>$1</b> ($2):',
	'translate-edit-message-in-fb' => 'Current string in fallback language <b>$1</b> ($2):',
	'translate-choose-settings' => 'Please choose your settings. Note that fetching all core message results in huge table and over 100 KB page!',
	'translate-language'  => 'Language:',
);

$wgTranslateMessages['br'] = array(
	'translate' => 'Treiñ',
	'translate-show-label' => 'Diskouez :',
	'translate-opt-review' => 'Mod gwiriañ',
	'translate-opt-trans' => 'Didro hepken',
	'translate-opt-optional' => 'Diret',
	'translate-opt-changed' => 'Bet kemmet hepken',
	'translate-opt-ignored' => 'Dilezet',
	'translate-opt-database' => 'En diaz-titouroù hepken',
	'translate-messageclass' => 'Rumm kemennadenn',
	'translate-sort-label' => 'Seurt :',
	'translate-sort-normal' => 'Boutin',
	'translate-sort-alpha' => 'Alfabetek',
	'translate-fetch-button' => 'Klask',
	'translate-export-button' => 'Ezporzhiañ',
	'translate-edit-message-format' => 'Furmad ar gemennadenn-mañ zo <b>$1</b>.',
	'translate-edit-message-in' => 'Neudennad red e <b>$1</b> (Kemennadennoù$2.php):',
	'translate-edit-message-in-fb' => 'Neudennad red er yezh kein <b>$1</b> (Kemennadennoù$2.php):',
);

$wgTranslateMessages['ca'] = array(
	'translate'=> 'Tradueix',
	'translate-show-label'=> 'Mostra missatges:',
	'translate-opt-review'=> 'Mode de revisió',
	'translate-opt-trans'=> 'Només sense traduir',
	'translate-opt-optional'=> 'Opcionals',
	'translate-opt-changed'=> 'Només canviats',
	'translate-opt-ignored'=> 'A ignorar',
	'translate-opt-database'=> 'Només traduïts en aquesta base de dades',
	'translate-messageclass'=> 'Classe de missatge:',
	'translate-sort-label'=> 'Ordenació:',
	'translate-sort-normal'=> 'Normal',#identical but defined
	'translate-sort-alpha'=> 'Alfabètica',
	'translate-fetch-button'=> 'Recull',
	'translate-export-button'=> 'Exporta',
	'translate-edit-message-in'=> 'Cadena actual en <strong>$1</strong> (Messages$2.php):',
	'translate-edit-message-in-fb'=> 'Cadena actual en la llengua per defecte <strong>$1</strong> (Messages$2.php):',
);

// bug 8455
$wgTranslateMessages['cs'] = array(
	'translate' => 'Přeložit',
	'translate-show-label' => 'Ukázat:',
	'translate-opt-trans' => 'Jen nepřeložené',
	'translate-opt-optional' => 'volitelné',
	'translate-opt-changed' => 'jen změnené',
	'translate-opt-ignored' => 'ignorované',
	'translate-opt-database' => 'jen v databázi',
	'translate-messageclass' => 'Třída hlášení:',
	'translate-sort-label' => 'Třídění:',
	'translate-sort-normal' => 'obvyklé',
	'translate-sort-alpha'  => 'abecední',
	'translate-fetch-button' => 'Provést',
	'translate-export-button' => 'Exportovat',
	'translate-edit-message-in' => 'Současný řetězec v <b>$1</b> (Messages$2.php):',
	'translate-edit-message-in-fb' => 'Současný řetězec v záložním jazyce <b>$1</b> (Messages$2.php):',
);

/* German by Raymond */
$wgTranslateMessages['de'] = array(
	'translate'                     => 'Übersetze',
	'translate-show-label'          => 'Zeige:',
	'translate-opt-review'          => 'Überprüfungs-Modus',
	'translate-opt-trans'           => 'Nur nicht übersetzte',
	'translate-opt-optional'        => 'Optional',
	'translate-opt-changed'         => 'Nur veränderte',
	'translate-opt-ignored'         => 'ignoriert',
	'translate-opt-database'        => 'Nur in Datenbank',
	'translate-messageclass'        => 'Nachrichten-Klasse:',
	'translate-sort-label'          => 'Sortierung:',
	'translate-sort-normal'         => 'Normal',
	'translate-sort-alpha'          => 'Alphabetisch',
	'translate-fetch-button'        => 'Holen',
	'translate-export-button'       => 'Exportieren',
	'translate-edit-message-format' => 'Das Format dieser Nachricht ist <b>$1</b>.',
	'translate-edit-message-in'     => 'Aktueller Text in <b>$1</b> ($2):',
	'translate-edit-message-in-fb'  => 'Aktueller Text in der Ausweich-Sprache <b>$1</b> ($2):',
);

$wgTranslateMessages['fr'] = array(
	'translate' => 'Traduire',
	'translate-show-label' => 'Montrer :',
	'translate-opt-trans' => 'Non traduits seulement',
	'translate-opt-optional' => 'Optionel',
	'translate-opt-changed' => 'Modifiés seulement',
	'translate-opt-ignored' => 'Ignorés',
	'translate-opt-database' => 'Dans la base de données seulement',
	'translate-messageclass' => 'Classe de message :',
	'translate-sort-label' => 'Trier :',
	'translate-sort-normal' => 'Normal',
	'translate-sort-alpha'  => 'Alphabétique',
	'translate-fetch-button' => 'Charger',
	'translate-export-button' => 'Exporter',
	'translate-edit-message-format' => 'Le format de ce message est <b>$1</b>.',
	'translate-edit-message-in' => 'Chaîne actuellement dans <b>$1</b> (Messages$2.php) :',
	'translate-edit-message-in-fb' => 'Chaîne actuellement dans la langue par défaut <b>$1</b> (Messages$2.php) :',
	'translate-choose-settings' => 'Choisissez vos paramêtres. Notez que récupérer tout les messages donne une table gigantesque et une page de plus de 100Ko !',
	'translate-language'  => 'Langue:',
);

$wgTranslateMessages['he'] = array(
	'translate'                     => 'תרגום',
	'translate-show-label'          => 'הצג:',
	'translate-opt-trans'           => 'רק לא מתורגמות',
	'translate-opt-optional'        => 'אופציונאליות',
	'translate-opt-changed'         => 'רק אם השתנו',
	'translate-opt-ignored'         => 'אינן לתרגום',
	'translate-opt-database'        => 'במסד הנתונים בלבד',
	'translate-messageclass'        => 'סוג ההודעה:',
	'translate-sort-label'          => 'מיון:',
	'translate-sort-normal'         => 'רגיל',
	'translate-sort-alpha'          => 'אלפביתי',
	'translate-fetch-button'        => 'קבל',
	'translate-export-button'       => 'ייצוא',
	'translate-edit-message-format' => 'המבנה של הודעה זו הוא <b>$1</b>.',
	'translate-edit-message-in'     => 'המחרוזת הנוכחית ל־<b>$1</b> ($2):',
	'translate-edit-message-in-fb'  => 'המחרוזת הנוכחית ל־<b>$1</b> בשפת הגיבוי ($2):',
	'translate-choose-settings'     => 'אנא בחרו את ההגדרות שלכם. שימו לב: בחירת כל התוצאות של הודעות הבסיס מופיעה בטבלה גדולה ובדף מעל 100 קילובייט!',
	'translate-language'            => 'שפה:',
);

$wgTranslateMessages['id'] = array(
	'translate' => 'Terjemahan',
	'translate-show-label' => 'Tampilkan:',
	'translate-opt-review' => 'Mode tinjauan',
	'translate-opt-trans' => 'Hanya yang tidak diterjemahkan',
	'translate-opt-optional' => 'Opsional',
	'translate-opt-changed' => 'Hanya yang berubah',
	'translate-opt-ignored' => 'Diabaikan',
	'translate-opt-database' => 'Hanya dalam basis data',
	'translate-messageclass' => 'Kelas pesan:',
	'translate-sort-label' => 'Urutan:',
	'translate-sort-normal' => 'Normal',
	'translate-sort-alpha'  => 'Alfabetis',
	'translate-fetch-button' => 'Cari',
	'translate-export-button' => 'Ekspor',
	'translate-edit-message-format' => 'Format pesan ini adalah <b>$1</b>.',
	'translate-edit-message-in' => 'Kalimat dalam <b>$1</b> (Messages$2.php):',
	'translate-edit-message-in-fb' => 'Kalimat dalam bahasa <b>$1</b> (Messages$2.php):',
	'translate-choose-settings' => 'Harap tandai pilihan Anda. Perhatikan bahwa tampilan pesan sistem inti akan menghasilkan tabel yang besar dan berukuran lebih dari 100 KB!',
	'translate-language'  => 'Bahasa:',
);

$wgTranslateMessages['it'] = array(
	'translate' => 'Traduzione',
	'translate-show-label' => 'Mostra:',
	'translate-opt-review' => 'Modalità revisione',
	'translate-opt-trans' => 'Messaggi da tradurre',
	'translate-opt-optional' => 'Messagi opzionali',
	'translate-opt-changed' => 'Messaggi modificati',
	'translate-opt-ignored' => 'Messaggi ignorati',
	'translate-opt-database' => 'Messaggi presenti nel database',
	'translate-messageclass' => 'Classe del messaggio:',
	'translate-sort-label' => 'Ordinamento:',
	'translate-sort-normal' => 'Normale',
	'translate-sort-alpha'  => 'Alfabetico',
	'translate-fetch-button' => 'Importa',
	'translate-export-button' => 'Esporta',
	'translate-edit-message-format' => 'Formato del messaggio: <b>$1</b>.',
	'translate-edit-message-in' => 'Contenuto attuale in <b>$1</b> ($2):',
	'translate-edit-message-in-fb' => 'Contenuto attuale nella lingua di riserva <b>$1</b> ($2):',
);

$wgTranslateMessages['ja'] = array(
	'translate' => 'インターフェースの翻訳',
	'translate-show-label' => '表示:',
	'translate-opt-review' => 'レビューモード',
	'translate-opt-trans' => '翻訳されていないもの',
	'translate-opt-optional' => 'データベースにないもの',
	'translate-opt-changed' => '変更されたもののみ',
	'translate-opt-ignored' => '無視されているもの',
	'translate-opt-database' => 'データベースにあるもののみ',
	'translate-messageclass' => 'メッセージのクラス:',
	'translate-sort-label' => 'ソート:',
	'translate-sort-normal' => '通常',
	'translate-sort-alpha' => 'アルファベット順',
	'translate-fetch-button' => '表示',
	'translate-export-button' => '書き出し',
	'translate-edit-message-format' => 'このメッセージの書式は <b>$1</b> です。',
	'translate-edit-message-in' => '<b>$1</b> ($2) での現在の文字列:',

	'translate-choose-settings' => '設定を選択してください。メッセージの表示はテーブルで整形されており、 core メッセージでは 100kB を超えることにご注意ください。',
	'translate-language' => '言語:',
);

$wgTranslateMessages['kk-kz'] = array(
	'translate' => 'Аудару',
	'translate-show-label' => 'Көрсету:',
	'translate-opt-review' => 'Шолу тәртібімен',
	'translate-opt-trans' => 'Тек аударылмағандарды',
	'translate-opt-optional' => 'Міндетті еместерді де',
	'translate-opt-changed' => 'Тек өзгергендерді',
	'translate-opt-ignored' => 'Елемелінгендерді де',
	'translate-opt-database' => 'Тек дерекқордағыларды',
	'translate-messageclass' => 'Хабар табы:',
	'translate-sort-label' => 'Сұрыптау:',
	'translate-sort-normal' => 'Қалыппен',
	'translate-sort-alpha'  => 'Әліппемен',
	'translate-fetch-button' => 'Келтіру',
	'translate-export-button' => 'Сыртқа беру',
	'translate-edit-message-format' => 'Бұл хабардың пішімі - <b>$1</b>.',
	'translate-edit-message-in' => '<b>$1</b> ($2) дегендегі ағымдағы жол:',
	'translate-edit-message-in-fb' => '<b>$1</b> ($2) деген сүйену тілінде ағымдағы жол:',
	'translate-choose-settings' => 'Баптауыңызды таңдаңыз.<br />\'\'\'Аңғартпа\'\'\': Барлық ұйытқы хабарларды келтіру нәтижесі өте үлкен кесте болады және де бет мөлшері 100 KB асады!',
	'translate-language'  => 'Тіл:',
);
$wgTranslateMessages['kk-tr'] = array(
	'translate' => 'Awdarw',
	'translate-show-label' => 'Körsetw:',
	'translate-opt-review' => 'Şolw tärtibimen',
	'translate-opt-trans' => 'Tek awdarılmağandardı',
	'translate-opt-optional' => 'Mindetti emesterdi de',
	'translate-opt-changed' => 'Tek özgergenderdi',
	'translate-opt-ignored' => 'Elemelingenderdi de',
	'translate-opt-database' => 'Tek derekqordağılardı',
	'translate-messageclass' => 'Xabar tabı:',
	'translate-sort-label' => 'Surıptaw:',
	'translate-sort-normal' => 'Qalıppen',
	'translate-sort-alpha'  => 'Älippemen',
	'translate-fetch-button' => 'Keltirw',
	'translate-export-button' => 'Sırtqa berw',
	'translate-edit-message-format' => 'Bul xabardıñ pişimi - <b>$1</b>.',
	'translate-edit-message-in' => '<b>$1</b> ($2) degendegi ağımdağı jol:',
	'translate-edit-message-in-fb' => '<b>$1</b> ($2) degen süýenw tilinde ağımdağı jol:',
	'translate-choose-settings' => 'Baptawıñızdı tañdañız.<br />\'\'\'Añğartpa\'\'\': Barlıq uýıtqı xabarlardı keltirw nätïjesi öte ülken keste boladı jäne de bet mölşeri 100 KB asadı!',
	'translate-language'  => 'Til:',
);
$wgTranslateMessages['kk-cn'] = array(
	'translate' => 'اۋدارۋ',
	'translate-show-label' => 'كٶرسەتۋ:',
	'translate-opt-review' => 'شولۋ تٵرتٸبٸمەن',
	'translate-opt-trans' => 'تەك اۋدارىلماعانداردى',
	'translate-opt-optional' => 'مٸندەتتٸ ەمەستەردٸ دە',
	'translate-opt-changed' => 'تەك ٶزگەرگەندەردٸ',
	'translate-opt-ignored' => 'ەلەمەلٸنگەندەردٸ دە',
	'translate-opt-database' => 'تەك دەرەكقورداعىلاردى',
	'translate-messageclass' => 'حابار تابى:',
	'translate-sort-label' => 'سۇرىپتاۋ:',
	'translate-sort-normal' => 'قالىپپەن',
	'translate-sort-alpha' => 'ٵلٸپپەمەن',
	'translate-fetch-button' => 'كەلتٸرۋ',
	'translate-export-button' => 'سىرتقا بەرۋ',
	'translate-edit-message-format' => 'بۇل حاباردىڭ پٸشٸمٸ - <b>$1</b>.',
	'translate-edit-message-in' => '<b>$1</b> ($2) دەگەندەگٸ اعىمداعى جول:',
	'translate-edit-message-in-fb' => '<b>$1</b> ($2) دەگەن سٷيەنۋ تٸلٸندە اعىمداعى جول:',
	'translate-choose-settings' => 'باپتاۋىڭىزدى تاڭداڭىز.<br />\'\'\'اڭعارتپا\'\'\': بارلىق ۇيىتقى حابارلاردى كەلتٸرۋ نٵتيجەسٸ ٶتە ٷلكەن كەستە بولادى جٵنە دە بەت مٶلشەرٸ 100 KB اسادى!',
	'translate-language' => 'تٸل:',
);
$wgTranslateMessages['kk'] = $wgTranslateMessages['kk-kz'];

$wgTranslateMessages['nl'] = array(
	'translate' => 'Vertalen',
	'translate-show-label' => 'Toon:',
	'translate-opt-trans' => 'Alleen onvertaalde',
	'translate-opt-optional' => 'Optineel',
	'translate-opt-changed' => 'Alleen gewijzigd',
	'translate-opt-ignored' => 'Genegeerd',
	'translate-opt-database' => 'Alleen in de database',
	'translate-messageclass' => 'Berichtklasse:',
	'translate-sort-label' => 'Sorteren:',
	'translate-sort-normal' => 'Normaal',
	'translate-sort-alpha'  => 'Alfabetisch',
	'translate-fetch-button' => 'Ophalen',
	'translate-export-button' => 'Exporteren',
	'translate-edit-message-in' => 'Huidige tekst in <b>$1</b> (Messages$2.php):',
	'translate-edit-message-in-fb' => 'Huidige tekst in alternatieve taal <b>$1</b> (Messages$2.php):',
);

$wgTranslateMessages['no'] = array(
	'translate' => 'Oversett',
	'translate-show-label' => 'Vis:',
	'translate-opt-review' => 'Gjennomgangsmodus',
	'translate-opt-trans' => 'Kun uoversatte',
	'translate-opt-optional' => 'Valgfrie',
	'translate-opt-changed' => 'Kun endrede',
	'translate-opt-ignored' => 'Ignorerte',
	'translate-opt-database' => 'Kun i databasen',
	'translate-messageclass' => 'Meldingsklasse:',
	'translate-sort-label' => 'Sortering:',
	'translate-sort-normal' => 'Normal',#identical but defined
	'translate-sort-alpha' => 'Alfabetisk',
	'translate-fetch-button' => 'Hent',
	'translate-export-button' => 'Eksporter',
	'translate-edit-message-format' => 'Formatet på denne meldingen er <b>$1</b>.',
	'translate-edit-message-in' => 'Nåværende streng i <b>$1</b> ($2):',
	'translate-edit-message-in-fb' => 'Nåværende streng i reservespråk <b>$1</b> ($2):',
	'translate-choose-settings' => 'Velg dine innstillinger. Merk at man får en enorm tabell på over 100&nbsp;kB om man henter alle kjernebeskjeder.',
	'translate-language' => 'Språk:',
);

$wgTranslateMessages['oc'] = array(
	'translate' => 'Revirar',
	'translate-show-label' => 'Mostrar:',
	'translate-opt-trans' => 'Non revirats solament',
	'translate-opt-optional' => 'Opcional',
	'translate-opt-changed' => 'Modificats solament',
	'translate-opt-ignored' => 'Ignorats',
	'translate-opt-database' => 'Dins la banca de donadas solament',
	'translate-messageclass' => 'Classa de messatge',
	'translate-sort-label' => 'Triar:',
	'translate-sort-alpha' => 'Alfabetic',
	'translate-fetch-button' => 'Obténer',
	'translate-export-button' => 'Exportar',
	'translate-edit-message-format' => 'Lo format d\'aqueste messatge es <b>$1</b>.',
	'translate-edit-message-in' => 'Cadena actualament dins <b>$1</b> (Messages$2.php) :',
	'translate-edit-message-in-fb' => 'Cadena actualament dins la lenga per defaut <b>$1</b> (Messages$2.php) :',
	'translate-language' => 'Lenga:',
);

 $wgTranslateMessages['ru'] = array(
	'translate' => 'Перевод',
	'translate-show-label' => 'Показать:',
	'translate-opt-review' => 'Режим просмотра',
	'translate-opt-trans' => 'Только непереведённые',
	'translate-opt-optional' => 'Также необязательные',
	'translate-opt-changed' => 'Только изменённые',
	'translate-opt-ignored' => 'Также игнорируемые',
	'translate-opt-database' => 'Только из базы данных',
	'translate-messageclass' => 'Класс сообщений:',
	'translate-sort-label' => 'Сортировать:',
	'translate-sort-normal' => 'по порядку',
	'translate-sort-alpha'  => 'по алфавиту',
	'translate-fetch-button' => 'Получить',
	'translate-export-button' => 'Экспортировать',
	'translate-edit-message-format' => 'Формат текущего сообщения - <b>$1</b>.',
	'translate-edit-message-in' => 'Текущее выражение на языке <b>$1</b> ($2):',
	'translate-edit-message-in-fb' => 'Текущее выражение на базовом языке <b>$1</b> ($2):',
	'translate-choose-settings' => 'Пожалуйста, определитесь с вашими настройками. Примечание: При получении всех сообщений ядра может в результате привести к большому объему таблицы и размеру страницы свыше 100 килобайтe!',
	'translate-language'  => 'Язык:',
);

$wgTranslateMessages['sk'] = array(
	'translate' => 'Preložiť',
	'translate-show-label' => 'Zobraziť:',
	'translate-opt-review' => 'Režim kontroly',
	'translate-opt-trans' => 'Iba nepreložené',
	'translate-opt-optional' => 'Voliteľné',
	'translate-opt-changed' => 'Iba zmenené',
	'translate-opt-ignored' => 'Ignorované',
	'translate-opt-database' => 'Iba z databázy',
	'translate-messageclass' => 'Trieda správy:',
	'translate-sort-label' => 'Zoradiť:',
	'translate-sort-normal' => 'normálne',
	'translate-sort-alpha' => 'abecedne',
	'translate-fetch-button' => 'Priniesť',
	'translate-export-button' => 'Export',#identical but defined
	'translate-edit-message-format' => 'Formát tejto správy je <b>$1</b>.',
	'translate-edit-message-in' => 'Aktuálny reťazec v jazyku <b>$1</b> (Messages$2.php):',
	'translate-edit-message-in-fb' => 'Aktuálny reťazec v jazyku <b>$1</b>, ktorý sa použije ak správa nie je preložená (Messages$2.php):',
	'translate-choose-settings' => 'Prosím, nastavte si svoje preferencie. Pozn.: Prinesenie všetkých správ vyprodukuje obrovskú tabuľku a stránka má vekosť viac ako 100 KB!',
	'translate-language' => 'Jazyk:',
);

$wgTranslateMessages['sr-ec'] = array(
	'translate' => 'Превод',
	'translate-show-label' => 'Покажи:',
	'translate-opt-trans' => 'Само непреведене',
	'translate-opt-optional' => 'Опционо',
	'translate-opt-changed' => 'Само измењене',
	'translate-opt-ignored' => 'Игнорисано',
	'translate-opt-database' => 'Само у бази података',
	'translate-messageclass' => 'Класа порука:',
	'translate-sort-label' => 'Сортирање:',
	'translate-sort-normal' => 'Нормално',
	'translate-sort-alpha'  => 'По абедеци',
	'translate-fetch-button' => 'Прикупљање података',
	'translate-export-button' => 'Извоз',
	'translate-edit-message-in' => 'Тренутни стринг у <b>$1</b> (Messages$2.php):',
	'translate-edit-message-in-fb' => 'Тренутни стринг у језику <b>$1</b> (Messages$2.php):',
);

$wgTranslateMessages['sr-el'] = array(
	'translate' => 'Prevod',
	'translate-show-label' => 'Pokaži:',
	'translate-opt-trans' => 'Samo neprevedene',
	'translate-opt-optional' => 'Opciono',
	'translate-opt-changed' => 'Samo izmenjene',
	'translate-opt-ignored' => 'Ignorisano',
	'translate-opt-database' => 'Samo u bazi podataka',
	'translate-messageclass' => 'Klasa poruka:',
	'translate-sort-label' => 'Sortiranje:',
	'translate-sort-normal' => 'Normalno',
	'translate-sort-alpha'  => 'Po abedeci',
	'translate-fetch-button' => 'Prikupljanje podataka',
	'translate-export-button' => 'Izvoz',
	'translate-edit-message-in' => 'Trenutni string u <b>$1</b> (Messages$2.php):',
	'translate-edit-message-in-fb' => 'Trenutni string u jeziku <b>$1</b> (Messages$2.php):',
);

$wgTranslateMessages['sr'] = $wgTranslateMessages['sr-ec'];

$wgTranslateMessages['su'] = array(
	'translate' => 'Alih basakeun',
	'translate-show-label' => 'Témbongkeun:',
	'translate-opt-review' => 'Modeu ulasan',
	'translate-opt-trans' => 'Ngan nu can dialih basa',
	'translate-opt-optional' => 'Pilihan',
	'translate-opt-changed' => 'Ngan nu geus robah',
	'translate-opt-ignored' => 'Nu diantepkeun',
	'translate-opt-database' => 'Ngan na pangkalan data',
	'translate-messageclass' => 'Kelas talatah:',
	'translate-sort-label' => 'Susun:',
	'translate-sort-alpha' => 'Nurutkeun abjad',
	'translate-fetch-button' => 'Pulut',
	'translate-export-button' => 'Ékspor',
	'translate-edit-message-format' => 'Ieu talatah boga format <b>$1</b>.',
	'translate-edit-message-in' => 'String kiwari dina <b>$1</b> ($2):',
	'translate-edit-message-in-fb' => 'String kiwari dina basa fallback <b>$1</b> ($2):',
	'translate-choose-settings' => 'Mangga pilih setélan salira. Perhatoskeun yén mulut sadaya talatah akar bakal ngahasilkeun béréndélan leuwih ti 100 KB!',
	'translate-language' => 'Basa:',
);

$wgTranslateMessages['yue'] = array(
	'translate' => '翻譯',
	'translate-show-label' => '顯示:',
	'translate-opt-review' => '翻睇模式',
	'translate-opt-trans' => '只有未翻譯嘅',
	'translate-opt-optional' => '可選嘅',
	'translate-opt-changed' => '只有改過嘅',
	'translate-opt-ignored' => '已略過',
	'translate-opt-database' => '只響資料庫度',
	'translate-messageclass' => '信息類:',
	'translate-sort-label' => '排次序:',
	'translate-sort-normal' => '標準',
	'translate-sort-alpha'  => '按字母排',
	'translate-fetch-button' => '攞',
	'translate-export-button' => '倒出',
	'translate-edit-message-format' => '呢句信息嘅格式係 <b>$1</b>。',
	'translate-edit-message-in' => '響 <b>$1</b> 嘅現行字串 ($2):',
	'translate-edit-message-in-fb' => '響 <b>$1</b> 於倚靠語言中嘅現行字串 ($2):',
	'translate-choose-settings' => '請揀你嘅設定。要留意嘅係擷取全部嘅核心信息會載入一個好大嘅表，佢嘅大細可能會超過100KB!',
	'translate-language'  => '語言:',
);

$wgTranslateMessages['zh-hans'] = array(
	'translate' => '翻译',
	'translate-show-label' => '显示:',
	'translate-opt-review' => '翻看方式',
	'translate-opt-trans' => '只有未翻译的',
	'translate-opt-optional' => '可选的',
	'translate-opt-changed' => '只有更改过的',
	'translate-opt-ignored' => '已略过',
	'translate-opt-database' => '只在数据库中',
	'translate-messageclass' => '信息类别:',
	'translate-sort-label' => '排序:',
	'translate-sort-normal' => '标准',
	'translate-sort-alpha'  => '按字母排列',
	'translate-fetch-button' => '颉取',
	'translate-export-button' => '导出',
	'translate-edit-message-format' => '这句信息的格式是 <b>$1</b>。',
	'translate-edit-message-in' => '在 <b>$1</b> 的当前字串 ($2):',
	'translate-edit-message-in-fb' => '在 <b>$1</b> 于倚靠语言中的当前字串 ($2):',
	'translate-choose-settings' => '请选择您的设置。要留意的是撷取全部的核心信息会载入一个十分大的列表，它的大小可能会超过100KB!',
	'translate-language'  => '语言:',
	
);

$wgTranslateMessages['zh-hant'] = array(
	'translate' => '翻譯',
	'translate-show-label' => '顯示:',
	'translate-opt-review' => '翻看模式',
	'translate-opt-trans' => '只有未翻譯的',
	'translate-opt-optional' => '可選的',
	'translate-opt-changed' => '只有更改過的',
	'translate-opt-ignored' => '已略過',
	'translate-opt-database' => '只在資料庫中',
	'translate-messageclass' => '信息類別:',
	'translate-sort-label' => '排序:',
	'translate-sort-normal' => '標準',
	'translate-sort-alpha'  => '按字母排列',
	'translate-fetch-button' => '頡取',
	'translate-export-button' => '匯出',
	'translate-edit-message-format' => '這句信息的格式是 <b>$1</b>。',
	'translate-edit-message-in' => '在 <b>$1</b> 的現行字串 ($2):',
	'translate-edit-message-in-fb' => '在 <b>$1</b> 於倚靠語言中的現行字串 ($2):',
	'translate-choose-settings' => '請選擇您的設定。要留意的是擷取全部的核心信息會載入一個十分大的清單，它的大小可能會超過100KB!',
	'translate-language'  => '語言:',
);

$wgTranslateMessages['zh-cn'] = $wgTranslateMessages['zh-hans'];
$wgTranslateMessages['zh-hk'] = $wgTranslateMessages['zh-hant'];
$wgTranslateMessages['zh-sg'] = $wgTranslateMessages['zh-hans'];
$wgTranslateMessages['zh-tw'] = $wgTranslateMessages['zh-hant'];
$wgTranslateMessages['zh-yue'] = $wgTranslateMessages['yue'];



