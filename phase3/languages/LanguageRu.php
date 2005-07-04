<?php
/** Russian (русский язык)
  *
  * Based on Language.php 1.600
  *
  * @package MediaWiki
  * @subpackage Language
  */

require_once( 'LanguageUtf8.php' );

if($wgMetaNamespace === FALSE)
        $wgMetaNamespace = str_replace( ' ', '_', $wgSitename );


/* private */ $wgNamespaceNamesRu = array(
        NS_MEDIA            => 'Медиа',
        NS_SPECIAL          => 'Служебная',
        NS_MAIN             => '',
        NS_TALK             => 'Обсуждение',
        NS_USER             => 'Участник',
        NS_USER_TALK        => 'Обсуждение_участника',
        NS_PROJECT          => $wgMetaNamespace,
        NS_PROJECT_TALK     => FALSE,  #Set in constructor
        NS_IMAGE            => 'Изображение',
        NS_IMAGE_TALK       => 'Обсуждение_изображения',
        NS_MEDIAWIKI        => 'MediaWiki',
        NS_MEDIAWIKI_TALK   => 'Обсуждение_MediaWiki',
        NS_TEMPLATE         => 'Шаблон',
        NS_TEMPLATE_TALK    => 'Обсуждение_шаблона',
        NS_HELP             => 'Справка',
        NS_HELP_TALK        => 'Обсуждение_справки',
        NS_CATEGORY         => 'Категория',
        NS_CATEGORY_TALK    => 'Обсуждение_категории',
) + $wgNamespaceNamesEn;

if(isset($wgExtraNamespaces)) {
        $wgNamespaceNamesRu=$wgNamespaceNamesRu+$wgExtraNamespaces;
}

/* private */ $wgQuickbarSettingsRu = array(
        'Не показывать', 'Неподвижная слева', 'Неподвижная справа', 'Плавающая слева'
);

/* private */ $wgSkinNamesRu = array(
        'standard' => 'Стандартный',
        'nostalgia' => 'Ностальгия',
        'cologneblue' => 'Кёльнская тоска',
        'davinci' => 'Да Винчи',
        'mono' => 'Моно',
        'monobook' => 'Моно-книга',
        'myskin' => 'Своё',
        'chick' => 'Цыпа'
);


/* private */ $wgBookstoreListRu = array(
        'ОЗОН' => 'http://www.ozon.ru/?context=advsearch_book&isbn=$1',
        'Books.Ru' => 'http://www.books.ru/shop/search/advanced?as%5Btype%5D=books&as%5Bname%5D=&as%5Bisbn%5D=$1&as%5Bauthor%5D=&as%5Bmaker%5D=&as%5Bcontents%5D=&as%5Binfo%5D=&as%5Bdate_after%5D=&as%5Bdate_before%5D=&as%5Bprice_less%5D=&as%5Bprice_more%5D=&as%5Bstrict%5D=%E4%E0&as%5Bsub%5D=%E8%F1%EA%E0%F2%FC&x=22&y=8',
        'Яндекс.Маркет' => 'http://market.yandex.ru/search.xml?text=$1',
        'Amazon.com' => 'http://www.amazon.com/exec/obidos/ISBN=$1'
);

/* private */ $wgValidSpecialPagesRu = array(
  'Userlogin'           => '',
  'Userlogout'          => '',
  'Preferences'         => 'Ваши настройки',
  'Watchlist'           => 'Ваш список наблюдения',
  'Recentchanges'       => 'Свежие правки',
  'Upload'              => 'Загрузить файл',
  'Imagelist'           => 'Список изображений',
  'Listusers'           => 'Зарегистрированные  участники',
  'Statistics'          => 'Статистика',
  'Randompage'          => 'Случайная статья',

  'Lonelypages'         => 'Статьи-сироты',
  'Unusedimages'        => 'Изображения-сироты',
  'Popularpages'        => 'Популярные статьи',
  'Wantedpages'         => 'Требуемые статьи',
  'Shortpages'          => 'Короткие статьи',
  'Longpages'           => 'Длинные статьи',
  'Newpages'            => 'Новые статьи',
  'Ancientpages'        => 'Самые старые статьи',
  'Allpages'            => 'Все страницы по алфавиту',

  'Ipblocklist'         => 'Заблокированные IP-адреса',
  'Maintenance'         => 'Подсобная страница',
  'Specialpages'        => '',
  'Contributions'       => '',
  'Movepage'            => '',
  'Emailuser'           => '',
  'Whatlinkshere'       => '',
  'Recentchangeslinked' => '',
  'Booksources'         => 'Где искать книги',
  'Categories'          => 'Категории',
  'Export'              => 'Экспорт в XML',
  'Version'                     => 'Версия',
);

/* private */ $wgSysopSpecialPagesRu = array(
        'Blockip'               => 'Заблокировать IP-адрес',
        'Asksql'                => 'Сделать запрос к базе данных',
        'Undelete'              => 'Посмотреть и восстановить стёртые страницы'
);

/* private */ $wgDeveloperSpecialPagesRu = array(
        'Lockdb'                => 'Сделать базу данных доступной только для чтения',
        'Unlockdb'              => 'Восстановить возможность записи в базу данных',
);

# Note to translators:
#   Please include the English words as synonyms.  This allows people
#   from other wikis to contribute more easily.
#
/* private */ $wgMagicWordsRu = array(
#   ID                                 CASE  SYNONYMS
        MAG_REDIRECT             => array( 0,    '#redirect', '#перенаправление', '#перенапр'),
        MAG_NOTOC                => array( 0,    '__NOTOC__', '__БЕЗСОДЕРЖАНИЯ__'),
        MAG_FORCETOC             => array( 0,    '__FORCETOC__'),
        MAG_TOC                  => array( 0,    '__TOC__', '__СОДЕРЖАНИЕ__'),
        MAG_NOEDITSECTION        => array( 0,    '__NOEDITSECTION__', '__БЕЗРЕДАКТИРОВАНИЯРАЗДЕЛА__'),
        MAG_START                => array( 0,    '__START__', '__НАЧАЛО__'),
        MAG_CURRENTMONTH         => array( 1,    'CURRENTMONTH', 'ТЕКУЩИЙМЕСЯЦ'),
        MAG_CURRENTMONTHNAME     => array( 1,    'CURRENTMONTHNAME','НАЗВАНИЕТЕКУЩЕГОМЕСЯЦА'),
        MAG_CURRENTMONTHNAMEGEN  => array( 1,    'CURRENTMONTHNAMEGEN','НАЗВАНИЕТЕКУЩЕГОМЕСЯЦАРОД'),
        MAG_CURRENTMONTHABBREV   => array( 1,    'CURRENTMONTHABBREV', 'НАЗВАНИЕТЕКУЩЕГОМЕСЯЦААБР'),
        MAG_CURRENTDAY           => array( 1,    'CURRENTDAY','ТЕКУЩИЙДЕНЬ'),
        MAG_CURRENTDAYNAME       => array( 1,    'CURRENTDAYNAME','НАЗВАНИЕТЕКУЩЕГОДНЯ'),
        MAG_CURRENTYEAR          => array( 1,    'CURRENTYEAR','ТЕКУЩИЙГОД'),
        MAG_CURRENTTIME          => array( 1,    'CURRENTTIME','ТЕКУЩЕЕВРЕМЯ'),
        MAG_NUMBEROFARTICLES     => array( 1,    'NUMBEROFARTICLES','КОЛИЧЕСТВОСТАТЕЙ'),
        MAG_NUMBEROFFILES        => array( 1,    'NUMBEROFFILES', 'КОЛИЧЕСТВОФАЛОВ'),
        MAG_PAGENAME             => array( 1,    'PAGENAME','НАЗВАНИЕСТРАНИЦЫ'),
        MAG_PAGENAMEE            => array( 1,    'PAGENAMEE','НАЗВАНИЕСТРАНИЦЫ2'),
        MAG_NAMESPACE            => array( 1,    'NAMESPACE','ПРОСТРАНСТВОИМЁН'),
        MAG_MSG                  => array( 0,    'MSG:'),
        MAG_SUBST                => array( 0,    'SUBST:','ПОДСТ:'),
        MAG_MSGNW                => array( 0,    'MSGNW:'),
        MAG_END                  => array( 0,    '__END__','__КОНЕЦ__'),
        MAG_IMG_THUMBNAIL        => array( 1,    'thumbnail', 'thumb', 'мини'),
        MAG_IMG_RIGHT            => array( 1,    'right','справа'),
        MAG_IMG_LEFT             => array( 1,    'left','слева'),
        MAG_IMG_NONE             => array( 1,    'none'),
        MAG_IMG_WIDTH            => array( 1,    '$1px','$1пкс'),
        MAG_IMG_CENTER           => array( 1,    'center', 'centre','центр'),
        MAG_IMG_FRAMED           => array( 1,    'framed', 'enframed', 'frame','обрамить'),
        MAG_INT                  => array( 0,    'INT:'),
        MAG_SITENAME             => array( 1,    'SITENAME','НАЗВАНИЕСАЙТА'),
        MAG_NS                   => array( 0,    'NS:','ПИ:'),
        MAG_LOCALURL             => array( 0,    'LOCALURL:'),
        MAG_LOCALURLE            => array( 0,    'LOCALURLE:'),
        MAG_SERVER               => array( 0,    'SERVER','СЕРВЕР'),
        MAG_SERVERNAME           => array( 0,    'SERVERNAME', 'НАЗВАНИЕСЕРВЕРА'),
        MAG_SCRIPTPATH           => array( 0,    'SCRIPTPATH', 'ПУТЬКСКРИПТУ'),
        MAG_GRAMMAR              => array( 0,    'GRAMMAR:'),
        MAG_NOTITLECONVERT       => array( 0,    '__NOTITLECONVERT__', '__NOTC__', '__БЕЗПРЕОБРАЗОВАНИЯЗАГОЛОВКА__'),
        MAG_NOCONTENTCONVERT     => array( 0,    '__NOCONTENTCONVERT__', '__NOCC__', '__БЕЗПРЕОБРАЗОВАНИЯТЕКСТА__'),
        MAG_CURRENTWEEK          => array( 1,    'CURRENTWEEK','ТЕКУЩАЯНЕДЕЛЯ'),
        MAG_CURRENTDOW           => array( 1,    'CURRENTDOW','ТЕКУЩИЙДЕНЬНЕДЕЛИ'),
        MAG_REVISIONID           => array( 1,    'REVISIONID', 'ИДВЕРСИИ'),
);

