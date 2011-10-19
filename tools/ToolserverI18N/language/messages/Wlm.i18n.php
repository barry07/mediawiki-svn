<?php
/**
 * Interface messages for wlm tools.
 *
 * @toolowner platonides
 */

$url = '~platonides/wlm/';

$messages = array();

/**
 * English
 *
 * @author Platonides
 */
$messages['en'] = array(
	'title' => 'WLM files',

	/* uploads.php */
	'file' => 'Image',
	'monument-type' => 'Monument type',
	'monument-id' => 'Monument id',
	'province' => 'Province',
	'comarque' => 'Comarque',
	'province-comarque-joiner' => '$1 / $2', // Optional
	'competes' => 'Competes',
	'author' => 'Author',
	'upload-time' => 'Upload time',
	'concursa' => 'Takes part in WLM',
	'no-concursa' => 'Outside WLM competition',
	'not-available' => 'Not available',
	'date-unknown' => 'Unknown',
	'total-images' => 'Total images: $1',
	'view-uncategorized-images' => 'View uncategorized images',
	'provide-id' => 'Provide a monument id to show the data available for that item',
	'show-images-bad-only' => 'Show only images outside the lists',
	'show-images-all' => 'Show all images',
	'search-monuments' => 'Search monuments',
	'view-frequency' => 'Popular monuments',
	'view-ccaa' => 'View by autonomous community',
	'view-province' => 'View by province',

	/* ids.php */
	'id-label' => 'Monument id:',
	'date-format' => 'd-m-Y H:i:s',

	/* monumentos.php */
	'id-none' => '(None)',
	'monument-heading' => 'Monument',
	'count-heading' => 'Photographs',
	'bic-list' => 'List',
	'bic-gallery' => 'Gallery',

	/* gallery.php */
	'gallery-header' => 'Images for the monument with id $1.',
	'gallery-header-place' => 'Images for monuments from $1.',

	/* wall-of-shame.php */
	'wall-of-shame-text' => 'Authors by number of unidentified photographs',
	'author-heading' => 'Author',
	'bic-list-bad' => 'Show',
	'bic-list-all' => 'Full list',
	'unregistered' => 'Unregistered',

	/* province.php, ccaa.php */
	'province-heading' => 'Province',
	'province-none' => '(Unknown)',
	'ccaa-heading' => 'CC.AA.',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author McDutchie
 * @author Platonides
 */
$messages['qqq'] = array(
	'title' => 'Title of the different pages',
	'file' => 'Header for the column showing the filenames.
{{Identical|File}}',
	'monument-type' => 'Header for the column showing the type of monument -BIC or BCIL-, basically the template used',
	'monument-id' => 'Header for the column showing the monument id',
	'province' => 'Header for the column showing the monument province',
	'comarque' => 'Header for the column showing the monument comarque (for Catalonia and Valencia, see http://en.wikipedia.org/wiki/Comarques_of_Catalonia and http://en.wikipedia.org/wiki/Comarques_of_the_Valencian_Community)',
	'province-comarque-joiner' => 'Used to join province and comarque when both are available. $1: Province, $2: Comarque {{Optional}}',
	'competes' => 'Header for the column showing if the monument takes part in the competition',
	'author' => 'Header for the column showing the author listed for that image.
{{Identical|Author}}',
	'upload-time' => 'Upload time in CEST',
	'concursa' => 'Entry for the competes column if the monuments takes part in WLM (also see: {{msg-toolserver|Wlm-no-concursa}})',
	'no-concursa' => 'Entry for the competes column if the monuments does not take part in WLM (also see: {{msg-toolserver|Wlm-concursa}})',
	'not-available' => 'Shown for images not yet loaded',
	'date-unknown' => 'Showed when the
{{Identical|Unknown}}',
	'total-images' => 'A message with the total number of images listed above, provided in $1',
	'view-uncategorized-images' => 'Caption for link to [[commons:Category:Cultural_heritage_monuments_in_Spain]]',
	'provide-id' => 'Caption for ids.php',
	'show-images-bad-only' => 'Text for the link for filtering to just images with a bad id',
	'show-images-all' => 'Text for the link for unfiltering the list to all images',
	'search-monuments' => 'Caption link for the tool to search monuments',
	'view-frequency' => 'Caption link for the tool to view monuments grouped by id',
	'view-ccaa' => 'Caption link for the tool to view monuments grouped by autonomous community',
	'view-province' => 'Caption link for the tool to view monuments grouped by province',
	'id-label' => 'Label for ids.php input',
	'date-format' => 'Format in which to present the date in the upload-time column',
	'id-none' => "Column to show where there's no id.
{{Identical|None}}",
	'monument-heading' => 'Heading for the identifier',
	'count-heading' => 'Heading for the count of images with that id',
	'bic-list' => 'Text of link which shows the list of monuments with the id of this row.
{{Identical|List}}',
	'bic-gallery' => 'Text of link which shows the gallery of monuments with the id of this row.
{{Identical|Gallery}}',
	'gallery-header' => 'Text for the gallery pages. $1 is the selected monument id.',
	'gallery-header-place' => 'Text for the gallery pages. $1 is the location for the monuments (province / autonomous community).',
	'wall-of-shame-text' => 'Text for explaining the wall-of-shame page',
	'author-heading' => 'Heading for the column with the list of authors.
{{Identical|Author}}',
	'bic-list-bad' => 'Caption for the link to show the bad images by this user.
{{Identical|Show}}',
	'bic-list-all' => 'Caption for the link to show all the images by this user',
	'unregistered' => 'Text to show when grouping users not registered in commons (from flickr or panoramio)',
	'province-heading' => 'Header for the province column of http://toolserver.org/~platonides/wlm/provincias.php',
	'province-none' => 'Marker to group images for which no province is registered in the db.
{{Identical|Unknown}}',
	'ccaa-heading' => 'Header for the autonomous communities column',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'title' => 'Ficheros de WLM',
	'file' => 'Imaxe',
	'monument-type' => 'Triba de monumentu',
	'monument-id' => 'Id. del monumentu',
	'province' => 'Provincia',
	'competes' => 'Competición',
	'author' => 'Autor',
	'upload-time' => 'Data de carga',
	'concursa' => 'Participa en WLM',
	'no-concursa' => 'Nun compite en WLM',
	'not-available' => 'Non disponible',
	'date-unknown' => 'Desconocíu',
	'total-images' => "Total d'imaxes: $1",
	'view-uncategorized-images' => 'Ver imaxes ensin categoría',
	'provide-id' => "Da l'identificador d'un monumentu p'amosar los datos disponibles d'esi elementu",
	'show-images-bad-only' => 'Amosar sólo les imaxes fuera de les llistes',
	'show-images-all' => 'Amosar toles imaxes',
	'search-monuments' => 'Guetar monumentos',
	'view-frequency' => 'Monumentos populares',
	'view-province' => 'Ver por provincies',
	'id-label' => 'Id. del monumentu:',
	'id-none' => '(Nengún)',
	'monument-heading' => 'Monumentu',
	'count-heading' => 'Semeyes',
	'bic-list' => 'Llista',
	'bic-gallery' => 'Galería',
	'gallery-header' => 'Imaxes del monumentu con identificador $1.',
	'wall-of-shame-text' => 'Autores por númberu de semeyes ensin identificar',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Amosar',
	'bic-list-all' => 'Llista completa',
	'unregistered' => 'Ensin rexistrar',
	'province-heading' => 'Provincia',
	'province-none' => '(Desconocíu)',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'title' => 'WLM-файлы',
	'file' => 'Файл',
	'monument-type' => 'Тып славутасьці',
	'monument-id' => 'Ідэнтыфікатар славутасьці',
	'province' => 'Правінцыя/вобласьць',
	'competes' => 'Спаборніцтвы',
	'author' => 'Аўтар',
	'upload-time' => 'Час загрузкі',
	'concursa' => 'Прыняць удзел у «Вікі любіць славутасьці»',
	'no-concursa' => 'Па-за спаборніцтвам «Вікі любіць славутасьці»',
	'not-available' => 'Не даступна',
	'date-unknown' => 'Невядома',
	'total-images' => 'Усяго выяваў: $1',
	'view-uncategorized-images' => 'Паказаць некатэгорызаваныя выявы',
	'provide-id' => 'Падаць ідэнтыфікатар славутасьці, каб паказаць даступныя зьвесткі',
	'show-images-bad-only' => 'Паказаць толькі выявы па-за сьпісамі',
	'show-images-all' => 'Паказаць усе выявы',
	'search-monuments' => 'Пошук славутасьцяў',
	'view-frequency' => 'Папулярныя славутасьці',
	'view-ccaa' => 'Паказаць аўтаномную супольнасьць',
	'view-province' => 'Паказаць па правінцыях (абласьцях)',
	'id-label' => 'Ідэнтыфікатар славутасьці:',
	'id-none' => '(Няма)',
	'monument-heading' => 'Славутасьць',
	'count-heading' => 'Фатаграфіі',
	'bic-list' => 'Сьпіс',
	'bic-gallery' => 'Галерэя',
	'gallery-header' => 'Выявы для славутасьці з ідэнтыфікатарам $1.',
	'gallery-header-place' => 'Выявы славутасьцяў з $1.',
	'wall-of-shame-text' => 'Аўтары па нумарах неіндэфікаваных фатаграфіяў',
	'author-heading' => 'Аўтар',
	'bic-list-bad' => 'Паказаць',
	'bic-list-all' => 'Поўны сьпіс',
	'unregistered' => 'Незарэгістраваныя',
	'province-heading' => 'Правінцыя/вобласьць',
	'province-none' => '(Невядома)',
	'ccaa-heading' => 'CC.AA.',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'title' => 'Restroù Wiki Loves Monuments (WLM)',
	'file' => 'Skeudenn',
	'monument-type' => 'Seurt monumant',
	'monument-id' => 'Kod ar Monumant',
	'province' => 'Proviñs',
	'competes' => 'Kenstrivañ',
	'author' => 'Aozer',
	'upload-time' => 'Deiziad enporzhiañ',
	'concursa' => 'Kemerit perzh e WLM',
	'no-concursa' => 'Er-maez kenstrivadeg WLM',
	'not-available' => "N'eo ket hegerz",
	'date-unknown' => 'Dianav',
	'total-images' => 'Hollad ar skeudennoù : $1',
	'view-uncategorized-images' => 'Gwelet ar skeudennoù dirumm',
	'provide-id' => 'Pourchas anaouder ur monumant evit ma vo gallet diskouez ar roadennoù zo diwar e benn',
	'show-images-bad-only' => "Diskouez hepken ar skeudennoù n'emaint ket er rolloù",
	'show-images-all' => 'Diskouez an holl skeudennoù',
	'search-monuments' => 'Klask monumantoù',
	'view-frequency' => 'Monumantoù brudet',
	'view-province' => 'Gwelet ar skeudennoù dre broviñsoù',
	'id-label' => 'Kod ar Monumant :',
	'id-none' => '(Hini ebet)',
	'monument-heading' => 'Monumant',
	'count-heading' => "Luc'hskeudennoù",
	'bic-list' => 'Roll',
	'bic-gallery' => 'Skeudennaoueg',
	'gallery-header' => "Skeudennoù eus ar monumant dezho ar c'hod $1.",
	'wall-of-shame-text' => "Aozerien dre niver a luc'hskeudennoù dianav",
	'author-heading' => 'Aozer',
	'bic-list-bad' => 'Diskouez',
	'bic-list-all' => 'Roll klok',
	'unregistered' => 'Dienroll',
	'province-heading' => 'Proviñs',
	'province-none' => '(Dianav)',
);

/** Catalan (Català)
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'title' => 'Fitxers del WLM',
	'file' => 'Imatge',
	'monument-type' => 'Tipus de monument',
	'monument-id' => 'ID del monument',
	'province' => 'Província',
	'competes' => 'Competeix',
	'author' => 'Autor',
	'upload-time' => 'Temps de pujada',
	'concursa' => 'Participa al WLM',
	'no-concursa' => 'Fora de la competició del WLM',
	'not-available' => 'No disponible',
	'date-unknown' => 'Desconegut',
	'total-images' => 'Imatges totals: $1',
	'view-uncategorized-images' => 'Mostra les imatges sense categoria',
	'provide-id' => "Proporciona un ID de monument per mostrar les dades disponibles de l'element",
	'show-images-bad-only' => 'Mostra només les imatges fora de les llistes',
	'show-images-all' => 'Mostra totes les imatges',
	'search-monuments' => 'Cerca monuments',
	'view-frequency' => 'Monuments populars',
	'view-province' => 'Vista per província',
	'id-label' => 'ID del monument:',
	'id-none' => '(cap)',
	'monument-heading' => 'Monument',
	'count-heading' => 'Fotografies',
	'bic-list' => 'Llista',
	'bic-gallery' => 'Galeria',
	'gallery-header' => "Imatges del monument amb l'ID $1.",
	'wall-of-shame-text' => 'Autors pel nombre de fotografies sense identificar',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Mostra',
	'bic-list-all' => 'Llista completa',
	'unregistered' => 'No registrat',
	'province-heading' => 'Província',
	'province-none' => '(Desconeguda)',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'title' => 'WLM-Dateien',
	'file' => 'Datei',
	'monument-type' => 'Art des Denkmals',
	'monument-id' => 'Kennung des Denkmals',
	'province' => 'Provinz',
	'comarque' => 'Comarque',
	'province-comarque-joiner' => '$1 / $2',
	'competes' => 'Nimmt teil',
	'author' => 'Urheber',
	'upload-time' => 'Hochladezeitpunkt',
	'concursa' => 'Nimmt an WLM teil',
	'no-concursa' => 'Nimmt nicht an WLM teil',
	'not-available' => 'Nicht verfügbar',
	'date-unknown' => 'Unbekannt',
	'total-images' => 'Gesamtzahl an Bildern: $1',
	'view-uncategorized-images' => 'Nicht kategorisierte Bilder ansehen',
	'provide-id' => 'Die Kennung eines Denkmals angeben, um die für es verfügbaren Daten anzuzeigen',
	'show-images-bad-only' => 'Nur Bilder außerhalb der Listen anzeigen',
	'show-images-all' => 'Alle Bilder anzeigen',
	'search-monuments' => 'Denkmäler suchen',
	'view-frequency' => 'Beliebte Denkmäler',
	'view-ccaa' => 'Nach autonomer Gemeinschaft ansehen',
	'view-province' => 'Nach Provinz ansehen',
	'id-label' => 'Kennung des Denkmals:',
	'id-none' => '(Keine)',
	'monument-heading' => 'Denkmal',
	'count-heading' => 'Fotos',
	'bic-list' => 'Liste',
	'bic-gallery' => 'Galerie',
	'gallery-header' => 'Bilder des Denkmals mit der Kennung $1.',
	'gallery-header-place' => 'Bilder zu Denkmälern aus $1.',
	'wall-of-shame-text' => 'Autoren nach der Anzahl nicht identifizierbarer Fotografien',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Anzeigen',
	'bic-list-all' => 'Vollständige Liste',
	'unregistered' => 'Nicht registriert',
	'province-heading' => 'Provinz',
	'province-none' => '(Unbekannt)',
	'ccaa-heading' => 'CC.AA.',
);

/** Spanish (Español)
 * @author McDutchie
 * @author Platonides
 */
$messages['es'] = array(
	'title' => 'Imágenes de Wiki Loves Monuments',
	'file' => 'Imagen',
	'monument-type' => 'Tipo de monumento',
	'monument-id' => 'Código',
	'province' => 'Provincia',
	'comarque' => 'Comarca',
	'competes' => 'Competición',
	'author' => 'Autor',
	'upload-time' => 'Fecha',
	'concursa' => 'Concursa',
	'no-concursa' => 'No concursa',
	'not-available' => 'No disponible',
	'date-unknown' => 'Desconocida',
	'total-images' => 'Total de imágenes: $1',
	'view-uncategorized-images' => 'Ver imágenes sin categorizar',
	'provide-id' => 'Proporcione el identificador de un monumento para mostrar los datos disponibles sobre el mismo',
	'show-images-bad-only' => 'Mostrar sólo las imágenes con códigos incorrectos',
	'show-images-all' => 'Mostrar todas las imágenes',
	'search-monuments' => 'Buscar monumentos',
	'view-frequency' => 'Monumentos populares',
	'view-ccaa' => 'Ver imágenes por Comunidad Autónoma',
	'view-province' => 'Ver imágenes por provincia',
	'id-label' => 'BIC:',
	'id-none' => '(Sin identificador)',
	'monument-heading' => 'Monumento',
	'count-heading' => 'Fotografías',
	'bic-list' => 'Lista',
	'bic-gallery' => 'Galería',
	'gallery-header' => 'Imágenes del monumento con el registro $1.',
	'gallery-header-place' => 'Imágenes de monumentos de $1.',
	'wall-of-shame-text' => 'Autores por número de fotografías sin identificar',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Mostrar',
	'bic-list-all' => 'Todas',
	'unregistered' => 'Sin registrar',
	'province-heading' => 'Provincia',
	'province-none' => '(Desconocida)',
	'ccaa-heading' => 'CC.AA.',
);

/** French (Français)
 * @author Od1n
 */
$messages['fr'] = array(
	'file' => 'Image',
	'author' => 'Auteur',
	'monument-heading' => 'Monument',
	'count-heading' => 'Photographies',
	'bic-list' => 'Liste',
	'bic-gallery' => 'Galerie',
	'author-heading' => 'Auteur',
	'bic-list-all' => 'Liste complète',
);

/** Galician (Galego)
 * @author Elisardojm
 * @author Toliño
 */
$messages['gl'] = array(
	'title' => 'Ficheiros de WLM',
	'file' => 'Ficheiro',
	'monument-type' => 'Tipo de monumento',
	'monument-id' => 'Identificador do monumento',
	'province' => 'Provincia',
	'competes' => 'Competición',
	'author' => 'Autor',
	'upload-time' => 'Data da carga',
	'concursa' => 'Participa en WLM',
	'no-concursa' => 'Fóra da competición de WLM',
	'not-available' => 'Non dispoñible',
	'date-unknown' => 'Descoñecido',
	'total-images' => 'Total de imaxes: $1',
	'view-uncategorized-images' => 'Ver as imaxes sen categoría',
	'provide-id' => 'Indique un número de identificación de monumento para mostrar os datos dispoñibles para ese elemento',
	'show-images-bad-only' => 'Mostrar só as imaxes fóra das listas',
	'show-images-all' => 'Mostrar todas as imaxes',
	'search-monuments' => 'Buscar monumentos',
	'view-frequency' => 'Monumentos populares',
	'view-ccaa' => 'Ver por comunidade autónoma',
	'view-province' => 'Ver por provincia',
	'id-label' => 'Identificador do monumento:',
	'id-none' => '(Ningún)',
	'monument-heading' => 'Monumento',
	'count-heading' => 'Fotografías',
	'bic-list' => 'Lista',
	'bic-gallery' => 'Galería',
	'gallery-header' => 'Imaxes para o monumento co identificador $1.',
	'gallery-header-place' => 'Imaxes dos monumentos de $1.',
	'wall-of-shame-text' => 'Autores por número de fotos sen identificar',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Mostrar',
	'bic-list-all' => 'Lista completa',
	'unregistered' => 'Non rexistrado',
	'province-heading' => 'Provincia',
	'province-none' => '(Descoñecida)',
	'ccaa-heading' => 'CC.AA.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'title' => 'קובצי WLM',
	'file' => 'תמונה',
	'monument-type' => 'סוג האתר',
	'monument-id' => 'מזהה האתר',
	'province' => 'מחוז',
	'competes' => 'מתחרה',
	'author' => 'יוצר',
	'upload-time' => 'זמן ההעלאה',
	'concursa' => 'משתתף ב־WLM',
	'no-concursa' => 'מחוץ לתחרות WLM',
	'not-available' => 'אינו זמין',
	'date-unknown' => 'אינו ידוע',
	'total-images' => 'תמנוות בסך הכול: $1',
	'view-uncategorized-images' => 'הצגת תמונות ללא קטגוריה',
	'provide-id' => 'נא להזין מזהה אתר כדי להציג את הנתונים הזמינים לפריט הזה',
	'show-images-bad-only' => 'להציג רק תמונות מחוץ לרשימות',
	'show-images-all' => 'להציג את כל התמונות',
	'search-monuments' => 'לחפש אתרים',
	'view-frequency' => 'אתרים פופולריים',
	'view-province' => 'להציג לפי מחוז',
	'id-label' => 'מזהה אתר:',
	'id-none' => '(אין)',
	'monument-heading' => 'אתר',
	'count-heading' => 'צילומים',
	'bic-list' => 'רשימה',
	'bic-gallery' => 'גלריה',
	'gallery-header' => 'תמונות עבור האתר עם המזהה $1.',
	'wall-of-shame-text' => 'יוצרים לפי מספר הצילומים הלא־מזוהים',
	'author-heading' => 'יוצר',
	'bic-list-bad' => 'הצגה',
	'bic-list-all' => 'רשימה מלאה',
	'unregistered' => 'לא רשום',
	'province-heading' => 'מחוז',
	'province-none' => '(אינו ידוע)',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'title' => 'Files de WLM',
	'file' => 'Imagine',
	'monument-type' => 'Typo de monumento',
	'monument-id' => 'ID del monumento',
	'province' => 'Provincia',
	'competes' => 'In competition',
	'author' => 'Autor',
	'upload-time' => 'Hora de incargamento',
	'concursa' => 'Participa in WLM',
	'no-concursa' => 'Non participa in WLM',
	'not-available' => 'Non disponibile',
	'date-unknown' => 'Incognite',
	'total-images' => 'Total de imagines: $1',
	'view-uncategorized-images' => 'Vider imagines sin categoria',
	'provide-id' => 'Specifica le identificator de un monumento pro monstrar le datos disponibile super illo',
	'show-images-bad-only' => 'Monstrar solmente imagines foras del listas',
	'show-images-all' => 'Monstrar tote le imagines',
	'search-monuments' => 'Cercar monumentos',
	'view-frequency' => 'Monumentos popular',
	'view-ccaa' => 'Gruppar per communitate autonome',
	'view-province' => 'Gruppar per provincia',
	'id-label' => 'ID de monumento:',
	'id-none' => '(Nulle)',
	'monument-heading' => 'Monumento',
	'count-heading' => 'Photographias',
	'bic-list' => 'Lista',
	'bic-gallery' => 'Galeria',
	'gallery-header' => 'Imagines con le monumento con ID $1.',
	'gallery-header-place' => 'Imagines de monumentos ex $1.',
	'wall-of-shame-text' => 'Autores per numero de photographias sin identification',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Monstrar',
	'bic-list-all' => 'Lista complete',
	'unregistered' => 'Non registrate',
	'province-heading' => 'Provincia',
	'province-none' => '(Incognite)',
	'ccaa-heading' => 'CC.AA.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Aldnonymous
 */
$messages['id'] = array(
	'title' => 'file WLM',
	'file' => 'Gambar',
	'monument-type' => 'Jenis monumen',
	'monument-id' => 'Monumen id',
	'province' => 'Provinsi',
	'competes' => 'Bersaing',
	'author' => 'Penulis',
	'upload-time' => 'Waktu unggah',
	'concursa' => 'Mengambil bagian dalam WLM',
	'no-concursa' => 'Diluar kompetisi WLM',
	'not-available' => 'Tidak tersedia',
	'date-unknown' => 'Tidak diketahui',
	'total-images' => 'Total gambar: $1',
	'view-uncategorized-images' => 'Lihat gambar yang tidak berkategori',
	'provide-id' => 'Berikan id monumen untuk menunjukan data yang tersedia untuk benda itu',
	'show-images-bad-only' => 'Hanya tunjukan gambar diluar daftar',
	'show-images-all' => 'Tunjukan semua gambar',
	'search-monuments' => 'Cari monumen',
	'view-frequency' => 'Monumen populer',
	'view-province' => 'Lihat berdasarkan provinsi',
	'id-label' => 'Monumen id:',
	'id-none' => '(Tidak ada)',
	'monument-heading' => 'Monumen',
	'count-heading' => 'foto',
	'bic-list' => 'Daftar',
	'bic-gallery' => 'Galeri',
	'gallery-header' => 'Gambar untuk monumen dengan id $1',
	'wall-of-shame-text' => 'Pembuat dengan jumlah foto tak dikenal',
	'author-heading' => 'Pembuat',
	'bic-list-bad' => 'Tampilkan',
	'bic-list-all' => 'Daftar berkas',
	'unregistered' => 'Tidak terdaftar',
	'province-heading' => 'Provinsi',
	'province-none' => '(Tidak diketahui)',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'title' => 'Dateije vum Projäk <abbr title="Wiki Loves Monuments - et Wiki hät de Dänkmöhler leev">WLM</abbr>',
	'file' => 'Beld',
	'monument-type' => 'De Zoot Dänkmohl',
	'monument-id' => 'Dem Dänkmohl sing Kännong',
	'province' => 'Provinz',
	'competes' => 'Määt met',
	'author' => 'Urhävver',
	'upload-time' => 'Huhjelaade (<abbr title="ußjedröck en de Summerzick vun Meddel-Europa">MESZ</abbr>)',
	'concursa' => 'Määt met bei <abbr title="Wiki Loves Monuments - et Wiki hät de Dänkmöhler leev">WLM</abbr>',
	'no-concursa' => 'Määt nit bei <abbr title="Wiki Loves Monuments - et Wiki hät de Dänkmöhler leev">WLM</abbr> met',
	'not-available' => 'Ham_mer nit',
	'date-unknown' => 'Onbikannt',
	'total-images' => '{{PLURAL:$1|Ei Beld|$1 Belder|kei Beld}} ensjesamp',
	'view-uncategorized-images' => 'Donn de Belder der ohne Saachjroppe beloore',
	'provide-id' => 'Jivv en Kännong för e Dänkmohl aan, öm Aanjabe övver dat Dänkmohl ze sinn ze krijje',
	'show-images-bad-only' => 'Zeish bloß de Belder, ävver ußerhallef vun de Leßte',
	'show-images-all' => 'Donn all de Belder aanzeije',
	'search-monuments' => 'Dänkmöhler söhke',
	'view-frequency' => 'Joot jelidde Dänkmöhler ',
	'view-province' => 'Noh Provinß zoteet',
	'id-label' => 'Dem Dänkmohl sing Kännong:',
	'id-none' => '(Kei)',
	'monument-heading' => 'Däm Dänkmohl sing Kännong',
	'count-heading' => 'Fottos',
	'bic-list' => 'Leß',
	'bic-gallery' => 'Belder_Jallerieh',
	'gallery-header' => 'De Belder för dat Dänkmohl met dä Kännong: $1.',
	'wall-of-shame-text' => 'Huhlaader zoteet noh de Aanzahl Belder, woh mer nit weiß, wat drobb es',
	'author-heading' => 'Dä Fotojraf udder Maacher',
	'bic-list-bad' => 'Zeisch aan!',
	'bic-list-all' => 'De kumplätte Leß',
	'unregistered' => 'Nit aanjemälldt',
	'province-heading' => 'Provinß',
	'province-none' => '(Onbikannt)',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'title' => 'WLM-Fichieren',
	'file' => 'Fichier',
	'monument-type' => 'Type vu Monument',
	'monument-id' => 'ID vum Monument',
	'province' => 'Provënz',
	'competes' => 'Partizipéiert',
	'author' => 'Auteur',
	'upload-time' => 'Zäitpunkt vum Eroplueden',
	'concursa' => 'mécht bäi WLM mat',
	'no-concursa' => 'Mécht net beim WLM-Concours mat',
	'not-available' => 'Net disponibel',
	'date-unknown' => 'Onbekannt',
	'total-images' => 'Zuel vu Biller: $1',
	'view-uncategorized-images' => 'Net kategoriséiert Biller weisen',
	'provide-id' => "D'Id vun engem Monument ugi fir d'Donnéeën dovun ze gesinn",
	'show-images-bad-only' => 'Nëmme Biller weisen déi op kenger Lëscht stinn',
	'show-images-all' => 'All Biller weisen',
	'search-monuments' => 'Monumenter sichen',
	'view-frequency' => 'Beléifte Monumenter',
	'view-province' => '
Pro Provënz weisen',
	'id-label' => 'ID vum Monument:',
	'id-none' => '(Keng)',
	'monument-heading' => 'Monument',
	'count-heading' => 'Photographen',
	'bic-list' => 'Lëscht',
	'bic-gallery' => 'Galerie',
	'gallery-header' => "Biller fir d'Monument mat der Id $1.",
	'wall-of-shame-text' => 'Auteuren no der Zuel vun den net identifizéierte Fotografen',
	'author-heading' => 'Auteur',
	'bic-list-bad' => 'Weisen',
	'bic-list-all' => 'Komplett Lëscht',
	'unregistered' => 'Net registréiert',
	'province-heading' => 'Provënz',
	'province-none' => '(Onbekannt)',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'title' => 'WLM-податотеки',
	'file' => 'Податотека',
	'monument-type' => 'Тип на споменик',
	'monument-id' => 'Назнака на споменикот',
	'province' => 'Покраина',
	'competes' => 'Конкурира',
	'author' => 'Автор',
	'upload-time' => 'Време на подигањето',
	'concursa' => 'Учествува во WLM',
	'no-concursa' => 'Надвор од конкурсот на WLM',
	'not-available' => 'Недостапно',
	'date-unknown' => 'Непознат',
	'total-images' => 'Вкупно слики: $1',
	'view-uncategorized-images' => 'Некатегоризирани слики',
	'provide-id' => 'Наведете назнака на споменикот за да ги добиете расположивите податоци за тој објект',
	'show-images-bad-only' => 'Прикажи само слики вон списоците',
	'show-images-all' => 'Сите слики',
	'search-monuments' => 'Пребарување на споменици',
	'view-frequency' => 'Популарни споменици',
	'view-ccaa' => 'Прегл. по автономни заедници',
	'view-province' => 'По покраина',
	'id-label' => 'Назнака на споменикот:',
	'date-format' => 'j F Y, H:i ч. и s сек.',
	'id-none' => '(Нема)',
	'monument-heading' => 'Споменик',
	'count-heading' => 'Фотографии',
	'bic-list' => 'Список',
	'bic-gallery' => 'Галерија',
	'gallery-header' => 'Слики на споменикот со назнака $1.',
	'gallery-header-place' => 'Слики на знаменитости од $1.',
	'wall-of-shame-text' => 'Автори по број на непрепознаени фотографии',
	'author-heading' => 'Автор',
	'bic-list-bad' => 'Прикажи',
	'bic-list-all' => 'Полн список',
	'unregistered' => 'Нерегистрирани',
	'province-heading' => 'Покраина',
	'province-none' => '(Непозната)',
	'ccaa-heading' => 'CC.AA.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'title' => 'Fail WLM',
	'file' => 'Fail',
	'monument-type' => 'Jenis monumen',
	'monument-id' => 'Id monumen',
	'province' => 'Wilayah',
	'competes' => 'Pertandingan',
	'author' => 'Pengarang',
	'upload-time' => 'Waktu muat naik',
	'concursa' => 'Menyertai WLM',
	'no-concursa' => 'Di luar pertandingan WLM',
	'not-available' => 'Tiada',
	'date-unknown' => 'Tidak diketahui',
	'total-images' => 'Jumlah imej: $1',
	'view-uncategorized-images' => 'Lihat imej yang belum dikategorikan',
	'provide-id' => 'Nyatakan id monumen untuk menunjukkan data yang ada untuk item itu',
	'show-images-bad-only' => 'Tunjukkan imej di luar senarai sahaja',
	'show-images-all' => 'Tunjukkan semua imej',
	'search-monuments' => 'Cari monumen',
	'view-frequency' => '(Tiada)',
	'view-ccaa' => 'Lihat mengikut komuniti autonomi',
	'view-province' => 'Lihat mengikut wilayah',
	'id-label' => 'Monumen',
	'id-none' => '(Tiada)',
	'monument-heading' => 'Monumen',
	'count-heading' => 'Gambar',
	'bic-list' => 'Senarai',
	'bic-gallery' => 'Galeri',
	'gallery-header' => 'Imej monumen id $1.',
	'gallery-header-place' => 'Imej untuk monumen dari $1.',
	'wall-of-shame-text' => 'Pengarang mengikut bilangan gambar yang tidak dikenal pasti',
	'author-heading' => 'Pengarang',
	'bic-list-bad' => 'Tunjukkan',
	'bic-list-all' => 'Senarai penuh',
	'unregistered' => 'Tidak berdaftar',
	'province-heading' => 'Wilayah',
	'province-none' => '(Tidak diketahui)',
	'ccaa-heading' => 'CC.AA.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'title' => 'WLM-bestanden',
	'file' => 'Bestand',
	'monument-type' => 'Monumenttype',
	'monument-id' => 'Monument-ID',
	'province' => 'Provincie',
	'competes' => 'In wedstrijd',
	'author' => 'Auteur',
	'upload-time' => 'Uploadtijd',
	'concursa' => 'Neemt deel aan WLM',
	'no-concursa' => 'Buiten WLM-wedstrijd',
	'not-available' => 'Niet beschikbaar',
	'date-unknown' => 'Onbekend',
	'total-images' => 'Totaal aantal afbeeldingen: $1',
	'view-uncategorized-images' => 'Afbeeldingen zonder categorieën bekijken',
	'provide-id' => 'Geef een monument-ID op om de beschikbare gegevens ervoor te bekijken',
	'show-images-bad-only' => 'Alleen afbeeldingen buiten de lijsten weergeven',
	'show-images-all' => 'Alle afbeeldingen weergeven',
	'search-monuments' => 'Monumenten zoeken',
	'view-frequency' => 'Populaire monumenten',
	'view-province' => 'Per provincie bekijken',
	'id-label' => 'Monument-ID:',
	'id-none' => '(Geen)',
	'monument-heading' => 'Monument',
	'count-heading' => 'Afbeeldingen',
	'bic-list' => 'Lijst',
	'bic-gallery' => 'Galerij',
	'gallery-header' => 'Afbeeldingen voor het monument met ID $1.',
	'wall-of-shame-text' => 'Auteurs op aantal ongeïdentificeerde afbeeldingen',
	'author-heading' => 'Auteur',
	'bic-list-bad' => 'Bekijken',
	'bic-list-all' => 'Volledige lijst',
	'unregistered' => 'Niet geregistreerd',
	'province-heading' => 'Provincie',
	'province-none' => '(Onbekend)',
);

/** Polish (Polski)
 * @author Grzechooo
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'title' => 'Pliki WLM',
	'file' => 'Zdjęcie',
	'monument-type' => 'Typ zabytku',
	'monument-id' => 'Identyfikator zabytku',
	'province' => 'Prowincja',
	'author' => 'Autor',
	'upload-time' => 'Moment przesłania',
	'concursa' => 'Weź udział w WLM',
	'not-available' => 'Niedostępne',
	'date-unknown' => 'Nieznana',
	'view-uncategorized-images' => 'Zobacz zdjęcia bez kategorii',
	'show-images-all' => 'Pokaż wszystkie zdjęcia',
	'search-monuments' => 'Szukaj zabytków',
	'id-none' => '(brak)',
	'monument-heading' => 'Zabytek',
	'count-heading' => 'Fotografie',
	'bic-list' => 'Lista',
	'bic-gallery' => 'Galeria',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Pokaż',
	'bic-list-all' => 'Pełna lista',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'title' => 'Datoteke WLM',
	'file' => 'Slika',
	'monument-type' => 'Vrsta spomenika',
	'monument-id' => 'Id spomenika',
	'province' => 'Provinca',
	'competes' => 'Tekmuje',
	'author' => 'Avtor',
	'upload-time' => 'Čas nalaganja',
	'concursa' => 'Sodeluje v WLM',
	'no-concursa' => 'Zunaj tekmovanja WLM',
	'not-available' => 'Ni na voljo',
	'date-unknown' => 'Neznano',
	'total-images' => 'Skupno slik: $1',
	'view-uncategorized-images' => 'Ogled nekategoriziranih slik',
	'provide-id' => 'Za prikaz podatkov, ki so na voljo za spomenik, navedite njegov id',
	'show-images-bad-only' => 'Prikaži samo slike izven seznamov',
	'show-images-all' => 'Prikaži vse slike',
	'search-monuments' => 'Iskanje spomenikov',
	'view-frequency' => 'Priljubljeni spomeniki',
	'view-province' => 'Ogled po provincah',
	'id-label' => 'Id spomenika:',
	'id-none' => '(Brez)',
	'monument-heading' => 'Spomenik',
	'count-heading' => 'Fotografije',
	'bic-list' => 'Seznam',
	'bic-gallery' => 'Galerija',
	'gallery-header' => 'Slike spomenika z id $1.',
	'wall-of-shame-text' => 'Avtorji po številu neprepoznanih fotografij',
	'author-heading' => 'Avtor',
	'bic-list-bad' => 'Prikaži',
	'bic-list-all' => 'Polni seznam',
	'unregistered' => 'Neregistriran',
	'province-heading' => 'Provinca',
	'province-none' => '(Neznano)',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'title' => 'WLM датотеке',
	'file' => 'Датотека',
	'monument-type' => 'Врста споменика',
	'monument-id' => 'ИБ споменика',
	'province' => 'Покрајина',
	'comarque' => 'Округ',
	'province-comarque-joiner' => '$1 / $2',
	'competes' => 'Такмичи се',
	'author' => 'Аутор',
	'upload-time' => 'Време отпремања',
	'concursa' => 'Учествује у WLM',
	'no-concursa' => 'Ван такмичења WLM',
	'not-available' => 'Недоступно',
	'date-unknown' => 'Непознато',
	'total-images' => 'Укупно слика: $1',
	'view-uncategorized-images' => 'Погледај несврстане слике',
	'provide-id' => 'Наведите ИБ споменика да погледате податке о њему',
	'show-images-bad-only' => 'Прикажи само слике ван спискова',
	'show-images-all' => 'Прикажи све слике',
	'search-monuments' => 'Претрага споменика',
	'view-frequency' => 'Популарни споменици',
	'view-ccaa' => 'Погледај по самосталној заједници',
	'view-province' => 'По покрајини',
	'id-label' => 'ИБ споменика:',
	'date-format' => 'd-m-Y H:i:s',
	'id-none' => '(нема)',
	'monument-heading' => 'Споменик',
	'count-heading' => 'Фотографије',
	'bic-list' => 'Списак',
	'bic-gallery' => 'Галерија',
	'gallery-header' => 'Слике споменика чији је ИБ $1.',
	'gallery-header-place' => 'Слике споменика из $1.',
	'wall-of-shame-text' => 'Аутори по броју непрепознатих фотографија',
	'author-heading' => 'Аутор',
	'bic-list-bad' => 'Прикажи',
	'bic-list-all' => 'Цео списак',
	'unregistered' => 'Неуписани',
	'province-heading' => 'Покрајина',
	'province-none' => '(непозната)',
	'ccaa-heading' => 'CC.AA.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'title' => 'WLM datoteke',
	'file' => 'Datoteka',
	'monument-type' => 'Vrsta spomenika',
	'monument-id' => 'IB spomenika',
	'province' => 'Pokrajina',
	'comarque' => 'Okrug',
	'province-comarque-joiner' => '$1 / $2',
	'competes' => 'Takmiči se',
	'author' => 'Autor',
	'upload-time' => 'Vreme otpremanja',
	'concursa' => 'Učestvuje u WLM',
	'no-concursa' => 'Van takmičenja WLM',
	'not-available' => 'Nedostupno',
	'date-unknown' => 'Nepoznato',
	'total-images' => 'Ukupno slika: $1',
	'view-uncategorized-images' => 'Pogledaj nesvrstane slike',
	'provide-id' => 'Navedite IB spomenika da pogledate podatke o njemu',
	'show-images-bad-only' => 'Prikaži samo slike van spiskova',
	'show-images-all' => 'Prikaži sve slike',
	'search-monuments' => 'Pretraga spomenika',
	'view-frequency' => 'Popularni spomenici',
	'view-ccaa' => 'Pogledaj po samostalnoj zajednici',
	'view-province' => 'Po pokrajini',
	'id-label' => 'IB spomenika:',
	'date-format' => 'd-m-Y H:i:s',
	'id-none' => '(nema)',
	'monument-heading' => 'Spomenik',
	'count-heading' => 'Fotografije',
	'bic-list' => 'Spisak',
	'bic-gallery' => 'Galerija',
	'gallery-header' => 'Slike spomenika čiji je IB $1.',
	'gallery-header-place' => 'Slike spomenika iz $1.',
	'wall-of-shame-text' => 'Autori po broju neprepoznatih fotografija',
	'author-heading' => 'Autor',
	'bic-list-bad' => 'Prikaži',
	'bic-list-all' => 'Ceo spisak',
	'unregistered' => 'Neupisani',
	'province-heading' => 'Pokrajina',
	'province-none' => '(nepoznata)',
	'ccaa-heading' => 'CC.AA.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'not-available' => 'అందుబాటులో లేదు',
	'bic-list' => 'జాబితా',
);

/** Turkish (Türkçe)
 * @author Emperyan
 */
$messages['tr'] = array(
	'file' => 'Resim',
	'author' => 'Üreten',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'title' => 'Tập tin WLM',
	'file' => 'Tập tin',
	'monument-type' => 'Loại đài tưởng niệm',
	'monument-id' => 'ID của đài tưởng niệm',
	'province' => 'Tỉnh',
	'competes' => 'Thi đấu',
	'author' => 'Tác giả',
	'upload-time' => 'Lúc tải lên',
	'concursa' => 'Tham gia vào WLM',
	'no-concursa' => 'Ngoài cuộc thi WLM',
	'not-available' => 'Không có sẵn',
	'date-unknown' => 'Không rõ',
	'total-images' => 'Tổng số hình ảnh: $1',
	'view-uncategorized-images' => 'Xem hình ảnh chưa phân loại',
	'provide-id' => 'Nhập ID của đài tưởng niệm để xem dữ liệu có sẵn về đài tưởng niệm đó',
	'show-images-bad-only' => 'Chỉ hiện các hình ngoài các danh sách',
	'show-images-all' => 'Hiện tất cả các hình ảnh',
	'search-monuments' => 'Tìm kiếm đài tưởng niệm',
	'view-frequency' => 'Đài tưởng niệm phổ biến',
	'view-ccaa' => 'Xem theo cộng đồng tự trị',
	'view-province' => 'Xem theo tỉnh',
	'id-label' => 'ID của đài tưởng niệm',
	'id-none' => '(Không có)',
	'monument-heading' => 'Đài tưởng niệm',
	'count-heading' => 'Hình chụp',
	'bic-list' => 'Danh sách',
	'bic-gallery' => 'Album',
	'gallery-header' => 'Hình ảnh của đài tưởng niệm với ID $1.',
	'gallery-header-place' => 'Hình ảnh các đài kỷ niệm tại $1.',
	'wall-of-shame-text' => 'Tác giả theo số hình chụp không được nhận diện',
	'author-heading' => 'Tác giả',
	'bic-list-bad' => 'Xem',
	'bic-list-all' => 'Danh sách đầy đủ',
	'unregistered' => 'Không đăng ký',
	'province-heading' => 'Tỉnh',
	'province-none' => '(Không rõ)',
	'ccaa-heading' => 'CĐTT',
);