/* private */ $wgAllMessagesRu = array(

# User preference toggles 
'tog-underline' => 'Подчёркивать ссылки',
'tog-highlightbroken' => 'Показывать несуществующие ссылки <a href=\"\" class=\"new\">вот так</a> (иначе вот так<a href=\"\" class=\"internal\">?</a>).',
'tog-justify'   => 'Выравнивать текст по ширине страницы',
'tog-hideminor' => 'Скрывать малозначимые правки в списке свежих изменений',
'tog-usenewrc' => 'Улучшенный список свежих изменений (JavaScript)',
'tog-numberheadings' => 'Автоматически нумеровать заголовки',
'tog-showtoolbar'               => 'Показывать панель инструментов при редактировании (JavaScript)',
'tog-editondblclick' => 'Править статьи по двойному щелчку (JavaScript)',
'tog-editsection'               => 'Показывать ссылку «править» для каждой секции',
'tog-editsectiononrightclick'   => 'Править секции при правом щелчке мышью на заголовке (JavaScript)',
'tog-showtoc'                   => 'Показывать оглавление (для страниц более чем с 3 заголовками)',
'tog-rememberpassword' => 'Запоминать пароль между сеансами',
'tog-editwidth' => 'Поле редактирования во всю ширину окна обозревателя',
'tog-watchdefault' => 'По умолчанию добавлять новые и изменённые статьи в список наблюдения',
'tog-minordefault' => 'По умолчанию помечать изменения как малозначимые',
'tog-previewontop' => 'Показывать предпросмотр статьи до окна редактирования',
'tog-previewonfirst' => 'Показывать предварительный просмотр по первому изменению',
'tog-nocache' => 'Запретить кеширование страниц',
'tog-enotifwatchlistpages'      => 'Уведомлять по эл. почте об изменениях страниц',
'tog-enotifusertalkpages'       => 'Уведомлять по эл. почте об изменении персональной страницы обсуждения',
'tog-enotifminoredits'          => 'Уведомлять по эл. почте даже при малозначительных изменениях',
'tog-enotifrevealaddr'          => 'Показывать мой почтовый адрес в сообщениях оповещения',
'tog-shownumberswatching'       => 'Показывать число участников, включивших страницу в свой список наблюдения',
'tog-showupdated'               => 'Показывать метку обновления',
'tog-fancysig' => 'Простая подпись (без автоматической ссылки)',
'tog-externaleditor' => 'Использовать по умолчанию внешний редактор',
'tog-externaldiff' => 'Использовать по умолчанию внешную программу сравнения версий',

# dates
'sunday' => 'Воскресенье',
'monday' => 'Понедельник',
'tuesday' => 'Вторник',
'wednesday' => 'Среда',
'thursday' => 'Четверг',
'friday' => 'Пятница',
'saturday' => 'Суббота',
'january' => 'января',
'february' => 'февраля',
'march' => 'марта',
'april' => 'апреля',
'may_long' => 'мая',
'june' => 'июня',
'july' => 'июля',
'august' => 'августа',
'september' => 'сентября',
'october' => 'октября',
'november' => 'ноября',
'december' => 'декабря',
'jan' => 'янв',
'feb' => 'фев',
'mar' => 'мар',
'apr' => 'апр',
'may' => 'май',
'jun' => 'июн',
'jul' => 'июл',
'aug' => 'авг',
'sep' => 'сен',
'oct' => 'окт',
'nov' => 'ноя',
'dec' => 'дек',
# Bits of text used by many pages:
#
'categories' => 'Категории',
'category' => 'категория',
'category_header' => 'Статьи в категории «$1»',
'subcategories' => 'Подкатегории',


'linktrail'             => '/^((?:[a-z]|а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я)+)(.*)$/sD', 
'mainpage'              => 'Заглавная страница',
'mainpagetext'  => 'Програмное обеспечение вики-проекта успешно установлено.',
"mainpagedocfooter" => "См. [http://meta.wikipedia.org/wiki/MediaWiki_i18n documentation on customizing the interface]
и [http://meta.wikipedia.org/wiki/MediaWiki_User%27s_Guide User's Guide] по использованию и настройке справочной системы.",

'portal'                => 'Сообщество',
'portal-url'            => "{{ns:project}}:Портал сообщества",
'about'                 => 'Описание',
'aboutsite'      => 'Описание {{grammar:genitive|{{SITENAME}}}}',
'aboutpage'           => '{{ns:project}}:Описание',
'article' => 'Статья',
'help'                  => 'Справка',
'helppage'            => '{{ns:project}}:Справка',
'wikititlesuffix' => '{{SITENAME}}',
'bugreports'  => 'Отчёт об ошибке',
'bugreportspage' => '{{ns:project}}:Отчёт об ошибке',
'sitesupport'   => 'Пожертвования', # To enable, something like 'Donations', '-' to disable
'sitesupport-url' => "{{ns:project}}:Пожертвования",
'faq'                   => 'Ответы на вопросы',
'faqpage'             => '{{ns:project}}:Ответы на вопросы',
'edithelp'            => 'Справка по редактированию',
'newwindow'           => '(в новом окне)',
'edithelppage'        => '{{ns:project}}:Справка по редактированию',
'cancel'                => 'Отменить',
'qbfind'                => 'Поиск',
'qbbrowse'              => 'Просмотреть',
'qbedit'                => 'Править',
'qbpageoptions' => 'Настройки страницы',
'qbpageinfo'    => 'Сведения о статье',
'qbmyoptions'   => 'Ваши настройки',
'qbspecialpages'        => 'Специальные страницы',
'moredotdotdot' => 'Далее…',
'mypage'                => 'Ваша личная страница',
'mytalk'                => 'Ваше личное обсуждение',
'anontalk'              => 'Обсуждение для этого IP-адреса',
'navigation' => 'Навигация',

# Metadata in edit box
'metadata' => '<strong>Метаданные</strong> (подробности смотри <a href="$1">здесь</a>)',
'metadata_page' => "{{ns:project}}:Метаданные",

'currentevents' => 'Текущие события',
'currentevents-url' => 'Текущие события',

'disclaimers' => 'Отказ от ответственности',
'disclaimerpage' => "{{ns:project}}:Отказ от ответственности",
'errorpagetitle' => "Ошибка",
'returnto'            => "Возврат к странице $1.",
'tagline'             => "Материал из {{grammar:genitive|{{SITENAME}}}}.",
'whatlinkshere' => 'Ссылки сюда',
'help'                  => 'Справка',
'search'                => 'Поиск',
'go'            => 'Перейти',
"history"             => 'История',
'history_short' => 'История',
'info_short'    => 'Информация',
'printableversion' => 'Отобразить для печати',
'print' => 'Печать',
'edit' => 'Править',
'editthispage'  => 'Править эту статью',
'delete' => 'Удалить',
'deletethispage' => 'Стереть её',
'undelete_short' => 'Восстановить $1 правок',
'undelete_short1' => 'Восстановить одну правку',
'protect' => 'Защитить',
'protectthispage' => 'Защитить',
'unprotect' => 'Снять защиту',
'unprotectthispage' => 'Снять защиту',
'newpage' => 'Новая статья',
'talkpage'              => 'Обсудить её',
'specialpage' => 'Служебная страница',
'personaltools' => 'Личные инструменты',
'postcomment'   => 'Комментировать',
'addsection'   => '+',
'articlepage'   => 'Просмотреть статью',
'subjectpage'   => 'Просмотреть тему', # For compatibility
'talk' => 'Обсуждение',
'views' => 'Просмотры',
'toolbox' => 'Инструменты',
'userpage' => 'Просмотреть страницу участника',
'wikipediapage' => 'Просмотреть мета-страницу',
'imagepage' =>       'Просмотреть страницу изображения',
'viewtalkpage' => 'Просмотреть обсуждение',
'otherlanguages' => 'На других языках',
'redirectedfrom' => '(Перенаправлено с $1)',
'lastmodified'  => 'Последнее изменение этой страницы: $1.',
'viewcount'             => 'К этой странице обращались $1 раз(а).',
'copyright'     => 'Содержимое доступно в соответствии с $1.',
'poweredby'     => "{{SITENAME}} работает на [http://www.mediawiki.org/ MediaWiki], открытом вики-движке.",
'printsubtitle' => "(Материал с {{SERVER}})",
'protectedpage' => 'Защищённая статья',

'administrators' => "{{ns:project}}:Администраторы",
'sysoptitle'    => 'Необходим уровень доступа «Оператор»',
'sysoptext'             => "Затребованное вами действие может быть совершено только пользователями со статусом «Оператор» (sysop).
См. $1.",
'developertitle' => 'Необходим уровень доступа «Разработчик»',
'developertext'       => "Затребованное вами действие может быть совершено только пользователями со статусом «Разработчик» (developer).
См. $1.",

'badaccess' => 'Ошибка доступа',
'badaccesstext' => 'Запрошенное вами действие может быть выполнено
только участниками с правами доступа «$2». См. $1.',

'versionrequired' => 'Требуется MediaWiki версии $1',
'versionrequiredtext' => 'Для работы с этой страницей требуется MediaWiki версии $1. См. [[Special:Version]].',

'nbytes'                => '$1 байт(ов)',
'ok'                    => 'OK',
'sitetitle'             => "{{SITENAME}}",
'pagetitle'             => "$1 — {{SITENAME}}",
'sitesubtitle'  => 'Свободная энциклопедия',
'retrievedfrom' => "Получено с $1",
'newmessages' => "Вы получили $1.",
'newmessageslink' => 'новые сообщения',
'editsection'=>'править',
'toc' => 'Содержание',
'showtoc' => 'показать',
'hidetoc' => 'убрать',
'thisisdeleted' => "Просмотреть или восстановить $1?",
'restorelink' => "$1 удаление(й)",
'feedlinks' => 'В виде:',
'sitenotice'    => '-', # the equivalent to wgSiteNotice

# Short words for each namespace, by default used in the 'article' tab in monobook
'nstab-main' => 'Статья',
'nstab-user' => 'Участник',
'nstab-media' => 'Мультимедиа',
'nstab-special' => 'Служебная страница',
'nstab-wp' => 'О проекте',
'nstab-image' => 'Файл',
'nstab-mediawiki' => 'Сообщение MediaWiki',
'nstab-template' => 'Шаблон',
'nstab-help' => 'Справка',
'nstab-category' => 'Категория',

# Main script and global functions
#
'nosuchaction'  => 'Неопознанное действие',
'nosuchactiontext' => 'Действие, указанное в URL, не распознаётся программным обеспечением вики',
'nosuchspecialpage' => 'Такой специальной страницы нет',
'nospecialpagetext' => 'Запрошенной вами служедной страницы не существует. См. [[{{ns:special}}:Specialpages|список служебных страниц]].',

# General errors
#
'error'                 => 'Ошибка',
'databaseerror' => 'Ошибка базы данных',
'dberrortext'   => "Обнаружена ошибка синтаксиса запроса к базе данных.
Последний запрос к базе данных:
<blockquote><tt>$1</tt></blockquote>
произошёл из функции <tt>«$2»</tt>.
MySQL возвратил ошибку <tt>«$3: $4»</tt>.",
'dberrortextcl' => "Обнаружена ошибка синтаксиса запроса к базе данных.
Последний запрос к базе данных:
«$1»
произошёл из функции «$2».
MySQL возвратил ошибку «$3: $4».",
'noconnect'             => 'Извините, сейчас невозможно связаться с сервером базы данных из-за технических проблем.<br />
$1',
'nodb'                  => "Невозможно выбрать базу данных $1",
'cachederror'           => 'Ниже представлена кешированная копия запрошенной страницы; возможно, она устарела.',
'laggedslavemode'   => 'Внимание: страница может не содержать последних обновлений.',
'readonly'              => 'Запись в базу данных заблокирована',
'enterlockreason' => 'Укажите причину и намеченный срок блокировки.',
'readonlytext'  => "Добавление новых статей и другие изменения базы данных сейчас заблокированы: вероятно, в связи с плановым обслуживанием.
Заблокировавший оператор оставил следующее разъяснение:
$1",
'missingarticle' => "База данных не нашла текста статьи, 
хотя должна была найти, по имени «$1».

Обычно это вызвано использованием устаревшей ссылки на журнал изменений или различий для статьи, которая была удалена.

Если дело не в этом, то скорее всего, вы обнаружили ошибку в программном обеспечении вики.
Пожалуйста, сообщите об этом администратору, указав URL.",
'readonly_lag' => "База данных автоматически заблокирована от изменений на время пока вторичный сервер БД не синхронизируется с первичным.",
'internalerror' => 'Внутренняя ошибка',
'filecopyerror' => "Невозможно скопировать файл «$1» в «$2».",
'filerenameerror' => "Невозможно переименовать файл «$1» в «$2».",
'filedeleteerror' => "Невозможно удалить файл «$1».",
'filenotfound'  => "Невозможно найти файл «$1».",
'unexpected'    => "Неподходящее значение: «$1»=«$2».",
'formerror'             => 'Ошибка: невозможно передать данные формы',
'badarticleerror' => 'Это действие не может быть выполнено на данной странице.',
'cannotdelete'  => 'Невозможно удалить указанную страницу или файл. (Возможно, его уже удалил кто-то другой.)',
'badtitle'              => 'Недопустимое название',
'badtitletext' => "Запрашиваемое название статьи неправильно, пусто, либо неправильно указано междуязыковое или между-вики название.",
'perfdisabled' => 'К сожалению, эта возможность временно недоступна в связи с загруженностью серера.',
'perfdisabledsub' => "Это — сохранённая копия от $1:", # obsolete?
'perfcached' => 'Следующие данные взяты из кэша и могут не содержать последних изменений:',
'wrong_wfQuery_params' => "Недопустимые параметры для функции wfQuery()<br />
Функция: $1<br />
Запрос: $2",
'viewsource' => 'Просмотр',
'protectedtext' => "Эта страница заблокирована для предотвращения её изменений. 
Существуют несколько причин по которым это могло быть сделано,
смотрите [[{{ns:project}}:Журнал защиты]] для того чтобы узнать причину, связанную с этой страницей.

Вы можете просмотреть и скопировать исходный код этой страницы:",
'sqlhidden' => '(SQL запрос скрыт)',

# Login and logout pages
#
'logouttitle' => 'Стать инкогнито',
'logouttext'          => "Вы работаете в том же режиме, который был до вашего представления системе. Вы идентифицируетесь не по имени, а по IP-адресу.
Вы можете продолжить участие в проекте анонимно или начать новый сеанс как тот же самый или другой пользователь.\n",

'welcomecreation' => "== Добро пожаловать, $1! ==

Вы были зарегистрированы.
Не забудьте провести [[{{ns:special}}:Preferences|персональную настройку сайта]].",
'loginpagetitle' => 'Представиться системе',
'yourname'              => 'Ваше имя участника',
'yourpassword'  => 'Ваш пароль',
'yourpasswordagain' => 'Повторный набор пароля',
'newusersonly'  => ' (только для новых участников)',
'remembermypassword' => 'Запоминать ваш пароль между сеансами.',
'yourdomainname'       => 'Ваш домен',
'externaldberror'      => 'Произошла ошибка при аутентификации с помощью внешней базы данных, или у вас недостаточно прав для внесения изменений в свою внешнюю учётную запись.',
'loginproblem'  => '<span style=\"color:red\">Участник неопознан.</span>',
'alreadyloggedin' => "<font color=red><strong>Участник $1, вы уже представились системе!</strong></font><br />",

'login'                 => 'Представиться системе',
'loginprompt'           => "Вы должны разрешить «cookies», чтобы представиться системе.",
'userlogin'             => 'Представиться системе',
'logout'                => 'Завершение сеанса',
'userlogout'    => 'Завершение сеанса',
'notloggedin'   => 'Вы не представились системе',
'createaccount' => 'Зарегистрировать нового участника',
'createaccountmail'     => 'по эл. почте',
'badretype'             => 'Введённые вами пароли не совпадают.',
'userexists'    => 'Введённое вами имя участника уже существует. Пожалуйста, выберите другое имя.',
'youremail'             => 'Ваш адрес эл. почты²',
'yourrealname'          => 'Ваше настоящее имя¹',
'yourlanguage'  => 'Язык интерфейса',
'yourvariant'  => 'Вариант языка',
'yournick'              => 'Ваш псевдоним (для подписей)',
'email'                 => 'Эл. почта',
'emailforlost'          => "Поля отмеченные надстрочным индексом необязательны для заполнения. Указав адрес электронной почты, вы позволите другим участникам проекта отправлять вам сообщение через веб-форму. 
Это также поможет вам в случае если вы забудете свой пароль.<br /><br />Ваше настоящее имя будет использовано для подписи ваших работ.",
'prefs-help-email-enotif' => 'Этот адрес также используется для отправки по электронной почте оповещений об изменении страниц если вы активировали соответствующую опцию.',
'prefs-help-realname'   => '¹ Настоящее имя (необязательное поле): если вы укажите его, то оно будет использовано для того чтобы показать кем был внесена правка страницы.',
'loginerror'    => 'Ошибка опознавания участника',
'prefs-help-email'      => '² Электронная почта (необязательное поле): позволяет другим участникам связаться с вами без раскрытия адреса вашей электронной почты, а также может быть использован для напоминания пароля, если вы его забудете.',
'nocookiesnew'  => "Участник зарегистрирован, но не представлен. {{SITENAME}} использует «cookies» для представления участников. У вас «cookies» запрещены. Пожалуйста, разрешите их, а затем преставьтесь с вашим новым именем участника и паролем.",
'nocookieslogin'      => "{{SITENAME}} использует «cookies» для представления участников. Вы их отключили. Пожалуйста, включите их и попробуйте снова.",
'noname'                => 'Вы не указали допустимого имени участника.',
'loginsuccesstitle' => 'Опознавание прошло успешно',
'loginsuccess'  => "Теперь вы работаете под именем $1.",
'nosuchuser'    => "Участника с именем $1 не существует.
Проверьте правильность написания, или воспользуйтесь формой ниже, чтобы зарегистрировать нового участника.",
'nosuchusershort'       => "Не существует участника с именем $1. Проверьте написание имени.",
'wrongpassword'         => 'Введённый вами пароль неверен. Попробуйте ещё раз.',
'mailmypassword'        => 'Выслать новый пароль',
'mailmypasswordauthent' => 'Выслать новый пароль',
'passwordremindertitle' => "Напоминание пароля участника {{grammar:genitive|{{SITENAME}}}}",
'passwordremindertext' => "Кто-то (возможно вы) с IP-адресом $1 запросил,
чтобы мы выслали вам новый пароль участника {{grammar:genitive|{{SITENAME}}}}.
Пароль для участника $2 теперь: <code>$3</code>.
Мы рекомендуем вам представиться системе и поменять пароль.",
'noemail'               => "Для участника с именем $1 электронный адрес указан не был.",
'passwordsent'          => "Новый пароль был выслан на адрес электронной почты, указанный для участника $1.

Пожалуйста, представьтесь системе заново после получения пароля.",
'eauthentsent'          =>  "Временный пароль был отправлен на адрес электронной почты нового участника $1. В письме также описаны действия, которые нужно выполнить, чтобы подтвердить, что этот адрес электронной почты действительно принадлежит вам.",
'loginend'              => ' ',
'mailerror' => "Ошибка при посылке почты: $1",
'acct_creation_throttle_hit' => 'К сожалению, вы уже создали $1 учётных записей. Вы не можете создать больше ни одной.',
'emailauthenticated'    => 'Ваш почтовый адрес был сопоставлен с $1.', 
'emailnotauthenticated' => 'Ваш адрес электронной почты <strong>ещё не был подтверждён</strong>, функции вики-движка по работе с эл. почтой отключены.',
'noemailprefs'          => '<strong>Адрес электронной почты не был указан</strong>, функции вики-движка по работе с эл. почтой отключены.',
'emailconfirmlink' => 'Подтвердить ваш адрес электронной почты',
'invalidemailaddress'   => 'Введённый адрес не может быть принят, т. к. он не соответствует формату адресов электронной почты. Пожалуйста введите корректный адрес или оставьте поле пустым.', 

# Edit page toolbar
'bold_sample'=>'Жирный шрифт',
'bold_tip'=>'Жирный шрифт',
'italic_sample'=>'Курсивный текст',
'italic_tip'=>'Курсивный текст',
'link_sample'=>'Заголовок ссылки',
'link_tip'=>'Внутренняя ссылка',
'extlink_sample'=>'http://www.example.com заголовок ссылки',
'extlink_tip'=>'Внешняя ссылка (помните о префиксе http:// )',
'headline_sample'=>'Текст заголовка',
'headline_tip'=>'Заголовок 2-го уровня',
'math_sample'=>'Вставляйте сюда формулу',
'math_tip'=>'Математическая формула (формат LaTeX)',
'nowiki_sample'=>'Вставляйте сюда неотформатированный текст.',
'nowiki_tip'=>'Не обрабатывать как размеченный текст',
'image_sample'=>'Example.jpg',
'image_tip'=>'Встроенное изображение',
'media_sample'=>'Example.ogg',
'media_tip'=>'Ссылка на медиа-файл',
'sig_tip'=>'Ваша подпись и момент времени',
'hr_tip'=>'Горизонтальная линия (не используйте часто)',
'infobox'=>'Щёлкните по кнопке, чтобы получить текст примера',
# alert box shown in browsers where text selection does not work, test e.g. with mozilla or konqueror
'infobox_alert'=>"Пожалуйста, ввведите текст, который вы хотите отформатировать.\n Он будет показан в инфобоксе для копирования и вставки.\nНапример:\n$1\nстанет:\n$2",

# Edit pages
#
'summary'               => 'Краткое описание изменений',
'subject'               => 'Тема/заголовок',
'minoredit'             => 'Отметить это изменение как незначительное',
'watchthis'             => 'Включить эту страницу в список наблюдения',
'savearticle'   => 'Записать страницу',
'preview'               => 'Предпросмотр',
'showpreview'   => 'Предварительный просмотр страницы',
'showdiff'      => 'Показать изменения',
'blockedtitle'  => 'Участник заблокирован',
'blockedtext'   => "Ваше имя участника или IP-адрес был заблокирован $1.
Утверждается, что причина такова:<br />''$2''<p>Вы можете связаться с $1 или одним из других 
[[{{ns:project}}:Администраторы|администраторов]] чтобы обсудить блокировку.",
'whitelistedittitle' => 'Для изменения требуется авторизаци',
'whitelistedittext' => 'Вы должны [[{{ns:special}}:Userlogin|зарегистрироваться]] для изменения этих страниц.',
'whitelistreadtitle' => 'Для чтения требуется авторизация',
'whitelistreadtext' => 'Для доступа необходимо [[{{ns:special}}:Userlogin|представиться]].',
'whitelistacctitle' => 'У вас нет прав чтобы создать учётную запись',
'whitelistacctext' => 'Для создания учётных записей в этой Вики необходимо [[{{ns:special}}:Userlogin|представиться]]',
'loginreqtitle' => 'Требуется авторизация',
'loginreqtext'  => 'Вы должны [[{{ns:special}}:Userlogin|представиться системе]] для того чтобы просматривать остальные страницы.',
'accmailtitle' => 'Пароль выслан.',
'accmailtext' => "Пароль для '$1' выслан на $2.",
'newarticle'    => '(Новая)',
'newarticletext' =>
"Вы перешли по ссылке на статью, которая пока не существует.
Чтобы создать новую страницу, наберите текст в окне, расположенном ниже 
(см. [[{{ns:project}}:Справка|справочную страницу]] чтобы получить больше информации).
Если вы оказались здесь по ошибке, просто нажмите кнопку '''назад''' вашего браузера.",
'talkpagetext' => '<!-- MediaWiki:talkpagetext -->',
'anontalkpagetext' => "---- ''Эта страница обсуждения, принадлежащая анонимному участнику, который ещё не зарегистрировался или который не воспользовался зарегистрированным именем. Поэтому мы вынуждены использовать числовой [[IP-адрес]] для его идентификации. Один IP-адрес может использоваться несколькими участниками. Если вы анонимный участник и полагаете, что получили комментарии, адресованные не вам, пожалуйста [[{{ns:special}}:Userlogin|зарегистрируйтесь или представьтесь системе как зарегистрированный пользователь]], чтобы в будущем избежать возможной путаницы с другими анонимными участниками.''",
'noarticletext' => '(Сейчас на этой странице нет текста)',
'clearyourcache' => "'''Замечание:''' Чтобы после сохранения увидеть сделанные изменения, очистите кэш своего браузера: '''Mozilla:''' нажмите ''reload''(или ''Ctrl+R''), '''IE / Opera:''' ''Ctrl+F5'', '''Safari:''' ''Cmd+R'', '''Konqueror''' ''Ctrl+R''.",
'usercssjsyoucanpreview' => "<strong>Подсказка:</strong> Используйте кнопку предварительного просмотра чтобы протестировать ваш новый css-файл или js-файл перед сохранением.",
'usercsspreview' => "'''Помните что это только предварительный просмотр вашего css-файла, он ещё не сохранён!'''",
'userjspreview' => "'''Помните что это только предварительный просмотр вашего javascrpt-файла, он ещё не сохранён!'''",
'updated'               => '(Обновлена)',
'note'                  => '<strong>Примечание:</strong> ',
'previewnote'   => 'обратите внимание, что это только предварительный просмотр, и текст ещё не записан!',
'previewconflict' => 'Этот предварительный просмотр отражает текст из окна редактирования, как он будет выглядеть, если вы решите записать его.',
'editing'               => "Редактирование $1",
'editingsection'                => "Редактирование $1 (секция)",
'editingcomment'                => "Редактирование $1 (комментарий)",
'editconflict'  => 'Конфликт редактирования: $1',
'explainconflict' => "Пока вы редактировали эту статью, кто-то внёс в неё изменения. В верхнем окне для редактирования вы видите тот текст статьи, который будет сохранён при нажатии на кнопку «Записать страницу». В нижнем окне для редактирования находится ваш вариант. Чтобы сохранить ваши изменения, перенесите их из нижнего окна для редактирования в верхнее.<br/>",
'yourtext'              => 'Ваш текст',
'storedversion' => 'Сохранённая версия',
'nonunicodebrowser' => "<strong>ПРЕДУПРЕЖДЕНИЕ: Ваш [[браузер]] не поддерживает кодировку [[Юникод]]. Пожалуйста, воспользуйтесь другим браузером для редактирования.</strong>",
'editingold'    => "<strong>ПРЕДУПРЕЖДЕНИЕ: Вы редактируете устаревшую версию данной страницы. После сохранения страницы будут потеряны изменения сделанные в последующих версиях.",
'yourdiff'              => 'Различия',
'copyrightwarning' => "Обратите внимание, что все добавления и изменения в данном проекте попадают под действие $2 (см. $1). Внося какие-либо дополнения, вы соглашаетесь с тем, что они могут быть изменены кем угодно.

Прежде чем поместить сюда какие-либо материалы, убедитесь что вы [[{{ns:project}}:Авторские права|имеете на это право]].

<strong>НЕ РАЗМЕЩАЙТЕ БЕЗ РАЗРЕШЕНИЯ МАТЕРИАЛЫ, ЯВЛЯЮЩИЕСЯ ОБЪЕКТОМ ОХРАНЫ АВТОРСКОГО И СМЕЖНЫХ ПРАВ</strong>",
'longpagewarning' => "<strong>ПРЕДУПРЕЖДЕНИЕ: размер этой страницы $1 килобайт; страницы, размер которых превышает 32 килобайта, могут быть неверно отображены в окне редактирование некоторых браузеров.
Пожалуйста, рассмотрите вариант разбиения страницы на меньшие части.</strong>",
'readonlywarning' => '<strong>ПРЕДУПРЕЖДЕНИЕ: база данных заблокирована в связи с процедурами обслуживания,
поэтому вы не можете записать ваши изменения прямо сейчас.
Возможно, вам следует сохранить текст в файл на своём диске и поместить его в данный проект позже.</strong>',
'protectedpagewarning' => "<strong>ПРЕДУПРЕЖДЕНИЕ: эта страница заблокирована и только [[Project:Администраторы|администраторы проекта]] могут изменять её. См. [[Project:Правила защиты страниц|правила защиты страниц]].</strong>",
'templatesused' => 'На этой странице помещены шаблоны:',

# History pages
#
'revhistory'    => 'Журнал изменений',
'nohistory'             => 'Для этой страницы журнал изменений отстуствует.',
'revnotfound'   => 'Версия не найдена',
'revnotfoundtext' => "Невозможно найти запрошенную вами старую версию страницы.
Пожалуйтса, проверьте правильность URL, который вы использовали для доступа к этой странице.\n",
'loadhist'              => 'Загрузка журнала изменений страницы',
'currentrev'    => 'Текущая версия',
'revisionasof'          => 'Версия $1',
'revisionasofwithlink'  => 'Версия как $1; $2<br />$3 | $4',
'previousrevision'      => '← Старая версия',
'nextrevision'          => 'Новые версии →',
'currentrevisionlink'   => 'посмотреть текущие изменения',
'cur'                   => 'текущ.',
'next'                  => 'след.',
'last'                  => 'пред.',
'orig'                  => 'перв.',
'histlegend'    => 'Пояснения: (текущ.) — отличие от текущей версией,
(пред.) — отличие от предшествующей версии, M — малозначимое изменение',
'history_copyright'    => '—',
'deletedrev' => '[удалена]',
'histfirst' => 'Первый',
'histlast' => 'Последний',

# Diffs
#
'difference'    => '(Различия между версиями)',
'loadingrev'    => 'загрузка версии для различения',
'lineno'                => "Строка $1:",
'editcurrent'   => 'Редактировать текущую версию данной страницы',
'selectnewerversionfordiff' => 'Выберите новую версию для сравнения',
'selectolderversionfordiff' => 'Выберите старую версию для сравнения',
'compareselectedversions' => 'Сравнить выбранные версии',

# Search results
#
'searchresults' => 'Результаты поиска',
'searchresulttext' => "Для получения более подробной информации о поиске на страницах проекта, см. [[{{ns:project}}:Поиск]].",
'searchquery'   => "По запросу «$1»",
'badquery'              => 'Неправильно сформированный запрос',
'badquerytext'  => 'Невозможно обработать ваш запрос.
Возможно, причина этого в том, что вы попытались найти слово, которое короче трёх букв, что пока не поддерживается.
Возможно также, что вы допустили опечатку в слове.
Попробуйте другой запрос.',
'matchtotals'   => "Запросу «$1» соответсвует(ют) $2 название(я) статьи(ей) и тексты $3 статьи(ей).",
'nogomatch' => 'Страницы с [[$1|таким названием]] не существует, попробуйте запустить поиск по тексту статей.',
'titlematches'  => 'Совпадения в названиях статей',
'notitlematches' => 'Нет совпадений в названиях статей',
'textmatches'   => 'Совпадения в текстах статей',
'notextmatches' => 'Нет совпадения в текстах статей',
'prevn'                 => "предыдущие $1",
'nextn'                 => "следующие $1",
'viewprevnext'  => "Просмотреть ($1) ($2) ($3).",
'showingresults' => "Ниже показаны <strong>$1</strong> результатов, начиная с <strong>#$2</strong>.",
'showingresultsnum' => "Ниже показаны <strong>$3</strong> результатов, начиная с №<strong>$2</strong>.",
'nonefound'             => "Неудачный поиск может быть вызван попыткой найти общие слова, которые не подлежат индексированию, например — «тоже» и «чтобы» или употреблением более чем одного ключевого слова поиска (показываются только страницы, содержащие все указанные слова для поиска).",
'powersearch' => 'Искать',
'powersearchtext' => "
Поиск $3 $9<br />
$2 — <strong>Показывать перенаправления</strong><br />
<strong>Искать в пространствах имён:</strong>
<center><table border=\"0\"><tr><td>
$1
</td></tr></table></center></FORM>
<br />
<br />
<h2>Поиск с учётом русской морфологии</h2>
Для поиска с учётом русской морфологии воспользуйтесь поисковой системой Яндекс. Слово будет искаться во всех словоформах, а также будут игнорироваться различия между буквами «е» и «ё». Имейте в виду, что в этом случае поиск ведётся только в проиндексированных Яндексом страницах.
<!-- Поиск через Яндекс (ya.ru) -->
<form NAME=\"web\" METHOD=\"get\" ACTION=\"http://www.yandex.ru/yandsearch\">
<input type=\"hidden\" name=\"serverurl\" value=\"{{SERVER}}\">
<input type=\"hidden\" name=\"server_name\" value=\"{{SITENAME}} (русская версия)\">
<INPUT type=hidden value=rad name=rpt><input type=\"hidden\" name=\"referrer1\" value=\"{{SERVER}}\">
<input type=\"hidden\" name=\"referrer2\" value=\"{{SITENAME}} (русская версия)\">
<TABLE bgcolor=\"#FFFFFF\"><tr><td width=130 align=\"right\">
<a href=\"http://www.yandex.ru\">
<IMG SRC=\"http://www.ya.ru/logo.gif\"
border=\"0\" ALT=\"Яндекс\"></A>
</td><td>
<input TYPE=\"text\" NAME=\"text\" SIZE=\"31\" VALUE=\"\" MAXLENGTH=\"160\">
</td><td><input TYPE=\"SUBMIT\" VALUE=\"Поиск по сайту\">
</td></tr></table>
</form>
<!-- Поиск через Яндекс (ya.ru) -->
<h2>Поиск через Гугл</h2>
Поиск с использованием языка запросов Google. Поиск ведётся только в проиндексированных страницах.
<!-- SiteSearch Google -->
<FORM method=GET action=\"http://www.google.com/search\">
<TABLE bgcolor=\"#FFFFFF\"><tr><td width=130 align=\"right\">
<A HREF=\"http://www.google.com/\">
<IMG SRC=\"http://www.google.com/logos/Logo_40wht.gif\"
border=\"0\" ALT=\"Google\"></A>
</td>
<td>
<INPUT TYPE=text name=q size=31 maxlength=255 value=\"\"> <INPUT type=submit name=btnG VALUE=\"Поиск по сайту\"> <input type=hidden name=domains value=\"{{SERVER}}\">
<input type=hidden name=sitesearch value=\"{{SERVER}}\"><input type='hidden' name='ie' value='UTF-8'> <input type='hidden' name='oe' value='UTF-8'>
</td></tr></TABLE></FORM>
<!-- SiteSearch Google -->",
'blanknamespace' => 'Статьи',

# Preferences page
#
'preferences'   => 'Настройки',
'prefsnologin' => 'Вы не представились системе',
'prefsnologintext'      => "Вы должны [[Special:Userlogin|представиться системе]]
чтобы изменять настройки участника.",
'prefslogintext' => "Вы представились системе под именем $1.
Ваш внутренний идентификационый номер — $2.

Cм. [[{{ns:project}}:Справка по настройкам]], чтобы разобраться с настройками.",
'prefsreset'    => 'Настройки были переустановлены в стандартное состояние.',
'qbsettings'    => 'Панель навигации',
'changepassword' => 'Сменить пароль',
'skin'                  => 'Оформление',
'math'                  => 'Отображение формул',
'dateformat'    => 'Формат даты',
'math_failure'          => 'Невозможно разобрать выражение',
'math_unknown_error'    => 'неизвестная ошибка',
'math_unknown_function' => 'неизвестная функция ',
'math_lexing_error'     => 'лексическая ошибка',
'math_syntax_error'     => 'синтаксическая ошибка',
'math_image_error'      => 'Преобразование в PNG прошло с ошибкой; проверьте правильность установки latex, dvips, gs и convert',
'math_bad_tmpdir'       => 'Не удаётся создать или записать во временный каталог математики',
'math_bad_output'       => 'Не удаётся создать или записать в выходной каталог математики',
'math_notexvc'  => 'Выполняемый файл texvc не найден; См. math/README - справку по настройке.',
'prefs-personal' => 'Личное',
'prefs-rc' => 'Страница свежих правок',
'prefs-misc' => 'Другие настройки',
'saveprefs'             => 'Записать',
'resetprefs'    => 'Сбросить',
'oldpassword'   => 'Старый пароль',
'newpassword'   => 'Новый пароль',
'retypenew'             => 'Повторите ввод нового пароля',
'textboxsize'   => 'Размеры поля ввода',
'rows'                  => 'Строк',
'columns'               => 'Столбцов',
'searchresultshead' => 'Результаты поиска',
'resultsperpage' => 'Количество найденных записей на страницу',
'contextlines'  => 'Количество показываемых строк для каждой найденной',
'contextchars'  => 'Количество символов контекста на строку',
'stubthreshold' => 'Порог определения болванки',
'recentchangescount' => 'Заголовки статей на странице свежих правок',
'savedprefs'    => 'Ваши настройки сохранены.',
'timezonelegend' => 'Часовой пояс',
'timezonetext'  => 'Введите смещение (в часах) вашего местного времени
от времени сервера (UTC — гринвичского).',
'localtime'     => 'Местное время',
'timezoneoffset' => 'Смещение',
'servertime'    => 'Текущее время сервера',
'guesstimezone' => 'Заполнить из браузера',
'emailflag'             => 'Не принимать электронные письма от других участников',
'defaultns'             => 'По умолчанию, искать в следующих пространствах имён:',
'default'               => 'по умолчанию',
'files'                 => 'Файлы',

# User levels special page
#

# switching pan
'groups-lookup-group' => 'Управление правами группы',
'groups-group-edit' => 'Существующие группы: ',
'editgroup' => 'Изменить группу',
'addgroup' => 'Добавить группу',

'userrights-lookup-user' => 'Управление группами пользователя',
'userrights-user-editname' => 'Введите имя участника: ',
'editusergroup' => 'Изменить группы пользователей',

# group editing
'groups-editgroup' => 'Изменить группу',
'groups-addgroup' => 'Добавить группу',
'groups-editgroup-preamble' => 'Если название или описание начинаются с двоеточия, 
то их текст будет заменён на соответствующее сообщение из пространства имён MediaWiki',
'groups-editgroup-name' => 'Название группы: ',
'groups-editgroup-description' => 'Описание группы (максимум 255 символов):<br />',
'savegroup' => 'Сохранить группу',
'groups-tableheader'        => 'ID || Название || Описание || Права',
'groups-existing'           => 'Существующие группы',
'groups-noname'             => 'Пожалуйста, укажите формально правильное название группы.',
'groups-already-exists'     => 'Группа с таким названием уже существует',
'addgrouplogentry'          => 'Добавлена группа $2',
'changegrouplogentry'       => 'Изменена группа $2',
'renamegrouplogentry'       => 'Группа $2 переименована в группу $3',

# user groups editing
'userrights-editusergroup' => 'Изменить группы участника',
'saveusergroups' => 'Сохранить группы участника',
'userrights-groupsmember' => 'Член групп:',
'userrights-groupsavailable' => 'Доступные группы:',
'userrights-groupshelp' => 'Выберите группы, в которые вы хотите включить или из которых хотите исключить участника.
Невыбранные группы не изменятся. Группы можно убрать из выборки используя CTRL + левая клавиша мыши',
'userrights-logcomment' => 'Членство группы изменено с $1 на $2',

# Default group names and descriptions
#
'group-anon-name'       => 'Anonymous',
'group-anon-desc'       => 'Анонимные участники',
'group-loggedin-name'   => 'User',
'group-loggedin-desc'   => 'Зарегистрированные участники',
'group-admin-name'      => 'Administrator',
'group-admin-desc'      => 'Администраторы, могут блокировать других участников и удалять статьи',
'group-bureaucrat-name' => 'Bureaucrat',
'group-bureaucrat-desc' => 'Бюрократы, могут назначать администраторов',
'group-steward-name'    => 'Steward',
'group-steward-desc'    => 'Стюарды, полный доступ',

# Recent changes
#
'changes' => 'изменения',
'recentchanges' => 'Свежие правки',
'recentchanges-url' => '{{ns:special}}:Recentchanges',
'recentchangestext' => 'Ниже в хронологическом порядке перечислены последние изменения на страницах {{grammar:genitive|{{SITENAME}}}}.',
'rcloaderr'             => 'Загрузка свежих правок',
'rcnote'                => "Последние <strong>$1</strong> изменеий(я) за <strong>$2</strong> дней(я).",
'rcnotefrom'    => "Ниже перечислены изменения с <strong>$2</strong> (по <strong>$1</strong>).",
'rclistfrom'    => "Показать изменения с $1.",
'showhideminor' => "$1 малозн. правки | $2 ботов | $3 представившихся участников | $4 проверенные правки ",
'rclinks'               => "Показать последние $1 изменений(я) за $2 дня(ей);<br />$3.",
'rchide'                => "в форме $4; $1 малозначимых изменений; $2 вторичное(ые) пространство(а) имён; $3 множественных изменений.",
'rcliu'                 => "; $1 изменений, сделанных представившимися участниками",
'diff'                  => 'разн.',
'hist'                  => 'журнал',
'hide'                  => 'скрыть',
'show'                  => 'показать',
'tableform'             => 'таблица',
'listform'              => 'список',
'nchanges'              => "$1 изменение(я,ий)",
'minoreditletter' => 'М',
'newpageletter' => 'Н',
'sectionlink' => '→',
'number_of_watching_users_RCview'       => '[$1]',
'number_of_watching_users_pageview'     => '[$1 наблюдающих пользователя]',

# Upload
#
'upload'                => 'Загрузить файл',
'uploadbtn'             => 'Загрузить файл',
'uploadlink'    => 'Загрузить изображение',
'reupload'              => 'Закачать повторно',
'reuploaddesc'  => 'Вернуться к форме загрузки.',
'uploadnologin' => 'Вы не представились системе',
'uploadnologintext'     => "Вы должны [[Special:Userlogin|представиться системе]],
чтобы загружать файлы на сервер.",
'upload_directory_read_only' => 'Вебсервер не имеет прав записи в папку ($1), в которой предполагается хранить загружаемые файлы.',
'uploaderror'   => 'Ошибка загрузки файла',
'uploadtext'    => "Используя эту форму вы можете загрузить на сервер файлы.

Чтобы просмотреть ранее загруженные файлы,
перейдите сюда: [[Special:Imagelist|список загруженных изображений]].<br/>
Загрузка и удаление файлов отражаются в [[Special:Log|журнале загрузки файлов]].

Вы также должны поставить галочку, подтверждающую, что вы не нарушаете чьих-либо авторских прав загрузкой этого файла.

Нажмите кнопку «Загрузить», чтобы передать файл на сервер.

Для включения изображения в статью вы можете использовать строки вида:
*'''<nowiki>[[{{ns:6}}:file.jpg]]</nowiki>'''
*'''<nowiki>[[{{ns:6}}:file.png|thumb|комментарий]]</nowiki>''' 

Для ссылки на медиа-файл вы можете использовать строку вида:
*'''<nowiki>[[{{ns:-2}}:file.ogg]]</nowiki>'''
",
'uploadlog'             => 'журнал загрузок',
'uploadlogpage' => 'Журнал_загрузок',
'uploadlogpagetext' => 'Ниже представлен список последних загрузок файлов.
Везде используется время сервера (по Гринвичу, UTC).
<ul>
</ul>',
'filename'              => 'Имя файла',
'filedesc'              => 'Краткое описание',
'filestatus' => 'Условия распространения',
'filesource' => 'Источник',
'affirmation'   => "Я подтверждаю, что владелец авторских прав на этот файл согласен распространять его на условиях $1.",
'copyrightpage' => "{{ns:project}}:Авторское право",
'copyrightpagename' => "Авторские права проекта {{SITENAME}}",
'uploadedfiles' => 'Загруженые файлы',
'noaffirmation' => 'Вы должны подтвердить, что загрузка этого файла не нарушает чьих-либо авторских прав.',
'ignorewarning' => 'Игнорировать предупреждение и всё равно записать файл.',
'minlength'             => 'Название изображения должно содержать хотя бы три символа.',
'illegalfilename'       => 'Имя файла «$1» содержит символы, которые не разрешается использовать в заголовках. Пожалуйста, переименуйте файл и попытайтесь загрузить его снова.',
'badfilename'   => "Название изображения было изменено на $1.",
'badfiletype'   => "«$1» не является рекомендованным форматом для файлов с изображениями.",
'largefile'             => 'Рекомедуется использовать изображения, размер которых не превышает $1 байт (размер загруженного файла составляет $2 байт).',
'emptyfile'             => 'Загруженный вами файл вероятно пустой. Возможно, это произошло из-за ошибки при наборе имени файла. Пожалуйста, проверьте, действительно ли вы хотите загрузить этот файл.',
'fileexists'            => 'Файл с этим именем уже существует, пожалуйста проверьте $1 если вы не уверены что вы хотите заменить его.',
'successfulupload' => 'Загрузка успешно завершена',
'fileuploaded'  => "Файл \"$1\" успешно загружен.

Пожалуйста, проследуйте по следующей ссылке: ($2) к странице с описанием и заполните информацию о файле, такую как: источник файла, когда и кем был создан файл, а также любую другую информацию известную вам об этом файле.",
'uploadwarning' => 'Предупреждение',
'savefile'              => 'Записать файл',
'uploadedimage' => "загружен [[$1|«$1»]]",
'uploaddisabled' => 'Извините, загрузка запрещена.',
'uploadscripted' => 'Файл содержит HTML-код или скрипт, который может быть ошибочно обработан браузером.',
'uploadcorrupt' => 'Файл либо повреждён, либо имеет неверное расширение. Пожалуйста, проверьте файл и попробуйте загрузить его ещё раз.',
'uploadvirus' => 'Файл содержит вирус! См. $1',
'sourcefilename' => 'Исходное имя файла',
'destfilename' => 'Целевое имя файла',

# Image list
#
'imagelist'             => 'Список файлов',
'imagelisttext' => "Ниже представлен список из $1 файлов, отсортированных $2.",
'getimagelist'  => 'получение списка файлов',
'ilsubmit'              => 'Искать',
'showlast'              => "Показать последние $1 файлов, отсортированных $2.",
'byname'                => 'по имени',
'bydate'                => 'по дате',
'bysize'                => 'по размеру',
'imgdelete'             => 'удал.',
'imgdesc'               => 'описание',
'imglegend'             => 'Пояснения: (описание) — показать/изменить описание изображения.',
'imghistory'    => 'Журнал',
'revertimg'             => 'откат.',
'deleteimg'             => 'удал.',
'deleteimgcompletely'           => 'Удалить все версии',
'imghistlegend' => 'Пояснения: (тек.) — текущий файл, (удал.) — удалить эту старую версию, (откат.) — откатиться на эту старую версию.
<br /><em>Выберите дату, чтобы посмотреть список сайлов, загруженных на эту дату</em>.',
'imagelinks'    => 'Ссылки',
'linkstoimage'  => 'Следующие страницы ссылаются на данный файл:',
'nolinkstoimage' => 'Нет страниц, ссылающихся на данный файл.',
'sharedupload' => 'Этот файл взят из [[Commons:Заглавная_страница|WikiCommons]], репозитория изображений и других свободно распространяемых файлов, общего для всех проектов [[Фонд Викимедиа|Фонда Викимедиа]].',
'shareduploadwiki' => 'Смотри [$1 страницу описания файла] для объяснений.',
'noimage'       => "Файла с таким именем не существует. вы можете [$1 загрузить его].",
'uploadnewversion' => "[$1 Загрузить новую версию этого изображения]",

# Statistics
#
'statistics'    => 'Статистика',
'sitestats'             => 'Статистика сайта',
'userstats'             => 'Статистика участников',
'sitestatstext' => "Суммарно в базе данных содержится <strong>$1</strong> страниц.
Это число включает в себя страницы о проекте, страницы обсуждений, незаконченные статьи, перенаправления и другие страницы, которые, не учитываются при учёте количества статей.
За исключением них, есть <strong>$2</strong> страниц, которые считаются полноценными статьями. Для того, чтобы страница считалась полноценной статьёй, она должна находиться в основном пространстве имён и содержать хотя бы одну внутреннюю ссылку.

Всего с момента установки программного обеспечения было сделано <strong>$4</strong> изменений страниц.
Таким образом, в среднем приходится <strong>$5</strong> изменений на одну страницу.",
'userstatstext' => "Зарегистрировались '''$1''' участников, из которых '''$2''' ($4%) являются администраторами (см. $3).",

# Maintenance Page
#
'maintenance'           => 'Страница обслуживания',
'maintnancepagetext'    => 'На этой странице есть несколько удобных инструментов для ежедневного обслуживания. Некоторые из этих функций дают сильную нагрузку на базу данных, поэтому, не перезагружайте страницу после каждого сделанного вами изменения ;-',
'maintenancebacklink'   => 'Назад, на страницу обслуживания',
'disambiguations'       => 'Многозначные страницы',
'disambiguationspage'   => "{{ns:project}}:Ссылки_на_многозначные_страницы",
'disambiguationstext'   => "Следующие статьи ссылаются на <em>страницы разъяснения многозначностей</em>. Вместо этого они должны указывать на соответствующую конкретную статью.<br/>Страница считается многозначной, если на неё указывает $1.<br/>Ссылки из других пространств имён здесь <em>не</em> перечислены.",
'doubleredirects'       => 'Двойные перенаправления',
'doubleredirectstext'   => "Каждая строка содержит ссылки на первое и второе перенаправления, а также первую строчку страницы второго перенаправления, в которой обычно указывается название страницы куда должно осуществляться перенаправление. Нужно чтобы и первое перенаправление ссылалось на эту страницу.",
'brokenredirects'       => 'Разорванные перенаправления',
'brokenredirectstext'   => 'Следующие перенаправления указывают на несуществующие статьи.',
'selflinks'             => 'Страницы, ссылающиеся сами на себя',
'selflinkstext'             => 'Следующие страницы содержат ссылки на себя же, чего не должно быть.',
'mispeelings'           => 'Страницы с орфографическими ошибками',
'mispeelingstext'               => "Следующие страницы содержат часто встречающиеся орфографические ошибки, перечисленные на странице $1. Должно быть указано правильное написание (наподобие следующего).",
'mispeelingspage'       => 'Список часто встречающихся орфографических ошибок',
'missinglanguagelinks'  => 'Отсутствующие языковые ссылки',
'missinglanguagelinksbutton'    => 'Найти отсутствующие языковые ссылки для следующего языка',
'missinglanguagelinkstext'      => "Эти статьи <em>не</em> имеют ссылок на аналог на языке $1. Перенаправления и сложенные страницы <em>не</em> показаны.",


# Miscellaneous special pages
#
'orphans'               => 'Страницы-сироты',
'geo'           => 'Географические координаты',
'validate'              => 'Проверить страницу',
'lonelypages'   => 'Страницы-сироты',
'uncategorizedpages'    => 'Некатегоризованные страницы',
'uncategorizedcategories'       => 'Некатегоризованные категории',
'unusedimages'  => 'Неиспользуемые файлы',
'popularpages'  => 'Популярные страницы',
'nviews'                => '$1 просмотров',
'wantedpages'   => 'Требуемые страницы',
'nlinks'                => '$1 ссылок(ки)',
'allpages'              => 'Все страницы',
'randompage'    => 'Случайная статья',
'randompage-url'=> 'Special:Random',
'shortpages'    => 'Короткие статьи',
'longpages'             => 'Длинные страницы',
'deadendpages'  => 'Тупиковые статьи',
'listusers'             => 'Список участников',
'listadmins'    => 'Администраторы',
'specialpages'  => 'Служебные страницы',
'spheading'             => 'Служебные страницы',
'restrictedpheading'    => 'Служебные страницы с ограниченным доступом',
'blockpheading' => 'Блокировка',
'createaccountpheading' => 'Уровень создания пользователей',
'deletepheading' => 'Уровень удаления',
'userrightspheading' => 'Уровень прав участников',
'grouprightspheading' => 'Уровень прав групп',
'siteadminpheading' => 'Уровень сисадмина',

/** obsoletes
'sysopspheading' => 'Служебные страницы для операторов',
'developerspheading' => 'Служебные страницы для разработчиков',
*/
'protectpage'   => 'Защищённая страница',
'recentchangeslinked' => 'Связанные правки',
'rclsub'                => "(на статьи, ссылки на которые есть на $1)",
'debug'                 => 'Отладка',
'newpages'              => 'Новые статьи',
'ancientpages'          => 'Самые старые статьи',
'intl'          => 'Межъязыковые ссылки',
'move' => 'Переименовать',
'movethispage'  => 'Переименовать эту страницу',
'unusedimagestext' => 'Пожалуйста, учтите, что другие веб-сайты могут использовать прямую ссылку (URL) на это изображение, и поэтому изображение может активно использоваться несмотря на его вхождение в этот список.',
'booksources'   => 'Источники книг',
'categoriespagetext' => 'В вики имеются следующие категории.',
'data'  => 'Данные',
'userrights' => 'Управление правами участников',
'groups' => 'Группы участников',

# FIXME: Other sites, of course, may have affiliate relations with the booksellers list
'booksourcetext' => "Ниже приведён список ссылок на другие веб-сайты, на которых продаются новые и бывшие в употреблении книги, а также на них может быть информация о книгах, которые вы ищете.
Данный проект никак не связан ни с одном из них, и этот список не может рассматриваться как их поддержка.",
'isbn'  => 'ISBN',
'rfcurl' =>  'http://www.faqs.org/rfcs/rfc$1.html',
'pubmedurl' =>  'http://www.ncbi.nlm.nih.gov/entrez/query.fcgi?cmd=Retrieve&db=pubmed&dopt=Abstract&list_uids=$1',
'alphaindexline' => "от $1 до $2",
'version'               => 'Версия MediaWiki',
'log'           => 'Журналы',
'alllogstext'   => 'Комбинированный показ журналов загрузки, удаления, защиты, блокировки и администрирования.
Вы можете отфильтровать результаты по типу журнала, имени пользователя или затронутой странице.',

# Special:Allpages
'nextpage'          => 'Следующая страница ($1)',
'allpagesfrom'          => 'Вывести страницы, начинающиеся на:',
'allarticles'       => 'Все статьи',
'allnonarticles'        => 'Все не-статьи',
'allinnamespace'        => 'Все страницы (пространства имён «$1»)',
'allnotinnamespace'     => 'Все страницы (кроме пространства имён «$1»)',
'allpagesprev'      => 'Предыдущие',
'allpagesnext'      => 'Следующие',
'allinnamespace' => 'Все страницы ($1 пространство имён)',
'allpagessubmit'    => 'Выполнить',

# Email this user
#
'mailnologin'   => 'Адрес для отправки отсутствует',
'mailnologintext' => "Вы должны [[Special:Userlogin|представиться системе]]
и иметь действительный адрес электронной почты в ваших [[Special:Preferences|настройках]],
чтобы иметь возможность отправлять электронную почту другим участникам.",
'emailuser'             => 'Отправить электронное письмо этому участнику',
'emailpage'             => 'Отправить электронное письмо участнику',
'emailpagetext' => 'Если этот участник указал действительный адрес электронной почты в своих настройках, то заполнив форму ниже, можно отправить ему сообщение.
Электронный адрес, который вы указали в своих настройках, будет указан в поле «От кого» письма, поэтому получатель будет иметь возможность ответить.',
'usermailererror' => 'При посылке e-mail произошла ошибка: ',
'defemailsubject'  => "{{SITENAME}} e-mail",
'noemailtitle'  => 'Адрес электронной почты отсутствует',
'noemailtext'   => 'Этот участник не указал действительный адрес электронной почты, или указал, что не желает получать письма от других участников.',
'emailfrom'             => 'От кого',
'emailto'               => 'Кому',
'emailsubject'  => 'Тема письма',
'emailmessage'  => 'Сообщение',
'emailsend'             => 'Отправить',
'emailsent'             => 'Письмо отправлено',
'emailsenttext' => 'Ваше электронное сообщение отослано.',

# Watchlist
#
'watchlist'                     => 'Ваш список наблюдения',
'watchlistsub'          => "(для участника $1)",
'nowatchlist'           => 'Ваш список наблюдения пуст.',
'watchnologin'          => 'Нужно представиться системе',
'watchnologintext'      => "Вы должны [[Special:Userlogin|представиться системе]], чтобы иметь возможность изменять свой список наблюдения",
'addedwatch'            => 'Добавлена в список слежения',
'addedwatchtext'        => "Статья '''$1''' была добавлена в ваш [[{{ns:special}}:Watchlist|список наблюдения]]. Последующие изменения этой статьи и связанной с ней страницы обсуждения будут отражаться в нём, а также будут отображаться '''жирным шрифтом''' на странице со [[{{ns:special}}:Recentchanges|списком свежих изменений]], чтобы их было легче заметить.

Если позже вы захотите удалить страницу из списка наблюдения, нажмите кнопку «Не следить» в верхней правой части страницы.",
'removedwatch'          => 'Удалена из списка наблюдения',
'removedwatchtext'      => "Страница «$1» была удалена из вашего списка наблюдения.",
'watch' => 'Следить',
'watchthispage'         => 'Наблюдать за этой страницей',
'unwatch' => 'Не следить',
'unwatchthispage'       => 'Прекратить наблюдение',
'notanarticle'          => 'Не статья',
'watchnochange'         => 'Ничто из списка наблюдения не изменялось в рассматриваемый период.',
'watchdetails'          => "Всего в списке наблюдения находится $1 страниц (не считая страниц обсуждения)

* [[Special:Watchlist/edit|Показать и отредактировать полный список]]
",
'wlheader-enotif'       => "* Уведомление по эл. почте включено.",
'wlheader-showupdated'  => "* Страницы, изменившиеся с вашего последнего их посещения, выделены '''жирным''' шрифтом.",
'watchmethod-recent'=> 'просмотр последних изменений для наблюдаемых страниц',
'watchmethod-list'      => 'просмотр наблюдаемых страниц для последних изменений',
'removechecked'         => 'Удалить выбранные элементы из списка наблюдения',
'watchlistcontains' => "Ваш список наблюдения содержит $1 страниц.",
'watcheditlist'         => 'Ниже представлен алфавитный список наблюдаемых
вами страниц. Отметьте страниц, которые вы хотите удалить из вашего
списка наблюдения и щёлкните на кнопку «удалить выбранные» 
внизу экрана.',
'removingchecked'       => 'Удаление выбранных элементов из списка наблюдения…',
'couldntremove'         => "Невозможно удалить элемент «$1»…",
'iteminvalidname'       => "Проблема с элементом «$1»', недопустимое название…",
'wlnote'                        => "Ниже следуют последние $1 изменений за последние <strong>$2</strong> часов.",
'wlshowlast'            => "Показать за последние $1 часов $2 дней $3",
'wlsaved'               => 'Это сохранённая версия вашего списка наблюдения',
'wlhideshowown'         => '$1 ваших правок.',
'wlshow'                => 'Показать',
'wlhide'                => 'Скрыть',

'enotif_mailer'             => '{{SITENAME}} Служба извещений по почте',
'enotif_infotext'           => "*Уведомление по электронной почте включено.
* Страницы, изменившиеся с момента вашего последнего посещения показаны '''жирным шрифтом''' ",
'enotif_reset'              => 'Отметить все страницы как просмотренные',
'enotif_newpagetext'        => 'Это новая страница.',
'changed'                       => 'изменена',
'created'                       => 'создана',
'enotif_subject'    => 'Страница проекта «{{SITENAME}}» $PAGETITLE была $CHANGEDORCREATED участником $PAGEEDITOR',
'enotif_lastvisited' => 'См. {{SERVER}}{{localurl:$PAGETITLE_RAWURL|diff=0&oldid=$OLDID}} для просмотра всех изменений произошедших с вашего последнего посещения.',
'enotif_body' => '$WATCHINGUSERNAME,

$PAGEEDITDATE страница проекта «{{SITENAME}}» $PAGETITLE была $CHANGEDORCREATED пользователем $PAGEEDITOR,
см. {{SERVER}}{{localurl:$PAGETITLE_RAWURL}} для просмотра текущей версии.

$NEWPAGE

Краткое описание изменения: $PAGESUMMARY $PAGEMINOREDIT

Обратиться к изменившему:
эл. почта {{SERVER}}{{localurl:Special:Emailuser|target=$PAGEEDITOR_RAWURL}}
вики {{SERVER}}{{localurl:User:$PAGEEDITOR_RAWURL}}

Не будет никаких других уведомлений в случае дальнейших изменений, если Вы не посещаете эту страницу.
Вы могли также повторно установить флаги уведомления для всех ваших наблюдаемых страниц в вашем списке наблюдения.

             Система оповещения {{grammar:genitive|{{SITENAME}}}}

--
Чтобы изменить настройки вашего списка наблюдения обратитель к
{{SERVER}}{{localurl:Special:Watchlist|edit=yes}}

Обратная связь и помощь:
{{SERVER}}{{localurl:Help:Contents}}',

# Delete/protect/revert
#
'deletepage'    => 'Удалить страницу',
'confirm'               => 'Подтверждение',
'excontent' => "содержимое: '$1'",
'excontentauthor' => "содержимое: «$1» (единственным автором был «$2»)",
'exbeforeblank' => "содержимое до очистки: '$1'",
'exblank' => 'страница была пуста',
'confirmdelete' => 'Подтвердить удаление',
'deletesub'             => "(«$1» удаляется)",
'historywarning' => 'Предупреждение: У страницы, которую вы собираетесь удалить, есть журнал изменений: ',
'confirmdeletetext' => "'''ВНИМАНИЕ!''' Сейчас вы '''навсегда''' удалите страницу (изображение) из базы данных. Также будет удалена и вся история изменений этой страницы.

Пожалуйста, подтвердите:
#Что вы ''действительно'' желаете это сделать;
#Что вы ''полностью'' понимаете последствия своих действий;
#Что вы делаете это ''в соответствии'' с правилами, изложенными в разделе [[{{ns:project}}:Правила]].",
'actioncomplete' => 'Действие выполнено',
'deletedtext'   => "«$1» была удалена.
См. $2 для просмотра списка последних удалений.",
'deletedarticle' => "удалена [[$1|«$1»]]",
'dellogpage'    => 'Список_удалений',
'dellogpagetext' => 'Ниже приведён список самых свежих удалений.
Везде используется время сервера (по Гринвичу, UTC).
<ul>
</ul>',
'deletionlog'   => 'список удалений',
'reverted'              => 'Откачено к ранней версии',
'deletecomment' => 'Причина удаления',
'imagereverted' => 'Откат к ранней версии осуществлён.',
'rollback'              => 'Откатить изменения',
'rollback_short' => 'Откат',
'rollbacklink'  => 'откатить',
'rollbackfailed' => 'Ошибка при совершении отката',
'cantrollback'  => 'Невозможно откатить изменения; последний, кто вносил изменения, является единственным автором этой статьи.',
'alreadyrolled' => "Невозможно откатить последние изменения [[$1]],
сделанные [[{{ns:user}}:$2|$2]] ([[{{ns:user_talk}}:$2|Обсуждение]]); кто-то другой уже отредактировал или откатил эту страницу.

Последние изменения внёс [[{{ns:user}}:$3|$3]] ([[{{ns:user_talk}}:$3|Обсуждение]]). ",
#   only shown if there is an edit comment
'editcomment' => "Изменение было пояснено так: <em>«$1»</em>.",
'revertpage'    => "Откачено к последнему изменению, сделанному $1",
'sessionfailure' => 'Обнаружена проблема с регистрационной сессией;
действие было отменено для предотвращения возможного захвата сессии (session hijacking).
Пожалуйста нажмите кнопку «назад» и перезагрузите странизу с которой вы пришли.',
'protectlogpage' => 'Журнал_защиты',
'protectlogtext' => "Ниже — список установок и снятий защиты со статей.
См. дополнительную информацию на [[{{ns:project}}:Protected page]].",
'protectedarticle' => "защищена [[$1]]",
'unprotectedarticle' => "защита с [[$1]] снята",
'protectsub' =>"(Установка защиты «$1»)",
'confirmprotecttext' => 'Вы действительно хотите установить защиту этой страницы?',
'confirmprotect' => 'Подтвердите установку защиты страницы',
'protectmoveonly' => 'Защитить только от переименования',
'protectcomment' => 'Причина установки защиты',
'unprotectsub' =>"(Снятие защиты «$1»)",
'confirmunprotecttext' => 'Вы действительно хотите снять защиту этой страницы?',
'confirmunprotect' => 'Подтвердите снятие защиты страницы',
'unprotectcomment' => 'Причина снятия защиты',
'protectreason' => '(укажите причину)',

# Undelete
'undelete' => 'Восстановить стёртую страницу',
'undeletepage' => 'Просмотреть и восстановить стёртые страницы',
'undeletepagetext' => 'Следующие страницы были стёрты, но всё ещё находятся в архиве и поэтому могут быть восстановлены. Архив периодически очищается.',
'undeletearticle' => 'Восстановить стёртую статью',
'undeleterevisions' => "В архиве $1 версий",
'undeletehistory' => 'Если вы восстановите страницу, все версии будут также восстановлены, вместе с журналом изменений.
Если с момента удаления была создана новая страница с таким же названием, восстановленные версии будут указаны в журнале изменений перед новыми записями, и текущая версия существующей страницы автоматически заменена не будет.',
'undeleterevision' => "Стёртая версия от $1",
'undeletebtn' => 'Восстановить!',
'undeletedarticle' => "«$1» восстановлена",
'undeletedrevisions' => "$1 изменений восстановлено",
'undeletedtext'   => "Статья [[$1]] была восстановлена.
См. [[{{ns:project}}:Список_удалений]] для просмотра списка свежих удалений и восстановлений.",

# Namespace form on various pages
'namespace' => 'Пространство имён:',
'invert' => 'Обратить выделенное',

# Contributions
#
'contributions' => 'Вклад участника',
'mycontris'     => 'Ваш вклад',
'contribsub'    => "Для $1",
'nocontribs'    => 'Изменений, соответствующих заданным условиям, задано не было.',
'ucnote'        => "Ниже приводятся последние <strong>$1</strong> изменений, сделанных этим участником за последние <strong>$2</strong> дня(ей).",
'uclinks'       => "Просмотреть $1 последних изменений; просмотреть за последние $2 дня(ей).",
'uctop'         => ' (наверху)' ,
'newbies'       => 'новички',
'contribs-showhideminor' => '$1 малознач. правок',

# What links here
#
'whatlinkshere' => 'Ссылки сюда',
'notargettitle' => 'Не указана цель',
'notargettext'  => 'Вы не указали целевую страницу или участника для этого действия.',
'linklistsub'   => '(Список ссылок)',
'linkshere'             => 'Следующие страницы ссылаются сюда:',
'nolinkshere'   => 'Ни одна страница сюда не ссылается.',
'isredirect'    => 'страница-перенаправление',

# Block/unblock IP
#
'blockip'               => 'Заблокировать IP-адрес',
'blockiptext'   => "Используйте форму ниже, чтобы заблокировать возможность записи с определённого IP-адреса.
Это может быть сделано только для предотвращения вандализма и только в соответствии с
правилами изложенными в разделе [[{{ns:project}}:Правила]].
Ниже укажите конкретную причину (к примеру, процитируйте некоторые страницы с признаками вандализма).",
'ipaddress'             => 'IP-адрес',
'ipadressorusername' => 'IP-адрес или имя участника',
'ipbexpiry'             => 'Закончится через',
'ipbreason'             => 'Причина',
'ipbsubmit'             => 'Заблокировать этот адрес/участника',
'ipbother'              => 'Другое время',
'ipboptions'            => '2 часа,1 день,3 дня,1 неделя,2 недели,1 месяц,3 месяца,6 месяца,1 год,перманентно',
'ipbotheroption'        => 'иное',
'badipaddress'  => 'IP-адрес записан в неправильном формате или участника с таким именем не существует.',
'blockipsuccesssub' => 'Блокировка произведена',
'blockipsuccesstext' => "IP-адрес «$1» заблокирован.
<br />См. [[{{ns:special}}:Ipblocklist|список заблокированных IP]] чтобы узнать, какие IP-адреса заблокированы.",
'unblockip'             => 'Разблокировать IP-адрес',
'unblockiptext' => 'Используйте форму ниже, чтобы восстановить возможность записи с ранее заблокированного
IP-адреса.',
'ipusubmit'             => 'Разблокировать этот адрес',
'ipusuccess'    => "IP-адрес [[$1|«$1»]] разблокирован",
'ipblocklist'   => 'Список заблокированных IP-адресов и пользователей',
'blocklistline' => "$1, $2 заблокировал $3 (блокировка завершится $4)",
'blocklink'             => 'заблокировать',
'unblocklink'   => 'разблокировать',
'contribslink'  => 'вклад',
'autoblocker'   => "Вы автоматически заблокированны, потому что у вас такой же IP-адрес, как у «$1». Причина — «$2».",
'blocklogpage'  => 'Журнал_блокировок',
'blocklogentry' => '[[$1|«$1»]] заблокирован на период $2',
'blocklogtext'  => 'Это — журнал действий по блокированию и разблокированию участников. Автоматически блокируемые IP-адреса здесь не указываются. См. [[{{ns:special}}:Ipblocklist|Cписок активных запретов и блокировок]].',
'unblocklogentry'       => '«$1» разблокирован',
'range_block_disabled'  => 'Способность администратора создавать диапазон блокирования запрещена.',
'ipb_expiry_invalid'    => 'Недопустимый период действия.',
'ip_range_invalid'      => "Недопустимый диапазон IP-адресов.\n",
'proxyblocker'  => 'Блокировка прокси',
'proxyblockreason'      => 'Ваш IP-адрес заблокирован потому что это открытый прокси. Пожалуйста, свяжитесь с вашим интернет-провайдером  или службой поддержки и сообщите им об этой серьёзной проблеме безопасности.',
'proxyblocksuccess'     => "Выполнено.\n",
'sorbs'         => 'SORBS DNSBL',
'sorbsreason'   => 'Ваш IP-адрес находится в списке отрытых прокси-серверов [http://www.sorbs.net SORBS] DNSBL.',

# Developer tools
#
'lockdb'      => 'Сделать базу данных доступной только для чтения',
'unlockdb'    => 'Восстановить возможность записи в базу данных',
'lockdbtext'  => 'Блокировка базы данных приостановит для всех участников возможность
редактировать страницы, изменять настройки, изменять списки наблюдения и производить другие действия, требующие доступа к базе данных.

Пожалуйста, подтвердите, что вы намерены это сделать, и что вы снимете блокировку как только закончите процедуру обслуживания базы данных.',
'unlockdbtext'        => 'Разблокирование базы данных восстановит для всех участников
возможность редактировать страницы, изменять настройки, изменять списки наблюдения и производить
другие действия, требующие доступа к базе данных.
Пожалуйста, подтвердите, что вы намерены это сделать.',
'lockconfirm' => 'Да, я действительно хочу заблокировать базу данных на запись.',
'unlockconfirm'       => 'Да, я действительно хочу снять блокировку базы данных.',
'lockbtn'     => 'Сделать базу данных доступной только для чтения',
'unlockbtn'   => 'Восстановить возможность записи в базу данных',
'locknoconfirm'       => 'Вы не поставили галочку в поле подтверждения.',
'lockdbsuccesssub'    => 'База данных заблокирована',
'unlockdbsuccesssub'  => 'База данных разблокирована',
'lockdbsuccesstext'   => 'База данных проекта была заблокированна.
<br />Не забудьте убрать блокировку после завершения процедуры обслуживания.',
'unlockdbsuccesstext' => 'База данных проекта была разблокирована.',

# Make sysop
'makesysoptitle'        => 'Сделать пользователя администратором',
'makesysoptext'         => 'Этот формуляр используется бюрократами, чтобы делать обычных участников администраторами. 
Наберите имя участника и нажмите кнопку, чтобы сделать участника администратором',
'makesysopname'         => 'Имя участника:',
'makesysopsubmit'       => 'Сделать этого участника администратором',
'makesysopok'           => "<strong>Участник $1 — теперь администратор</strong>",
'makesysopfail'         => "<strong>Участника $1 невозможно сделать администратором. (Вы уверены, что правильно ввели его имя?)</strong>",
'setbureaucratflag' => 'Установить флаг «Бюрократ»',
'setstewardflag'    => 'Установить флаг «Стюард»',
'bureaucratlog'         => 'Журнал_бюрократа',
'rightslogtext'         => 'Это журнал изменений прав пользователя.',
'bureaucratlogentry'    => "Пользователь $1 переведён из группы «$2» в группу «$3»",
'rights'                        => 'Права:',
'set_user_rights'       => 'Установить права пользователя',
'user_rights_set'       => "<strong>Права пользователя $1 обновлены</strong></strong>",
'set_rights_fail'       => "<strong>Невозможно установить права для пользователя $1. (Проверьте, правильно ли введено его имя)</strong>",
'makesysop'         => 'Присвоить участнику статус администратора',
'already_sysop'     => 'Этот участник уже является администратором',
'already_bureaucrat' => 'Этот участник уже является бюрократом',
'already_steward' => 'Этот участник уже является стюардом',

# Validation
'val_yes' => 'Да',
'val_no' => 'Нет',
'val_of' => '$1 из $2',
'val_revision' => 'Версия',
'val_time' => 'Время',
'val_user_stats_title' => 'Краткий обзор оценок участника $1', 
'val_my_stats_title' => 'Краткий обзор моих оценок', 
'val_list_header' => '<th>#</th><th>Тема</th><th>Диапазон</th><th>Действие</th>',
'val_add' => 'Добавить',
'val_del' => 'Удалить',
'val_show_my_ratings' => 'Показать мои оценки',
'val_revision_number' => 'Версия №$1',
'val_warning' => '<b>Никогда не изменяйте что-либо здесь без <i>явного</i> согласия сообщества!</b>',
'val_rev_for' => 'Версии для $1',
'val_details_th_user' => 'Участник $1',
'val_validation_of' => 'Проверка «$1»',
'val_revision_of' => 'Версия $1',
'val_revision_changes_ok' => 'Ваши оценки сохранены!',
'val_rev_stats_link' => 'См. статистику проверок для «$1» <a href="$2">здесь</a>',
'val_revision_stats_link' => 'подробнее',
'val_iamsure' => 'Подтвердите, что вы действительно хотите сделать это!',
'val_clear_old' => 'Очистить мои старые оценки',
'val_details_th' => '<sub>Участник</sub> \\ <sup>Тема</sup>',
'val_merge_old' => 'Использовать мою предыдущую оценку там где выбрано «Нет мнения»',
'val_form_note' => "'''Посказка:''' Слияние ваших данных означает что для версии 
статьи, которую вы выбрали, все опции где вы выбрали пункт ''нет мнения''
будут заполнены значениями и комментариями самой последней версии для которой вы
выразили мнение. Например, если вы хотите изменить мнение по какой-то опции
для новой версии, но при этом сохранить ваши другие установки для этой статьи в этой версии,
просто выберите какую опцию вы хотели бы ''изменить'', и
слияние заполнит другие опции вашими предыдущими установками.",
'val_noop' => 'Нет мнения',
'val_topic_desc_page' => '{{ns:project}}:Оценки',
'val_votepage_intro' => 'Измените этот текст <a href="{{SERVER}}{{localurl:MediaWiki:Val_votepage_intro|edit=yes}}">здесь</a>!',
'val_percent' => '<strong>$1%</strong><br />($2 из $3 баллов<br />$4 участников)',
'val_percent_single' => '<strong>$1%</strong><br />($2 из $3 баллов<br />для одного участника)',
'val_total' => 'Всего',
'val_version' => 'Версия',
'val_tab' => 'Проверить',
'val_this_is_current_version' => 'это последняя версия',
'val_version_of' => "Версия $1" ,
'val_table_header' => "<tr><th>Класс</th>$1<th colspan=4>Мнение</th>$1<th>Комментарий</th></tr>\n",
'val_stat_link_text' => 'Статистика проверок для этой статьи',
'val_view_version' => 'Посмотреть эту версию',
'val_validate_version' => 'Проверить эту версию',
'val_user_validations' => 'Этот участник проверил $1 страниц.',
'val_no_anon_validation' => 'Нужно представиться системе для проверки статей.',
'val_validate_article_namespace_only' => 'Можно проверять только статьи. Эта страница <em>не</em> относится к статьям.',
'val_validated' => 'Проверка окончена.',
'val_article_lists' => 'Список проверенных статей',
'val_page_validation_statistics' => 'Статистика проверки страниц для $1',

# Move page
#
'movepage'              => 'Переименовать страницу',
'movepagetext'  => 'Воспользовавшись формой ниже, вы переименуете страницу, одновременно переместив на новое место её журнал изменений.
Старое название станет перенаправлением на новое название.
Ссылки на старое название не будут изменены (обязательно
проверьте наличие двойных и разорванных перенаправлений).
Вы обязаны убедиться в том, что ссылки и далее указывают туда, куда предполагалось.

Обратите внимание, что страница \'\'\'не будет\'\'\' переименована, если страница с новым названием уже существует (кроме случаев, если она является перенаправлением или пуста и и не имеет истории правок). Это означает, что вы можете переименовать страницу обратно в то название, которое у него только что было, если вы переименовали по ошибке, но вы не можете случайно затереть существующую страницу.

\'\'\'ПРЕДУПРЕЖДЕНИЕ!\'\'\'
Переименование может привести к масштабным и неожиданным изменениям для \'\'популярных\'\' страниц. Пожалуйста, прежде, чем вы продолжите, убедитесь, что вы уверены в понимании всех последствий.',
'movepagetalktext' => 'Присоединённая страница обсуждения, если таковая есть,
будет также автоматически переименована, \'\'\'кроме случаев, когда:\'\'\'
*Вы перемещаете страницу из одного пространства имён в другое,
*Не пустая страница обсуждения уже существует под таким же именем или
*Вы не поставили галочку в поле ниже.

В этих случаях, вы будете вынуждены переместить или объединить страницы вручную,
если это нужно.',
'movearticle'   => 'Переименовать страницу',
'movenologin'   => 'Вы не представились системе',
'movenologintext' => "Вы должны [[Special:Userlogin|представиться системе]],
чтобы иметь возможность переименовать страницы.",
'newtitle'              => 'Новое название',
'movepagebtn'   => 'Переименовать страницу',
'pagemovedsub'  => 'Страница переименована',
'pagemovedtext' => "Страница [[$1|«$1»]] переименована в [[$2|«$2»]].",
'articleexists' => 'Страница с таким именем уже существует, или указанное вами название недопустимо.
Пожалуйста, выберите другое название.',
'talkexists'    => "'''Страница была переименована, но страница обсуждения
не может быть переименована, потому что страница с таким названием уже
существует. Пожалуйста, объедините их вручную.'''",
'movedto'               => 'переименована в', 
'movetalk'              => 'Переименовать также и страницу «обсуждения», если это возможно.',
'talkpagemoved' => 'Соответствующая страница обсуждения также переименована.',
'talkpagenotmoved' => 'Соответствующая страница обсуждения <strong>не</strong> была переименована.',
'1movedto2'             => "[[$1|«$1»]] переименована в [[$2|«$2»]]",
'1movedto2_redir' => '[[$1|«$1»]] переименована в [[$2|«$2»]], установлено перенаправление',
'movelogpage' => 'Переименовать журнал',
'movelogpagetext' => 'Ниже представлен список переименованных страниц.',
'movereason'    => 'Причина',
'revertmove'    => 'откат',
'delete_and_move' => 'Удалить и переименовать',
'delete_and_move_text'  =>
'==Требуется удаление==

Страница с именем [[$1|«$1»]] уже существует. Хотите ли вы удалить её, чтобы сделать возможным переименование?',
'delete_and_move_reason' => 'Удалено для возможности переименования',
'selfmove' => "Невозможно переименовать страницу: исходное и новое имя страницы совпадают.",
'immobile_namespace' => "Невозможно переименовать страницу: новое имя содержит зарезервированное служебное слово.",

# Export

'export'                => 'Экспортирование статей',
'exporttext'    => 'Вы можете экспортировать текст и журнал изменений конкретной страницы или набора страниц в XML, который потом может быть импортирован в другую Вики, работающую на программном  обеспечении MediaWiki (к сожалению, функция импортирования не реализована в текущей версии ПО)

Чтобы экспортировать статьи, ввведите их наименования в поле редактирования, одно название на строку, и выберите хотите ли вы экспортировать всю историю изменений статей или только последние версии статей.

Вы также можете использовать специальный адрес для экспорта только последней версии статьи. Например для статьи [[Паровоз]] это будет адрес [[{{ns:special}}:Export/Паровоз]].
',
'exportcuronly' => 'Экспортировать только текущую версию, без истории изменений',

# Namespace 8 related

'allmessages'   => 'Все системные сообщения',
'allmessagesname' => 'Сообщение',
'allmessagesdefault' => 'Текст по умолчанию',
'allmessagescurrent' => 'Текущий текст',
'allmessagestext'       => 'Ниже представлен список всех системных сообщений, доступных в пространстве имён «MediaWiki».',
'allmessagesnotsupportedUI' => 'Текущий установленный язык <strong>$1</strong> не поддерживается Special:AllMessages на этом сайте.',
'allmessagesnotsupportedDB' => 'Special:AllMessages не поддерживается так как wgUseDatabaseMessages отключён.',

# Thumbnails

'thumbnail-more'        => 'Увеличить',
'missingimage'          => "<strong>Изображение не найдено</strong><br /><em>$1</em>\n",
'filemissing'           => 'Файл не найден',

# Special:Import
'import'        => 'Импорт страниц',
 'importinterwiki' => 'Межвики импорт',
'importtext'    => 'Пожалуйста, экспортируйте файл из искодной Вики используя страницу Special:Export, сохраните её на диск, а затем загрузите её оттуда.',
'importfailed'  => "Не удалось импортировать: $1",
'importnotext'  => 'Текст отсутствует',
'importsuccess' => 'Импортировано выполнено!',
'importhistoryconflict' => 'Конфликт существующих версий (возможно, эта страница уже была импортирована)',
'importnosources' => 'Не был выбран источник межвики импорта, прямая загрузка истории изменений отключена.',

# Keyboard access keys for power users
'accesskey-search' => 'f',
'accesskey-minoredit' => 'i',
'accesskey-save' => 's',
'accesskey-preview' => 'p',
'accesskey-diff' => 'd',
'accesskey-compareselectedversions' => 'v',

# tooltip help for some actions, most are in Monobook.js
'tooltip-search' => 'Искать [alt-f]',
'tooltip-minoredit' => 'Отметить это изменение как незначительное [alt-i]',
'tooltip-save' => 'Сохранить ваши изменения [alt-s]',
'tooltip-preview' => 'Предварительный просмотр страницы, пожалуйста, используйте перед сохранением! [alt-p]',
'tooltip-diff' => 'Показать изменения, сделанные по отношению к исходному тексту. [alt-d]',
'tooltip-compareselectedversions' => 'Посмотреть разницу между двумя выбранными версиями этой страницы. [alt-v]',
'tooltip-watch' => 'Добавить эту страницу в ваш список наблюдения [alt-w]',

# stylesheets
'Monobook.css' => '/* edit this file to customize the monobook skin for the entire site */',
#'Monobook.js' => '/* edit this file to change js things in the monobook skin */',

# Metadata
'nodublincore' => 'Метаданные Dublin Core RDF запрещены для этого сервера.',
'nocreativecommons' => 'Метаданные Creative Commons RDF запрещены для этого сервера.',
'notacceptable' => 'Вики-сервер не может предоставить данные в формате который мог бы прочитать ваш браузер.<br />
The wiki server can\'t provide data in a format your client can read.',

# Attribution

'anonymous' => "Анонимные пользователи {{grammar:genitive|{{SITENAME}}}}",
'siteuser' => "Участник {{grammar:genitive|{{SITENAME}}}} $1",
'lastmodifiedby' => "Эта страница последний раз была изменена $1 участником $2.",
'and' => 'и',
'othercontribs' => "Основано на работе $1.",
'others' => 'другие',
'siteusers' => "Участник(и) {{grammar:genitive|{{SITENAME}}}} $1",
'creditspage' => 'Список участников',
'nocredits' => 'Нет списка участников для этой статьи',

# Spam protection

'spamprotectiontitle' => 'Спам-фильтр',
'spamprotectiontext' => 'Страница, которую вы пытаетесь сохранить заблокирована спам-фильтром. Вероятнее всего она содержит ссылку на внешний сайт.

Посмотрите следующие регулярные выражения для шаблонов, которые блокируются:',
'spamprotectionmatch' => 'Следующее сообщение было получено от спам-фильтра: $1',
'subcategorycount' => "Имеется $1 подкатегори(я,ий) в этой категории.",
'subcategorycount1' => "Всего $1 подкатегори(я,ий) в этой категории.",
'categoryarticlecount' => "Имеется $1 статьи(я, ей) в этой категории.",
'categoryarticlecount1' => "Имеется $1 статьи(я, ей) в этой категории.",
'usenewcategorypage' => "1\n\nУстановите первый символ в «0» чтобы заблокировать новое размещение страницы категории.",
'listingcontinuesabbrev' => " <em><small>(продолжение)</small></em>",

# Info page
'infosubtitle' => 'Информация о странице',
'numedits' => 'Число правок (статья): $1',
'numtalkedits' => 'Число правок (страница обсуждения): $1',
'numwatchers' => 'Число наблюдателей: $1',
'numauthors' => 'Число различных авторов (статья): $1',
'numtalkauthors' => 'Число различных авторов (страница обсуждения): $1',

# Math options
'mw_math_png' => 'Всегда генерировать PNG',
'mw_math_simple' => 'HTML в простых случаях, иначе PNG',
'mw_math_html' => 'HTML если возможно, иначе PNG',
'mw_math_source' => 'Оставить в разметке ТеХ (для текстовых браузеров)',
'mw_math_modern' => 'Как рекомендуется для современных браузеров',
'mw_math_mathml' => 'MathML если возможно (экспериментальная опция)',

# Patrolling
'markaspatrolleddiff'   => "Пометить как проверенную",
'markaspatrolledlink'   => "[$1]",
'markaspatrolledtext'   => "Пометить эту статью как проверенную",
'markedaspatrolled'     => "Помечена как проверенная",
'markedaspatrolledtext' => "Выбранная версия помечена как проверенная.",
'rcpatroldisabled'      => "Патрулирование последних изменений запрещено",
'rcpatroldisabledtext'  => "Возможность патрулирования последних изменений в настоящее время отключена.",

# Monobook.js: tooltips and access keys for monobook
'Monobook.js' => '/* tooltips and access keys */
ta = new Object();
ta[\'pt-userpage\'] = new Array(\'.\',\'Моя страница пользователя\');
ta[\'pt-anonuserpage\'] = new Array(\'.\',\'Страница пользователя для моего IP\');
ta[\'pt-mytalk\'] = new Array(\'n\',\'Моя страница обсуждений\');
ta[\'pt-anontalk\'] = new Array(\'n\',\'Страница обсуждений для моего IP\');
ta[\'pt-preferences\'] = new Array(\'\',\'Мои настройки\');
ta[\'pt-watchlist\'] = new Array(\'l\',\'Список страниц моего наблюдения\');
ta[\'pt-mycontris\'] = new Array(\'y\',\'Список страниц, которые я редактировал\');
ta[\'pt-login\'] = new Array(\'o\',\'Здесь можно зарегистрироваться в системе, но это необязательно\');
ta[\'pt-anonlogin\'] = new Array(\'o\',\'Здесь можно зарегистрироваться в системе, но это необязательно\');
ta[\'pt-logout\'] = new Array(\'o\',\'Отказаться от регистрации\');
ta[\'ca-talk\'] = new Array(\'t\',\'Обсуждение статьи\');
ta[\'ca-edit\'] = new Array(\'e\',\'Эту статью можно изменять. Перед сохранением изменений, пожалуйста, нажмите кнопку предварительного просмотра для визуальной проверки результата\');
ta[\'ca-addsection\'] = new Array(\'+\',\'Добавить комментарий к обсуждению\');
ta[\'ca-viewsource\'] = new Array(\'e\',\'Эта страница защищена от изменений, но вы можете посмотреть и скопировать её исходный текст\');
ta[\'ca-history\'] = new Array(\'h\',\'Журнал изменений страницы\');
ta[\'ca-protect\'] = new Array(\'=\',\'Защитить страницу от изменений\');
ta[\'ca-delete\'] = new Array(\'d\',\'Удалить эту страницу\');
ta[\'ca-undelete\'] = new Array(\'d\',\'Восстановить исправления страницы, сделанные до того, как она была удалена\');
ta[\'ca-move\'] = new Array(\'m\',\'Переименовать страницу\');
ta[\'ca-nomove\'] = new Array(\'\',\'У вас не хватает прав чтобы переименовать эту страницу\');
ta[\'ca-watch\'] = new Array(\'w\',\'Добавить эту страницу в ваш список наблюдения\');
ta[\'ca-unwatch\'] = new Array(\'w\',\'Удалить эту страницу из вашего списка наблюдения\');
ta[\'search\'] = new Array(\'f\',\'Искать это слово\');
ta[\'p-logo\'] = new Array(\'\',\'Заглавная страница\');
ta[\'n-mainpage\'] = new Array(\'z\',\'Перейти на заглавную страницу\');
ta[\'n-portal\'] = new Array(\'\',\'О проекте, о том, что вы можете сделать, где что находится\');
ta[\'n-currentevents\'] = new Array(\'\',\'Список текущих событий\');
ta[\'n-recentchanges\'] = new Array(\'r\',\'Список последних изменений\');
ta[\'n-randompage\'] = new Array(\'x\',\'Посмотреть случайную страницу\');
ta[\'n-help\'] = new Array(\'\',\'Справочник по проекту «{{SITENAME}}»\');
ta[\'n-sitesupport\'] = new Array(\'\',\'Поддержите проект\');
ta[\'t-whatlinkshere\'] = new Array(\'j\',\'Список всех страниц, которые ссылаются на эту страницу\');
ta[\'t-recentchangeslinked\'] = new Array(\'k\',\'Последние изменения в страницах, которые ссылаются на эту страницу\');
ta[\'feed-rss\'] = new Array(\'\',\'Трансляция в формате RSS для этой страницы\');
ta[\'feed-atom\'] = new Array(\'\',\'Трансляция в формате Atom для этой страницы\');
ta[\'t-contributions\'] = new Array(\'\',\'Список страниц, которые изменял этот участник\');
ta[\'t-emailuser\'] = new Array(\'\',\'Отправить письмо этому участнику\');
ta[\'t-upload\'] = new Array(\'u\',\'Загрузить изображения или мультимедиа-файлы\');
ta[\'t-specialpages\'] = new Array(\'q\',\'Список служебных страниц\');
ta[\'ca-nstab-main\'] = new Array(\'c\',\'Содержание статьи\');
ta[\'ca-nstab-user\'] = new Array(\'c\',\'Персональная страница участника\');
ta[\'ca-nstab-media\'] = new Array(\'c\',\'Мультимедиа-файл\');
ta[\'ca-nstab-special\'] = new Array(\'\',\'Это служебная страница, она недоступна для редактирования\');
ta[\'ca-nstab-wp\'] = new Array(\'a\',\'Страница проекта\');
ta[\'ca-nstab-image\'] = new Array(\'c\',\'Страница изображения\');
ta[\'ca-nstab-mediawiki\'] = new Array(\'c\',\'Страница сообщения MediaWiki\');
ta[\'ca-nstab-template\'] = new Array(\'c\',\'Страница шаблона\');
ta[\'ca-nstab-help\'] = new Array(\'c\',\'Страница справки\');
ta[\'ca-nstab-category\'] = new Array(\'c\',\'Страница категории\');
',

# image deletion
'deletedrevision' => 'Удалена страя версия $1.',

# browsing diffs
'previousdiff' => '← К предыдущему изменению',
'nextdiff' => 'К след. изменению →',

'imagemaxsize' => 'Ограничивать изображения на странице изображений до: ',
'thumbsize'    => 'Размер уменьшенной версии изображения: ',
'showbigimage' => 'Загрузить с высоким разрешением ($1x$2, $3 Кбайт)',

'newimages' => 'Галерея новых изображений',
'noimages'  => 'Изображения отсутствуют.',

# labels for User: and Title: on Special:Log pages
'specialloguserlabel' => 'Участник: ',
'speciallogtitlelabel' => 'Название: ',

'passwordtooshort' => 'Введённый пароль слишком короткий. Пароль должен состоять не менее чем из $1 символов.',

# Media Warning
'mediawarning' => '\'\'\'Внимание\'\'\': файл может содержать злонамеренный программный код, способный повредить вашей системе. <hr>',
'fileinfo' => '$1 Кб, MIME-тип: <code>$2</code>',

# Exif data
'metadata' => 'Метаданные',

# Exif tags
'exif-imagewidth' =>'Ширина',
'exif-imagelength' =>'Высота',
'exif-bitspersample' =>'Глубина цвета',
'exif-compression' =>'Метод сжатия',
'exif-photometricinterpretation' =>'Цветовая модель',
'exif-orientation' =>'Ориентация кадра',
'exif-samplesperpixel' =>'Количество цветовых компонентов',
'exif-planarconfiguration' =>'Принцип организации данных',
'exif-ycbcrsubsampling' =>'Отношение размеров компонент Y и C',
'exif-ycbcrpositioning' =>'Порядок размещения компонент Y и C ',
'exif-xresolution' =>'Разрешение по ширине (оси X)',
'exif-yresolution' =>'Разрешение по высоте (оси Y)',
'exif-resolutionunit' =>'Единица измерения разрешения',
'exif-stripoffsets' =>'Положение блока данных',
'exif-rowsperstrip' =>'Количество строк в 1 блоке',
'exif-stripbytecounts' =>'Размер сжатого блока',
'exif-jpeginterchangeformat' =>'Положение начала блока preview',
'exif-jpeginterchangeformatlength' =>'Размер данных блока preview',
'exif-transferfunction' =>'Функция преобразования цветового пространства',
'exif-whitepoint' =>'Цветность белой точки',
'exif-primarychromaticities' =>'Цветность основных цветов',
'exif-ycbcrcoefficients' =>'Коэффициенты преобразования цветовой модели',
'exif-referenceblackwhite' =>'Положение белой и чёрной точек',
'exif-datetime' =>'Дата и время изменения файла',
'exif-imagedescription' =>'Название изображения',
'exif-make' =>'Производитель камеры',
'exif-model' =>'Модель камеры',
'exif-software' =>'Программное обеспечение',
'exif-artist' =>'Автор',
'exif-copyright' =>'Владелец авторского права',
'exif-exifversion' =>'Версия Exif',
'exif-flashpixversion' =>'Поддерживаемая версия FlashPix',
'exif-colorspace' =>'Цветовое пространство',
'exif-componentsconfiguration' =>'Конфигурация цветовых компонентов',
'exif-compressedbitsperpixel' =>'Глубина цвета после сжатия',
'exif-pixelydimension' =>'Полная высота изображения',
'exif-pixelxdimension' =>' Полная ширина изображения ',
'exif-makernote' =>'Дополнительные данные производителя',
'exif-usercomment' =>'Дополнительный комментарий',
'exif-relatedsoundfile' =>'Файл звукового комментария',
'exif-datetimeoriginal' =>'Оригинальные дата и время',
'exif-datetimedigitized' =>'Дата и время оцифровки',
'exif-subsectime' =>'Доли секунд времени изменения файла',
'exif-subsectimeoriginal' =>'Доли секунд оригинального времени',
'exif-subsectimedigitized' =>'Доли секунд времени оцифровки',
'exif-exposuretime' =>'Время экспозиции',
'exif-fnumber' =>'Число диафрагмы',
'exif-exposureprogram' =>'Программа экспозиции',
'exif-spectralsensitivity' =>'Спектральная чувствительность',
'exif-isospeedratings' =>'Светочувствительность ISO',
'exif-oecf' =>'OECF (коэффициент оптоэлектрического преобразования)',
'exif-shutterspeedvalue' =>'Выдержка',
'exif-aperturevalue' =>'Диафрагма',
'exif-brightnessvalue' =>'Яркость',
'exif-exposurebiasvalue' =>'Компенсация экспозиции',
'exif-maxaperturevalue' =>'Минимальное число диафрагмы',
'exif-subjectdistance' =>'Расстояние до объекта',
'exif-meteringmode' =>'Режим замера экспозиции',
'exif-lightsource' =>'Источник света',
'exif-flash' =>'Статус вспышки',
'exif-focallength' =>'Фокусное расстояние',
'exif-subjectarea' =>'Положение и площадь объекта съёмки',
'exif-flashenergy' =>'Энергия вспышки',
'exif-spatialfrequencyresponse' =>'Пространственная частотная характеристика',
'exif-focalplanexresolution' =>'Разрешение по X в фокальной плоскости',
'exif-focalplaneyresolution' =>'Разрешение по Y в фокальной плоскости ',
'exif-focalplaneresolutionunit' =>'Единица измерения разрешения в фокальной плоскости',
'exif-subjectlocation' =>'Положение объекта относительно левого верхнего угла',
'exif-exposureindex' =>'Индекс экспозиции',
'exif-sensingmethod' =>'Тип сенсора',
'exif-filesource' =>'Источник файла',
'exif-scenetype' =>'Тип сцены',
'exif-cfapattern' =>'Тип цветового фильтра',
'exif-customrendered' =>'Дополнительная обработка',
'exif-exposuremode' =>'Режим выбора экспозиции',
'exif-whitebalance' =>'Баланс белого',
'exif-digitalzoomratio' =>'Коэффициент цифрового увеличения (цифровой зум)',
'exif-focallengthin35mmfilm' =>'Эквивалентное фокусное расстояние (для 35 мм плёнки)',
'exif-scenecapturetype' =>'Тип сцены при съёмке',
'exif-gaincontrol' =>'Повышение яркости',
'exif-contrast' =>'Контрастность',
'exif-saturation' =>'Насыщенность',
'exif-sharpness' =>'Резкость',
'exif-devicesettingdescription' =>'Описание предустановок камеры',
'exif-subjectdistancerange' =>'Расстояние до объекта съёмки',
'exif-imageuniqueid' =>'Номер изображения (ID)',

'exif-gpsversionid' =>'Версия блока GPS-информации',
'exif-gpslatituderef' =>'Индекс широты',
'exif-gpslatitude' =>'Широта',
'exif-gpslongituderef' =>'Индекс долготы',
'exif-gpslongitude' =>'Долгота',
'exif-gpsaltituderef' =>'Индекс высоты',
'exif-gpsaltitude' =>'Высота',
'exif-gpstimestamp' =>'Точное время по UTC',
'exif-gpssatellites' =>'Описание использованных спутников',
'exif-gpsstatus' =>'Статус приёмника в момент съёмки',
'exif-gpsmeasuremode' =>'Метод измерения положения',
'exif-gpsdop' =>'Точность измерения',
'exif-gpsspeedref' =>'Единицы измерения скорости',
'exif-gpsspeed' =>'Скорость движения',
'exif-gpstrackref' =>'Тип азимута приёмника GPS (истинный, магнитный)',
'exif-gpstrack' =>'Азимут приёмника GPS',
'exif-gpsimgdirectionref' =>'Тип азимута изображения (истинный, магнитный)',
'exif-gpsimgdirection' =>'Азимут изображения',
'exif-gpsmapdatum' =>'Использованная геодезическая система координат',
'exif-gpsdestlatituderef' =>'Индекс долготы объекта',
'exif-gpsdestlatitude' =>'Долгота объекта',
'exif-gpsdestlongituderef' =>'Индекс широты объекта',
'exif-gpsdestlongitude' =>'Широта объекта',
'exif-gpsdestbearingref' =>'Тип пеленга объекта (истинный, магнитный)',
'exif-gpsdestbearing' =>'Пеленг объекта',
'exif-gpsdestdistanceref' =>'Единицы измерения расстояния',
'exif-gpsdestdistance' =>'Расстояние',
'exif-gpsprocessingmethod' =>'Метод вычисления положения',
'exif-gpsareainformation' =>'Название области GPS',
'exif-gpsdatestamp' =>'Дата ',
'exif-gpsdifferential' =>'Дифференциальная поправка',

# Exif attributes

'exif-compression-1' => 'Несжатый',
'exif-compression-6' => 'JPEG',

'exif-photometricinterpretation-1' => 'RGB',
'exif-photometricinterpretation-6' => 'YCbCr',

'exif-orientation-1' => 'Нормальная', // 0th row: top; 0th column: left
'exif-orientation-2' => 'Отражено по горизонтали', // 0th row: top; 0th column: right
'exif-orientation-3' => 'Повёрнуто на 180°', // 0th row: bottom; 0th column: right
'exif-orientation-4' => 'Отражено по вертикали', // 0th row: bottom; 0th column: left
'exif-orientation-5' => 'Повёрнуто на 90° против часовой стрелки и отражено по вертикали', // 0th row: left; 0th column: top
'exif-orientation-6' => 'Повёрнуто на 90° по часовой стрелке', // 0th row: right; 0th column: top
'exif-orientation-7' => 'Повёрнуто на 90° по часовой стрелке и отражено по вертикали', // 0th row: right; 0th column: bottom
'exif-orientation-8' => 'Повёрнуто на 90° против часовой стрелки', // 0th row: left; 0th column: bottom

'exif-planarconfiguration-1' => 'chunky format',
'exif-planarconfiguration-2' => 'planar format',

'exif-resolutionunit-2' => 'Дюймы',
'exif-resolutionunit-3' => 'Сантиметры',

'exif-colorspace-1' => 'sRGB',
'exif-colorspace-ffff.h' => 'FFFF.H',

'exif-componentsconfiguration-0' => 'не существует',
'exif-componentsconfiguration-1' => 'Y',
'exif-componentsconfiguration-2' => 'Cb',
'exif-componentsconfiguration-3' => 'Cr',
'exif-componentsconfiguration-4' => 'R',
'exif-componentsconfiguration-5' => 'G',
'exif-componentsconfiguration-6' => 'B',

'exif-exposureprogram-0' => 'Неизвестно',
'exif-exposureprogram-1' => 'Ручной режим',
'exif-exposureprogram-2' => 'Программный режим (нормальный)',
'exif-exposureprogram-3' => 'Приоритет диафрагмы',
'exif-exposureprogram-4' => 'Приоритет выдержки',
'exif-exposureprogram-5' => 'Художественная программа (на основе нужной глубины резкости)',
'exif-exposureprogram-6' => 'Спортивный режим (с минимальной выдержкой)',
'exif-exposureprogram-7' => 'Портретный режим (для снимков на близком расстоянии, с фоном не в фокусе)',
'exif-exposureprogram-8' => 'Пейзажный режим (для пейзажных снимков, с фоном в фокусе)',

'exif-meteringmode-0' => 'Неизвестно',
'exif-meteringmode-1' => 'Средний',
'exif-meteringmode-2' => 'Центровзвешенный',
'exif-meteringmode-3' => 'Точечный',
'exif-meteringmode-4' => 'Мультиточечный',
'exif-meteringmode-5' => 'Матричный',
'exif-meteringmode-6' => 'Частичный',
'exif-meteringmode-255' => 'Другой',

'exif-lightsource-0' => 'Неизвестно',
'exif-lightsource-1' => 'Дневной свет',
'exif-lightsource-2' => 'Лампа дневного света',
'exif-lightsource-3' => 'Лампа накаливания',
'exif-lightsource-4' => 'Вспышка',
'exif-lightsource-9' => 'Хорошая погода',
'exif-lightsource-10' => 'Облачно',
'exif-lightsource-11' => 'Тень',
'exif-lightsource-12' => 'Лампа дневного света тип D (5700 - 7100K)',
'exif-lightsource-13' => 'Лампа дневного света тип N (4600 - 5400K)',
'exif-lightsource-14' => 'Лампа дневного света тип W (3900 - 4500K)',
'exif-lightsource-15' => 'Лампа дневного света тип WW (3200 - 3700K)',
'exif-lightsource-17' => 'Стандартный источник света типа A',
'exif-lightsource-18' => 'Стандартный источник света типа B',
'exif-lightsource-19' => 'Стандартный источник света типа C',
'exif-lightsource-20' => 'D55',
'exif-lightsource-21' => 'D65',
'exif-lightsource-22' => 'D75',
'exif-lightsource-23' => 'D50',
'exif-lightsource-24' => 'Студийная лампа стандарта ISO',
'exif-lightsource-255' => 'Другой источник света',

'exif-sensingmethod-1' => 'Неопределённый',
'exif-sensingmethod-2' => 'Однокристальный матричный цветной сенсор',
'exif-sensingmethod-3' => 'Цветной сенсор с двумя матрицами',
'exif-sensingmethod-4' => 'Цветной сенсор с тремя матрицами',
'exif-sensingmethod-5' => 'Матричный сенсор с последовательным измерением цвета',
'exif-sensingmethod-7' => 'Трёхцветный линейный сенсор',
'exif-sensingmethod-8' => 'Линейный сенсор с последовательным измерением цвета',

'exif-filesource-3' => 'Цифровой фотоаппарат',

'exif-scenetype-1' => 'Изображение сфотографировано напрямую',

'exif-customrendered-0' => 'Не производилась',
'exif-customrendered-1' => 'Нестандартная обработка',

'exif-exposuremode-0' => 'Автоматическая экспозиция',
'exif-exposuremode-1' => 'Ручная установка экспозиции',
'exif-exposuremode-2' => 'Брэкетинг',

'exif-whitebalance-0' => 'Автоматический баланс белого',
'exif-whitebalance-1' => 'Ручная установка баланса белого',

'exif-scenecapturetype-0' => 'Стандартный',
'exif-scenecapturetype-1' => 'Ландшафт',
'exif-scenecapturetype-2' => 'Портрет',
'exif-scenecapturetype-3' => 'Ночная съёмка',

'exif-gaincontrol-0' => 'Нет',
'exif-gaincontrol-1' => 'Небольшое увеличение',
'exif-gaincontrol-2' => 'Большое увеличение',
'exif-gaincontrol-3' => 'Небольшое уменьшение',
'exif-gaincontrol-4' => 'Сильное уменьшение',

'exif-contrast-0' => 'Нормальная',
'exif-contrast-1' => 'Мягкое повышение',
'exif-contrast-2' => 'Сильное повышение',

'exif-saturation-0' => 'Нормальная',
'exif-saturation-1' => 'Небольшая насыщенность',
'exif-saturation-2' => 'Большая насыщенность',

'exif-sharpness-0' => 'Нормальная',
'exif-sharpness-1' => 'Мягкое повышение',
'exif-sharpness-2' => 'Сильное повышение',

'exif-subjectdistancerange-0' => 'Неизвестно',
'exif-subjectdistancerange-1' => 'Макросъёмка',
'exif-subjectdistancerange-2' => 'Съёмка с близкого расстояния',
'exif-subjectdistancerange-3' => 'Съёмка издалека',

// Pseudotags used for GPSLatitudeRef and GPSDestLatitudeRef
'exif-gpslatitude-n' => 'северной широты',
'exif-gpslatitude-s' => 'южной широты',

// Pseudotags used for GPSLongitudeRef and GPSDestLongitudeRef
'exif-gpslongitude-e' => 'восточной долготы',
'exif-gpslongitude-w' => 'западной долготы',

'exif-gpsstatus-a' => 'Измерение не закончено',
'exif-gpsstatus-v' => 'Готов к передаче данных',

'exif-gpsmeasuremode-2' => 'Измерение 2-х координат',
'exif-gpsmeasuremode-3' => 'Измерение 3-х координат ',

// Pseudotags used for GPSSpeedRef and GPSDestDistanceRef
'exif-gpsspeed-k' => 'км/час',
'exif-gpsspeed-m' => 'миль/час',
'exif-gpsspeed-n' => 'узлов',

// Pseudotags used for GPSTrackRef, GPSImgDirectionRef and GPSDestBearingRef
'exif-gpsdirection-t' => 'истинный',
'exif-gpsdirection-m' => 'магнитный',

# external editor support
'edit-externally' => 'Редактировать этот файл используя внешнюю программу',
'edit-externally-help' => 'Подробности см. на странице [http://meta.wikimedia.org/wiki/Help:External_editors Meta:Help:External_editors].',

# 'all' in various places, this might be different for inflicted languages
'recentchangesall' => 'все',
'imagelistall' => 'все',
'watchlistall1' => 'все',
'watchlistall2' => 'все',
'contributionsall' => 'все',

# E-mail address confirmation
'confirmemail' => 'Подтверждение адреса электронной почты',
'confirmemail_text' => "Вики-движок требует подтверждения адреса электронной почты перед тем, как начать с ним работать. 
Нажмите на кнопку, чтобы на указанный адрес было отправлено письмо, сореджащее ссылку на специальную страницу, после открытия которой в браузере адрес электронной почты будет считается подтверждённым.",

'confirmemail_send' => 'Отправить письмо с запросом на подтверждение',
'confirmemail_sent' => 'Письмо с запросом на подтверждение отправлено.',
'confirmemail_sendfailed' => 'Невозможно отправить письмо с запросом на подтверждение. Проверье правильность адреса электронной почты.',
'confirmemail_invalid' => 'Направильный код подтверждения или срок действия кода истёк.',
'confirmemail_success' => 'Ваш адрес электронной почты подтверждён.',
'confirmemail_loggedin' => 'Ваш адрес электронной почты подтверждён.',
'confirmemail_error' => 'Во время процедуры подтверждения адреса электронной почты произошла ошибка.',

'confirmemail_subject' => '{{SITENAME}}:Запрос на подтверждения адреса эл. почты',
'confirmemail_body' => "Кто-то с IP-адресом $1, зарегистрировал на сервере проекта {{SITENAME}} учётную запись
\"$2\" указав ваш адрес электронной почты.

Чтобы подтвердить, что вы разрешаете использовать ваш адрес электронной почты  в этом проекте откройте в браузере приведённую ниже ссылку (это нужно сделать до $4):

$3

Если вы не отправляли подобного запроса - просто проигнорируйте данное письмо.",

# Inputbox extension, may be useful in other contexts as well
'tryexact' => 'Строгий поиск',
'searchfulltext' => 'Полнотекстовый поиск',
'createarticle' => 'Создать статью',

# Scary transclusion
'scarytranscludedisabled' => '[«Interwiki transcluding» отключён]',
'scarytranscludefailed' => '[К сожалению, обращение к шаблону не удалось]',
'scarytranscludetoolong' => '[К сожалению, URL слишком длинный]',

);

/* Please, see Language.php for general function comments */
class LanguageRu extends LanguageUtf8 {
        function LanguageRu() {
                global $wgNamespaceNamesRu, $wgMetaNamespace;
                LanguageUtf8::LanguageUtf8();
                $wgNamespaceNamesRu[NS_PROJECT_TALK] = 'Обсуждение_' . $this->convertGrammar( $wgMetaNamespace, 'genitive' );
        }

        function getNamespaces() {
                global $wgNamespaceNamesRu;
                return $wgNamespaceNamesRu;
        }

        function getQuickbarSettings() {
                global $wgQuickbarSettingsRu;
                return $wgQuickbarSettingsRu;
        }

        function getSkinNames() {
                global $wgSkinNamesRu;
                return $wgSkinNamesRu;
        }

        function getDateFormats() {
                global $wgDateFormatsRu;
                return $wgDateFormatsRu;
        }

        function getValidSpecialPages()
        {
                global $wgValidSpecialPagesRu;
                return $wgValidSpecialPagesRu;
        }

        function getSysopSpecialPages()
        {
                global $wgSysopSpecialPagesRu;
                return $wgSysopSpecialPagesRu;
        }

        function getDeveloperSpecialPages()
        {
                global $wgDeveloperSpecialPagesRu;
                return $wgDeveloperSpecialPagesRu;
        }

        function getMessage( $key )
        {
                global $wgAllMessagesRu;
		return isset($wgAllMessagesRu[$key]) ? $wgAllMessagesRu[$key] : parent::getMessage($key);
        }

        function fallback8bitEncoding() {
                return "windows-1251";
        }

        function getMagicWords()  {
                global $wgMagicWordsRu;
                return $wgMagicWordsRu;
        }

        # Convert from the nominative form of a noun to some other case
        # Invoked with {{grammar:case|word}}
        function convertGrammar( $word, $case ) {
                # These rules are not perfect, but they are currently only used for site names so it doesn't
                # matter if they are wrong sometimes. Just add a special case for your site name if necessary. 

                #join and array_slice instead mb_substr

                preg_match_all( '/./us', $word, $ar );
                if (!preg_match("/[a-zA-Z_]/us", $word))
                        switch ( $case ) {
                                case 'genitive': #родительный падеж  
                                        if ((join('',array_slice($ar[0],-4))=='вики') || (join('',array_slice($ar[0],-4))=='Вики'))
                                                {}
                                        elseif (join('',array_slice($ar[0],-1))=='ь')
                                                $word = join('',array_slice($ar[0],0,-1)).'я';
                                        elseif (join('',array_slice($ar[0],-2))=='ия')
                                                $word=join('',array_slice($ar[0],0,-2)).'ии';
                                        elseif (join('',array_slice($ar[0],-2))=='ти')
                                                $word=join('',array_slice($ar[0],0,-2)).'тей';
                                        elseif (join('',array_slice($ar[0],-2))=='ды')
                                                $word=join('',array_slice($ar[0],0,-2)).'дов';
                                        elseif (join('',array_slice($ar[0],-3))=='ник')
                                                $word=join('',array_slice($ar[0],0,-3)).'ника';
                                        break;
                                case 'dative':  #дательный падеж
                                        #stub 
                                        break;
                                case 'accusative': #винительный падеж
                                        #stub 
                                        break;
                                case 'instrumental':  #творительный падеж
                                        #stub 
                                        break;
                                case 'prepositional': #предложный падеж
                                        #stub 
                                        break;
                        }

                return $word;
        }

	function formatNum( $number ) {
		global $wgTranslateNumerals;
		return $wgTranslateNumerals ? strtr($number, '.,', ', ' ) : $number;
	}
	
}

?>
