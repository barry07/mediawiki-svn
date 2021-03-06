#include <antlr3.h>
#include <mwkeyvalue.h>
#include <mwlistener.h>
#include <assert.h>
#include <stdbool.h>
#include <mwscriptbuf.h>
#include <mwlinkresolution.h>
#include <mwlinkcollection.h>
#include <mwlinkresolvercallback.h>
#include <mwmedialinkoption.h>

/*
 * A note on memory management:  All parameters of type pANTLR3_STRING
 * or pANTLR3_VECTOR have been allocated by the antlr runtime via
 * factory objects and will be reclaimed when the parser is reset or
 * free:d.
 *
 * Attribute parameters (of type pANTLR3_VECTOR) will be NULL, if the
 * corresponding production did not have any attributes.  It is up to the
 * listener to validate and interprete the attributes.
 *
 * Furthermore, the attribute vectors contain pointers to elements of
 * type MWKEYVALUE.
 */

static void SBOnWord(MWLISTENER *listener, pANTLR3_STRING word);
static void SBOnSpecial(MWLISTENER *listener, pANTLR3_STRING special);
static void SBOnSpace(MWLISTENER *listener, pANTLR3_STRING space);
static void SBOnNewline(MWLISTENER *listener);
static void SBOnBr(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBOnNowiki(MWLISTENER *listener, pANTLR3_STRING nowiki);
static void SBOnHTMLEntity(MWLISTENER *listener, pANTLR3_STRING entity);
static void SBOnHorizontalRule(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBBeginParagraph(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndParagraph(MWLISTENER *listener);
static void SBBeginArticle(MWLISTENER *listener);
static void SBEndArticle(MWLISTENER *listener);
static void SBBeginItalic(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndItalic(MWLISTENER *listener);
static void SBBeginBold(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndBold(MWLISTENER *listener);
static void SBBeginPre(MWLISTENER *listener);
static void SBEndPre(MWLISTENER *listener);
static void SBBeginBulletList(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndBulletList(MWLISTENER *listener);
static void SBBeginEnumerationList(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndEnumerationList(MWLISTENER *listener);
static void SBBeginDefinitionList(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndDefinitionList(MWLISTENER *listener);
static void SBBeginBulletListItem(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndBulletListItem(MWLISTENER *listener);
static void SBBeginEnumerationItem(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndEnumerationItem(MWLISTENER *listener);
static void SBBeginDefinedTermItem(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndDefinedTermItem(MWLISTENER *listener);
static void SBBeginDefinitionItem(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndDefinitionItem(MWLISTENER *listener);
static void SBBeginTableOfContents(MWLISTENER *listener);
static void SBEndTableOfContents(MWLISTENER *listener);
static void SBBeginTableOfContentsItem(MWLISTENER *listener, int level, pANTLR3_STRING anchor);
static void SBEndTableOfContentsItem(MWLISTENER *listener);
static void SBBeginTable(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndTable(MWLISTENER *listener);
static void SBBeginTableRow(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndTableRow(MWLISTENER *listener);
static void SBBeginTableCell(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndTableCell(MWLISTENER *listener);
static void SBBeginTableHeading(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndTableHeading(MWLISTENER *listener);
static void SBBeginTableCaption(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndTableCaption(MWLISTENER *listener);
static void SBBeginTableBody(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndTableBody(MWLISTENER *listener);
static void SBBeginHeading(MWLISTENER *listener, int level, pANTLR3_STRING anchor, pANTLR3_VECTOR attr);
static void SBEndHeading(MWLISTENER *listener);
static void SBBeginHtmlDiv(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlDiv(MWLISTENER *listener);
static void SBBeginHtmlBlockquote(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlBlockquote(MWLISTENER *listener);
static void SBBeginHtmlCenter(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlCenter(MWLISTENER *listener);
static void SBBeginInternalLink(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndInternalLink(MWLISTENER *listener);
static void SBOnInternalLink(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBBeginExternalLink(MWLISTENER *listener, pANTLR3_STRING linkUrl);
static void SBEndExternalLink(MWLISTENER *listener);
static void SBOnExternalLink(MWLISTENER *listener, pANTLR3_STRING linkUrl);
static void SBBeginMediaLink(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndMediaLink(MWLISTENER *listener);
static void SBOnMediaLink(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBOnTagExtension(MWLISTENER *listener, const char * name, pANTLR3_STRING body, pANTLR3_VECTOR attr);
static void SBBeginHtmlU(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlU(MWLISTENER *listener);
static void SBBeginHtmlDel(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlDel(MWLISTENER *listener);
static void SBBeginHtmlIns(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlIns(MWLISTENER *listener);
static void SBBeginHtmlFont(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlFont(MWLISTENER *listener);
static void SBBeginHtmlBig(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlBig(MWLISTENER *listener);
static void SBBeginHtmlSmall(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlSmall(MWLISTENER *listener);
static void SBBeginHtmlSub(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlSub(MWLISTENER *listener);
static void SBBeginHtmlSup(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlSup(MWLISTENER *listener);
static void SBBeginHtmlCite(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlCite(MWLISTENER *listener);
static void SBBeginHtmlCode(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlCode(MWLISTENER *listener);
static void SBBeginHtmlStrike(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlStrike(MWLISTENER *listener);
static void SBBeginHtmlStrong(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlStrong(MWLISTENER *listener);
static void SBBeginHtmlSpan(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlSpan(MWLISTENER *listener);
static void SBBeginHtmlTt(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlTt(MWLISTENER *listener);
static void SBBeginHtmlVar(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlVar(MWLISTENER *listener);
static void SBBeginHtmlAbbr(MWLISTENER *listener, pANTLR3_VECTOR attr);
static void SBEndHtmlAbbr(MWLISTENER *listener);
static void SBOnHtmlPre(MWLISTENER *listener, pANTLR3_STRING body, pANTLR3_VECTOR attr);
static void SBBeginGarbage(MWLISTENER *listener);
static void SBEndGarbage(MWLISTENER *listener);
static void * SBNew(void);
static void SBReset(void *data);
static void SBFree(void *data);
static void * SBGetResult(MWLISTENER *listener);
static void SBLinkResolver(MWLINKCOLLECTION *linkCollection, void *data);
static void SBSetLinkResolverData(void *listenerData, void **linkResolverData);

/**
 * Data storage for the listener.
 */
typedef struct SCRIPT_BUF_struct
{
    MWSCRIPTBUF buf;
    pANTLR3_STRING_FACTORY stringFactory;
    int headingLevel;
    void *scriptCallbackData;

    bool renderMarkup;
    const char *height;
    const char *width;
    const char *url;
    const char *imageUrl;
    const char *alt;
    int mediaLinkEndDivs;
    MWSCRIPTBUF_INDEX startCaption;
} 
    SCRIPT_BUF;

#define BUF (&DATA->buf)

/**
 * Macro for accessing the data.
 */
#define DATA \
   ((SCRIPT_BUF *)listener->data)

/**
 * The listener instance.
 */
const MWLISTENER mwScriptBufferListener = {
    .newData                  = SBNew,
    .freeData                 = SBFree,
    .resetData                = SBReset,
    .linkResolver             = SBLinkResolver,
    .setLinkResolverData      = SBSetLinkResolverData,
    .getResult                = SBGetResult,
    .onWord                   = SBOnWord,
    .onSpecial                = SBOnSpecial,
    .onSpace                  = SBOnSpace,
    .onNewline                = SBOnNewline,
    .onBr                     = SBOnBr,
    .beginParagraph           = SBBeginParagraph,
    .endParagraph             = SBEndParagraph,
    .beginArticle             = SBBeginArticle,
    .endArticle               = SBEndArticle,
    .beginItalic              = SBBeginItalic,
    .endItalic                = SBEndItalic,
    .beginBold                = SBBeginBold,
    .endBold                  = SBEndBold,
    .beginPre                 = SBBeginPre,
    .endPre                   = SBEndPre,
    .beginTable               = SBBeginTable,
    .endTable                 = SBEndTable,
    .beginTableRow            = SBBeginTableRow,
    .endTableRow              = SBEndTableRow,
    .beginTableCell           = SBBeginTableCell,
    .endTableCell             = SBEndTableCell,
    .beginTableHeading        = SBBeginTableHeading,
    .endTableHeading          = SBEndTableHeading,
    .beginTableCaption        = SBBeginTableCaption,
    .endTableCaption          = SBEndTableCaption,
    .beginTableBody           = SBBeginTableBody,
    .endTableBody             = SBEndTableBody,
    .onNowiki                 = SBOnNowiki,
    .onHTMLEntity             = SBOnHTMLEntity,
    .onHorizontalRule         = SBOnHorizontalRule,
    .beginHeading             = SBBeginHeading,
    .endHeading               = SBEndHeading,
    .beginInternalLink        = SBBeginInternalLink,
    .endInternalLink          = SBEndInternalLink,
    .onInternalLink           = SBOnInternalLink,
    .beginExternalLink        = SBBeginExternalLink,
    .endExternalLink          = SBEndExternalLink,
    .onExternalLink           = SBOnExternalLink,
    .beginMediaLink           = SBBeginMediaLink,
    .endMediaLink             = SBEndMediaLink,
    .onMediaLink              = SBOnMediaLink,
    .onTagExtension           = SBOnTagExtension,
    .beginBulletList          = SBBeginBulletList,
    .endBulletList            = SBEndBulletList,
    .beginBulletListItem      = SBBeginBulletListItem,
    .endBulletListItem        = SBEndBulletListItem,
    .beginEnumerationList     = SBBeginEnumerationList,
    .endEnumerationList       = SBEndEnumerationList,
    .beginEnumerationItem     = SBBeginEnumerationItem,
    .endEnumerationItem       = SBEndEnumerationItem,
    .beginDefinitionList      = SBBeginDefinitionList,
    .endDefinitionList        = SBEndDefinitionList,
    .beginDefinedTermItem     = SBBeginDefinedTermItem,
    .endDefinedTermItem       = SBEndDefinedTermItem,
    .beginDefinitionItem      = SBBeginDefinitionItem,
    .endDefinitionItem        = SBEndDefinitionItem,
    .beginTableOfContents     = SBBeginTableOfContents,
    .endTableOfContents       = SBEndTableOfContents,
    .beginTableOfContentsItem = SBBeginTableOfContentsItem,
    .endTableOfContentsItem   = SBEndTableOfContentsItem,
    .beginHtmlDiv             = SBBeginHtmlDiv,
    .endHtmlDiv               = SBEndHtmlDiv,
    .beginHtmlBlockquote      = SBBeginHtmlBlockquote,
    .endHtmlBlockquote        = SBEndHtmlBlockquote,
    .beginHtmlCenter          = SBBeginHtmlCenter,
    .endHtmlCenter            = SBEndHtmlCenter,
    .beginHtmlU               = SBBeginHtmlU,
    .endHtmlU                 = SBEndHtmlU,
    .beginHtmlDel             = SBBeginHtmlDel,
    .endHtmlDel               = SBEndHtmlDel,
    .beginHtmlIns             = SBBeginHtmlIns,
    .endHtmlIns               = SBEndHtmlIns,
    .beginHtmlFont            = SBBeginHtmlFont,
    .endHtmlFont              = SBEndHtmlFont,
    .beginHtmlBig             = SBBeginHtmlBig,
    .endHtmlBig               = SBEndHtmlBig,
    .beginHtmlSmall           = SBBeginHtmlSmall,
    .endHtmlSmall             = SBEndHtmlSmall,
    .beginHtmlSub             = SBBeginHtmlSub,
    .endHtmlSub               = SBEndHtmlSub,
    .beginHtmlSup             = SBBeginHtmlSup,
    .endHtmlSup               = SBEndHtmlSup,
    .beginHtmlCite            = SBBeginHtmlCite,
    .endHtmlCite              = SBEndHtmlCite,
    .beginHtmlCode            = SBBeginHtmlCode,
    .endHtmlCode              = SBEndHtmlCode,
    .beginHtmlStrike          = SBBeginHtmlStrike,
    .endHtmlStrike            = SBEndHtmlStrike,
    .beginHtmlStrong          = SBBeginHtmlStrong,
    .endHtmlStrong            = SBEndHtmlStrong,
    .beginHtmlSpan            = SBBeginHtmlSpan,
    .endHtmlSpan              = SBEndHtmlSpan,
    .beginHtmlTt              = SBBeginHtmlTt,
    .endHtmlTt                = SBEndHtmlTt,
    .beginHtmlVar             = SBBeginHtmlVar,
    .endHtmlVar               = SBEndHtmlVar,
    .beginHtmlAbbr            = SBBeginHtmlAbbr,
    .endHtmlAbbr              = SBEndHtmlAbbr,
    .onHtmlPre                = SBOnHtmlPre,
    .beginGarbage             = SBBeginGarbage,
    .endGarbage               = SBEndGarbage,
};


/**
 * Constructor for the listener's data storage.
 * @return A new instance of the data.
 */
static void *
SBNew()
{
    SCRIPT_BUF *data = ANTLR3_MALLOC(sizeof(*data));
    if (data == NULL) {
        return NULL;
    }

    if (!initBuffer(&data->buf)) {
        ANTLR3_FREE(data);
        return NULL;
    }

    /*
     * TODO get the encoding from the input stream.
     */
    data->stringFactory = antlr3StringFactoryNew(ANTLR3_ENC_UTF8);
    if (data->stringFactory == NULL) {
        freeBuffer(&data->buf);
        ANTLR3_FREE(data);
        return NULL;
    }

    data->scriptCallbackData = NULL;
    data->renderMarkup = true;
    data->height = NULL;
    data->width = NULL;
    data->url = NULL;
    data->imageUrl = NULL;

    return data;
}

/**
 * Deallocates the data storage.
 * @param pointer to the data storage.
 */
static void
SBFree(void *ptr)
{
    SCRIPT_BUF *data = ptr;
    freeBuffer(&data->buf);
    ANTLR3_FREE(data);
}

/**
 * Resets an instance of the data storage.
 * @param pointer to the data storage.
 */
static void
SBReset(void *ptr)
{
    SCRIPT_BUF *data = ptr;
    resetBuffer(&data->buf);
    data->stringFactory->close(data->stringFactory);
    data->stringFactory = antlr3StringFactoryNew(ANTLR3_ENC_UTF8);
}

/**
 * Return a pointer to an output buffer or similar.
 *
 * @param listener
 * @returns Pointer to implementation specific result, if any.
 */
static void *
SBGetResult(MWLISTENER *listener)
{
    return scriptBufResult(BUF);
}

static void SBLinkResolver(MWLINKCOLLECTION *linkCollection, void *data)
{
    MWLinkResolverCallback(linkCollection, data);
}

static void SBSetLinkResolverData(void *listenerData, void **linkResolverData)
{
    SCRIPT_BUF *buf = listenerData;
    *linkResolverData = buf->scriptCallbackData;
}

/**
 * Method that will be called to indicate that a "word" should be
 * rendered.
 *
 * A word is liberally defined as a sequence of printable characters
 * that aren't 'special', 'newline' or 'space'.  A non-html rendering
 * listener might need to escape some characters.
 *
 * Two words may occur without any space, newlines or any other
 * symbol in between.  These should be concatenated into one word
 * in the output.
 *
 * @param listener
 * @param word
 */
static void
SBOnWord(MWLISTENER *listener, pANTLR3_STRING word)
{
    appendAntlr3String(BUF, word);
}

/**
 * The listener should render a sequence of "special" characters.
 *
 * This is the complete set of special characters:
 * !"#$%&(*)+,-./:;<=>?@[']^_`{|}~
 *
 * Although special characters are usually sent one at the time,
 * sometimes a sequence of more than one characters are sent to
 * the listener.
 * 
 * @param listener
 * @param special
 */
static void
SBOnSpecial(MWLISTENER *listener, pANTLR3_STRING special)
{
    pANTLR3_STRING tmp = NULL;
    int i;
    for (i = 0; i < special->len; i++) {
        ANTLR3_UCHAR c = special->charAt(special, i);
        if (antlr3c8toAntlrc('<') == c) {
            CLEAR_STRING(tmp);
            APPEND_CONST_STRING("&lt;");
        } else if (antlr3c8toAntlrc('>') == c) {
            CLEAR_STRING(tmp);
            APPEND_CONST_STRING("&gt;");
        } else if (antlr3c8toAntlrc('&') == c) {
            CLEAR_STRING(tmp);
            APPEND_CONST_STRING("&amp;");
        } else {
            if (tmp == NULL) {
                tmp = DATA->stringFactory->newRaw(DATA->stringFactory);
            }
            tmp->addc(tmp, c);
        }
    }
    CLEAR_STRING(tmp);
}

/**
 * The listener should render a space.
 *
 * The space characters are stored in the argument, if the renderer
 * would like to output the spaces exactly as they appeared in the
 * wikitext.  Usually the listener should render just a space.
 *
 * @param listener
 * @param space
 */
static void
SBOnSpace(MWLISTENER *listener, pANTLR3_STRING space)
{
    APPEND_CONST_STRING(" ");
}

/**
 * A newline was encountered in the wikitext.
 *
 * A listener should normally just render a space.
 *
 * @param listener
 */
static void
SBOnNewline(MWLISTENER *listener)
{
    APPEND_CONST_STRING(" ");
}

/**
 * A <br> tag was encontered in the wikitext.
 *
 * The listener should render a line break.
 *
 * The tag may have attr.
 *
 * @param listener
 * @param attr
 */
static void
SBOnBr(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    if (DATA->renderMarkup) {
        APPEND_CONST_STRING("<br/>");
    }
}

#define HTML_TAG(name) do {                             \
        if (DATA->renderMarkup) {                       \
            if (attr == NULL) {                         \
                APPEND_CONST_STRING("<" name ">");      \
            } else {                                    \
                APPEND_CONST_STRING("<" name);          \
                APPEND_ATTR_VECTOR(name, attr);         \
                APPEND_CONST_STRING(">");               \
            }                                           \
        }                                               \
} while (0)

#define HTML_END(name) do {                     \
    if (DATA->renderMarkup) {                   \
        APPEND_CONST_STRING("</" name ">");     \
    }                                           \
} while (0)

/**
 * Called at the start of a paragraph.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginParagraph(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("p");
}

/**
 * Called at the end of a paragraph.
 *
 * @param listener
 */
static void
SBEndParagraph(MWLISTENER *listener)
{
    HTML_END("p");
}

/**
 * Called at the start of an article.
 *
 * @param listener
 */
static void
SBBeginArticle(MWLISTENER *listener)
{
}

/**
 * Called at the end of an article.
 *
 * @param listener
 */
static void
SBEndArticle(MWLISTENER *listener)
{
}

/**
 * The listener should initiate italic rendering.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginItalic(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("i");
}

/**
 * The listener should stop italic rendering.
 *
 * @param listener
 */
static void
SBEndItalic(MWLISTENER *listener)
{
    HTML_END("i");
}

/**
 * The listener should initiate bold rendering.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginBold(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("b");
}

/**
 * The listener should stop bold rendering.
 *
 * @param listener
 */
static void
SBEndBold(MWLISTENER *listener)
{
    HTML_END("b");
}

/**
 * Initiate formatting of a preformatted text box.
 *
 * @param listener
 */
static void
SBBeginPre(MWLISTENER *listener)
{
    if (DATA->renderMarkup) {
        APPEND_CONST_STRING("<pre>");
    }
}

/**
 * End preformatted text box.
 *
 * @param listener
 */
static void
SBEndPre(MWLISTENER *listener)
{
    HTML_END("pre");
}

/**
 * Initiate formatting of a heading at the given level.
 *
 * @param listener
 * @param level
 * @param anchor Raw text that should be used to produce an anchor id.
 * @param attr
 */
static void
SBBeginHeading(MWLISTENER *listener, int level, pANTLR3_STRING anchor, pANTLR3_VECTOR attr)
{
    switch (level) {
    case 1:
        HTML_TAG("h1");
        break;
    case 2:
        HTML_TAG("h2");
        break;
    case 3:
        HTML_TAG("h3");
        break;
    case 4:
        HTML_TAG("h4");
        break;
    case 5:
        HTML_TAG("h5");
        break;
    case 6:
        HTML_TAG("h6");
        break;
    default:
        assert(false);
    }
    DATA->headingLevel = level;
}

/**
 * End formatting of the currently opened heading.
 *
 * @param listener.
 */
static void
SBEndHeading(MWLISTENER *listener)
{
    switch (DATA->headingLevel) {
    case 1:
        HTML_END("h1");
        break;
    case 2:
        HTML_END("h2");
        break;
    case 3:
        HTML_END("h3");
        break;
    case 4:
        HTML_END("h4");
        break;
    case 5:
        HTML_END("h5");
        break;
    case 6:
        HTML_END("h6");
        break;
    default:
        assert(false);
    }
}

static void
renderInternalLinkOpen(MWLISTENER *listener, pANTLR3_STRING linkTitle, pANTLR3_STRING linkAnchor, MWLINKRESOLUTION *linkResolution)
{
    if (DATA->renderMarkup) {
#ifndef NDEBUG
        if (linkResolution == NULL) {
            APPEND_CONST_STRING("<a style=\"color: pink;\" title=\"UNRESOLVED INTERNAL LINK [");
            APPEND_ANTLR3_STRING(linkTitle);
            if (linkAnchor != NULL) {
                APPEND_CONST_STRING("#");
                /* TODO verify anchor */
                APPEND_ANTLR3_STRING(linkAnchor);
            }
            APPEND_CONST_STRING("]\">");
        } else
#endif
            {
                APPEND_CONST_STRING("<a href=\"");
                APPEND_STRING(linkResolution->url);
                if (linkAnchor != NULL) {
                    APPEND_CONST_STRING("#");
                    APPEND_ANTLR3_STRING(linkAnchor);
                }
                APPEND_CONST_STRING("\"");
                if (linkResolution->color == MWLINKCOLOR_RED) {
                    APPEND_CONST_STRING(" class=\"new\"");
                }
                APPEND_CONST_STRING(">");
            }
    }
}

/**
 * Initiate formatting of the link text corresponding to an internal
 * link targetting the page with the given title.
 *
 * @param listener
 * @param attr The link does not take any actual attributes, but
 * the ordinary arguments are packed into the attribute vector
 * in the order linkTitle, linkAnchor, linkTitle
 */
static void
SBBeginInternalLink(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    MWLINKRESOLUTION *linkResolution = attr->get(attr, attr->count - 1);
    attr->remove(attr, attr->count - 1);
    pANTLR3_STRING linkAnchor       = attr->get(attr, attr->count - 1);
    attr->remove(attr, attr->count - 1);
    pANTLR3_STRING linkTitle        = attr->get(attr, attr->count - 1);
    attr->remove(attr, attr->count - 1);

    renderInternalLinkOpen(listener, linkTitle, linkAnchor, linkResolution);
}

/**
 * End formatting of internal link.
 *
 * @param listener
 */
static void
SBEndInternalLink(MWLISTENER *listener)
{
    HTML_END("a");
}


/**
 * A complete internal link has been encountered.  The link title
 * should be used as the text contents of the link.
 *
 * TODO: pass link trail and prefix as arguments to this method.
 *
 * @param listener
 * @param attr The link does not take any actual attributes, but
 * the ordinary arguments are packed into the attribute vector
 * in the order linkTitle, linkAnchor, linkTitle
 */
static void
SBOnInternalLink(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    MWLINKRESOLUTION *linkResolution = attr->get(attr, attr->count - 1);
    attr->remove(attr, attr->count - 1);
    pANTLR3_STRING linkAnchor       = attr->get(attr, attr->count - 1);
    attr->remove(attr, attr->count - 1);
    pANTLR3_STRING linkTitle        = attr->get(attr, attr->count - 1);
    attr->remove(attr, attr->count - 1);
    if (DATA->renderMarkup) {
        renderInternalLinkOpen(listener, linkTitle, linkAnchor, linkResolution);
    }
    SBOnSpecial(listener, linkTitle);
    SBEndInternalLink(listener);
}

/**
 * Begin formatting text as the link text of an external link
 * targeting the given URL.
 *
 * @param listener
 * @param linkUrl
 */
static void
SBBeginExternalLink(MWLISTENER *listener, pANTLR3_STRING linkUrl)
{
    if (DATA->renderMarkup) {
        APPEND_CONST_STRING("<a class=\"external text\" rel=\"nofollow\" href=\"");
        /* TODO URL validation */
        APPEND_ANTLR3_STRING(linkUrl);
        APPEND_CONST_STRING("\">");
    }
}

/**
 * End formatting of external link.
 *
 * @param listener
 */
static void
SBEndExternalLink(MWLISTENER *listener)
{
    HTML_END("a");
}

/**
 * Indicate that a complete external link has been encountered.  The text should
 * be derived from the link URL.
 *
 * @param listener
 * @param linkUrl
 */
static void
SBOnExternalLink(MWLISTENER *listener, pANTLR3_STRING linkUrl)
{
    if (DATA->renderMarkup) {
        APPEND_CONST_STRING("<a class=\"external text\" rel=\"nofollow\" href=\"");
        /* TODO URL validation */
        APPEND_ANTLR3_STRING(linkUrl);
        APPEND_CONST_STRING("\">");
    }
    SBOnSpecial(listener, linkUrl);
    HTML_END("a");
}

static void
renderMediaLinkOpen(MWLISTENER *listener,
                    MEDIALINKOPTION *mlOption,
                    pANTLR3_STRING linkTitle,
                    pANTLR3_STRING linkAnchor,
                    MWLINKRESOLUTION *linkResolution,
                    MWLINKRESOLUTION *attributeLinkResolution)
{
    if (linkResolution != NULL) {
        pANTLR3_STRING title = linkTitle;
        pANTLR3_STRING alt   = linkTitle;
        const char *width;
        const char *height;
        bool renderFrame     = mlOption != NULL && mlOption->frame != LOF_NONE;

        if (mlOption != NULL && mlOption->width != NULL) {
            width = (char *) mlOption->width->toUTF8(mlOption->width)->chars;
        } else {
            width = linkResolution->imageWidth;
        }

        if (mlOption != NULL && mlOption->height != NULL) {
            height = (char *) mlOption->height->toUTF8(mlOption->height)->chars;
        } else {
            height = linkResolution->imageHeight;
        }

        if (renderFrame) {
            DATA->mediaLinkEndDivs = 3;
            if (mlOption->halign == LOHA_CENTER) {
                DATA->mediaLinkEndDivs = 4;
                APPEND_CONST_STRING("<div class=\"center\"><div class=\"thumb none\">");
            } else if (mlOption->halign == LOHA_LEFT) {
                APPEND_CONST_STRING("<div class=\"thumb tleft\">");
            } else {
                APPEND_CONST_STRING("<div class=\"thumb tright\">");
            }
            APPEND_CONST_STRING("<div class=\"thumbinner\">");
            APPEND_CONST_STRING("<a class=\"image\" title=\"");
            APPEND_ANTLR3_STRING(title);
            APPEND_CONST_STRING("\" href=\"");
            APPEND_STRING(linkResolution->url);
            APPEND_CONST_STRING("\"><img ");
            if (width != NULL) {
                APPEND_CONST_STRING("width=\"");
                APPEND_STRING(width);
                APPEND_CONST_STRING("\" ");
            }
            if (height != NULL) {
                APPEND_CONST_STRING("height=\"");
                APPEND_STRING(height);
                APPEND_CONST_STRING("\" ");
            }
            //            APPEND_CONST_STRING("\" border=\"");
            //            APPEND_STRING(border);
            APPEND_CONST_STRING("src=\"");
            APPEND_STRING(linkResolution->imageUrl);
            APPEND_CONST_STRING("\" alt=\"");
            APPEND_ANTLR3_STRING(alt);
            APPEND_CONST_STRING("\"/></a>");
            APPEND_CONST_STRING("<div class=\"thumbcaption\">");
        } else {

            APPEND_CONST_STRING("<a title=\"");
            DATA->height   = height;
            DATA->width    = width;
            DATA->url      = linkResolution->url;
            DATA->imageUrl = linkResolution->imageUrl;
            DATA->alt      = (char *) (mlOption == NULL ? NULL : mlOption->alt);
            DATA->renderMarkup = false;
            DATA->startCaption = getIndex(&DATA->buf);
        }
    } 
#ifndef NDEBUG
    else {
        APPEND_CONST_STRING("<a style=\"color: pink;\" title=\"UNRESOLVED MEDIA LINK [");
        APPEND_ANTLR3_STRING(linkTitle);
        if (linkAnchor != NULL) {
            APPEND_CONST_STRING("#");
            /* TODO verify anchor */
            APPEND_ANTLR3_STRING(linkAnchor);
        }
        APPEND_CONST_STRING("]\">");
    }
#endif
}

static void
renderCloseMediaLinkNoframe(MWLISTENER *listener)
{
    DATA->renderMarkup = true;
    MWSCRIPTBUF_INDEX endCaption = getIndex(&DATA->buf);
    APPEND_CONST_STRING("\" class=\"image\" href=\"");
    APPEND_STRING(DATA->url);
    APPEND_CONST_STRING("\">");
    if (DATA->imageUrl != NULL) {
        APPEND_CONST_STRING("<img ");
        if (DATA->width != NULL) {
            APPEND_CONST_STRING("width=\"");
            APPEND_STRING(DATA->width);
            APPEND_CONST_STRING("\" ");
        }
        if (DATA->height != NULL) {
            APPEND_CONST_STRING("height=\"");
            APPEND_STRING(DATA->height);
            APPEND_CONST_STRING("\" ");
        }
        APPEND_CONST_STRING("src=\"");
        APPEND_STRING(DATA->imageUrl);
        APPEND_CONST_STRING("\" alt=\"");
    }
    if (DATA->alt != NULL) {
        APPEND_STRING(DATA->alt);
    } else {
        copyAppendRegion(&DATA->buf, DATA->startCaption, endCaption);
    }
    if (DATA->imageUrl != NULL) {
        APPEND_CONST_STRING("\"/>");
    }
    APPEND_CONST_STRING("</a>");
}

/**
 * Begin formatting of a media link.  The options that describes how this media link should
 * be formatted is given by the attribute vector.  Note that for options that do not take an
 * argument the value element is NULL.  Unlike attributes of html elements, the attributes
 * of the media link has been validated by the parser.
 *
 * Following this event is the inlined text elements of the caption.
 * Also, note that media links may nest one level.
 *
 * @param listener
 * @param attr In the attribute vector additional parameters are
 * packed in the order options, linkTitle, linkAnchor,
 * linkResolution, attributeLinkResolution.
 */
static void
SBBeginMediaLink(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    MWLINKRESOLUTION *attributeLinkResolution  = attr->get(attr, attr->count - 1);
    MWLINKRESOLUTION *linkResolution = attr->get(attr, attr->count - 2);
    pANTLR3_STRING linkAnchor =  attr->get(attr, attr->count - 3);
    pANTLR3_STRING linkTitle =   attr->get(attr, attr->count - 4);
    MEDIALINKOPTION *mlOption =  attr->get(attr, attr->count - 5);
    
    if (DATA->renderMarkup) {
        renderMediaLinkOpen(listener, mlOption, linkTitle, linkAnchor, linkResolution, attributeLinkResolution);
    }
}

/**
 * Marks the end of the innermost currently opened media link.
 *
 * @param listener
 */
static void
SBEndMediaLink(MWLISTENER *listener)
{
    if (!DATA->renderMarkup) {
        renderCloseMediaLinkNoframe(listener);
    } else {
        int i;
        for (i = 0; i < DATA->mediaLinkEndDivs; i++) {
            HTML_END("div");
        }
    }
}

/**
 * Indicate that a complete image link (one without any caption) has been encountered.
 *
 * The options are passed in the attribute vector.  Works the same as
 * for SBBeginMediaLink.
 *
 * @param listener
 * @param attr In the attribute vector additional parameters are
 * packed in the order options, linkTitle, linkAnchor,
 * linkResolution, attributeLinkResolution.
 */
static void
SBOnMediaLink(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    MWLINKRESOLUTION *attributeLinkResolution  = attr->get(attr, attr->count - 1);
    MWLINKRESOLUTION *linkResolution = attr->get(attr, attr->count - 2);
    pANTLR3_STRING linkAnchor =  attr->get(attr, attr->count - 3);
    pANTLR3_STRING linkTitle  =  attr->get(attr, attr->count - 4);
    MEDIALINKOPTION *mlOption =  attr->get(attr, attr->count - 5);

    if (DATA->renderMarkup) {
        renderMediaLinkOpen(listener, mlOption, linkTitle, linkAnchor, linkResolution, attributeLinkResolution);
        SBEndMediaLink(listener);
    }
}

/**
 * Indicates that a tag corresponding to a registered tag extension has been encountered.
 *
 * Note that the body has not been filtered in any way; it may contain
 * any characters/markup code except the corresponding closing tag.
 *
 * @param listener
 * @param name
 * @param body
 * @param attr
 */
static void
SBOnTagExtension(MWLISTENER *listener, const char *name, pANTLR3_STRING body, pANTLR3_VECTOR attr)
{
    if (DATA->renderMarkup) {
        APPEND_CONST_STRING("<!-- TAG EXTENSION[");
        APPEND_STRING(name);
        APPEND_CONST_STRING("] -->");
        SBOnSpecial(listener, body);
        APPEND_CONST_STRING("<!-- END TAG EXTENSION -->");
    }
}

/**
 * Begin formatting of a bullet list.
 *
 * After this, bullet list items may appear.  Note, however, that inlined text
 * may appear outside of any list item.
 *
 * TODO: Should we generate implicit list items for the inlined text
 * that appears outside of list items?  The original behavior is to
 * render the inlined text outside of any list items, e.g., "<ul>inline
 * text</ul>" is rendered as is.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginBulletList(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("ul");
}

/**
 * End formatting of a bullet list.  Bullet list items may still
 * appear, if this list was a nested inside another list.
 *
 * @param listener
 */
static void
SBEndBulletList(MWLISTENER *listener)
{
    HTML_END("ul");
}

/**
 * Begin formatting a bullet list item.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginBulletListItem(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("li");
}

/**
 * End formatting of bullet list item.
 *
 * @param listener
 */
static void
SBEndBulletListItem(MWLISTENER *listener)
{
    HTML_END("li");
}

/**
 * Begin formatting an enumeration list (numbered list items).  After this,
 * enumeration list items may appear.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginEnumerationList(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("ol");
}

/**
 * End formatting enumeration list  Enumeration list items may still
 * appear, if this list was a nested inside another list.
 *
 * @param listener
 */
static void
SBEndEnumerationList(MWLISTENER *listener)
{
    HTML_END("ol");
}

/**
 * Begin formatting an enumeration list item.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginEnumerationItem(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("li");
}

/**
 * End formatting enumeration list item.
 *
 * @param listener
 */
static void
SBEndEnumerationItem(MWLISTENER *listener)
{
    HTML_END("li");
}

/**
 * Begin formatting a definition list.  After this, defined term
 * items and definition items may appear.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginDefinitionList(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("dl");
}

/**
 * End formatting of definition list.  Defined term items and definition
 * items may still appear if this list was nested inside another list.
 *
 * @param listener.
 */
static void
SBEndDefinitionList(MWLISTENER *listener)
{
    HTML_END("dl");
}

/**
 * Begin formatting a defined term item.  (HTML <dt>)
 *
 * @param listener
 * @param attr
 */
static void
SBBeginDefinedTermItem(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("dt");
}

/**
 * End formatting a defined term item.
 *
 * @param listener
 */
static void
SBEndDefinedTermItem(MWLISTENER *listener)
{
    HTML_END("dt");
}

/**
 * Begin formatting a definition (HTML <dd>)
 *
 * @param listener
 * @param attr
 */
static void
SBBeginDefinitionItem(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("dd");
}

/**
 * End formatting a definition item.
 *
 * @param listener
 */
static void
SBEndDefinitionItem(MWLISTENER *listener)
{
    HTML_END("dd");
}

/**
 * Begin formatting a table of contents.  After this, only table of contents items will
 * appear until the end of the table of contents.
 *
 * @param listener
 */
static void
SBBeginTableOfContents(MWLISTENER *listener)
{
}

/**
 * End formatting a table of contents.
 *
 * @param listener
 */
static void
SBEndTableOfContents(MWLISTENER *listener)
{
}

/**
 * Begin formatting a table of contents item.  The table of contents
 * item corresponds to a heading level.
 *
 * The table of contents item contains inlined text.
 *
 * @param listener
 * @param level
 * @param anchor Raw text that should be used to produce an anchor id.
 */
static void
SBBeginTableOfContentsItem(MWLISTENER *listener, int level, pANTLR3_STRING anchor)
{
}

/**
 * End formatting a table of contents item.
 *
 * @param listener
 */
static void
SBEndTableOfContentsItem(MWLISTENER *listener)
{
}

/**
 * Begin formatting a table.  The table is guaranteed to be well formed
 * with table cells encapsulated in table rows, which in turn
 * is encapsulated in a table body.
 *
 * A table may, however, have multiple table bodies and multiple table
 * captions.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginTable(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("table");
}

/**
 * End formatting of a table.
 *
 * @param listener
 */
static void
SBEndTable(MWLISTENER *listener)
{
    HTML_END("table");
}

/**
 * Begin formatting a table row.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginTableRow(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("tr");
}

/**
 * End formatting a table row.
 *
 * @param listener
 */
static void
SBEndTableRow(MWLISTENER *listener)
{
    HTML_END("tr");
}

/**
 * Begin formatting a table cell.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginTableCell(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("td");
}

/**
 * End formatting a table cell.
 *
 * @param listener
 */
static void
SBEndTableCell(MWLISTENER *listener)
{
    HTML_END("td");
}

/**
 * Begin formatting a table heading cell.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginTableHeading(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("th");
}

/**
 * End formatting a table heading cell.
 *
 * @param listener
 */
static void
SBEndTableHeading(MWLISTENER *listener)
{
    HTML_END("th");
}

/**
 * Begin formatting a table caption.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginTableCaption(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("caption");
}

/**
 * End formatting a table caption.
 *
 * @param listener
 */
static void
SBEndTableCaption(MWLISTENER *listener)
{
    HTML_END("caption");
}


/**
 * Begin formatting a table body.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginTableBody(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("tbody");
}

/**
 * End formatting a table body.
 *
 * @param listener
 */
static void
SBEndTableBody(MWLISTENER *listener)
{
    HTML_END("tbody");
}

/**
 * A <nowiki> element.  The body of the nowiki element is
 * passed verbatim.  It is up to the listener to filter
 * and escape undesired character sequences.
 *
 * @param listener
 * @param nowiki
 */
static void
SBOnNowiki(MWLISTENER *listener, pANTLR3_STRING nowiki)
{
    SBOnSpecial(listener, nowiki);
}

/**
 * An html entity on the form &<entity description>;.
 * The string describing the entity is passed as the argument.
 *
 * @param listener
 * @param entity
 */
static void
SBOnHTMLEntity(MWLISTENER *listener, pANTLR3_STRING entity)
{
    APPEND_ANTLR3_STRING(entity);
}

/**
 * A horizontal line.
 *
 * @param listener
 * @param attr
 */
static void
SBOnHorizontalRule(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("hr");
}

/**
 * An html <div> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlDiv(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("div");
}

/**
 * An html </div> element.
 *
 * @param listener
 */
static void
SBEndHtmlDiv(MWLISTENER *listener)
{
    HTML_END("div");
}

/**
 * A html <blockquote> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlBlockquote(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("blockquote");
}

/**
 * An html </blockquote> element.
 *
 * @param listener
 */
static void
SBEndHtmlBlockquote(MWLISTENER *listener)
{
    HTML_END("blockquote");
}

/**
 * A html <center> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlCenter(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("center");
}

/**
 * An html </center> element.
 *
 * @param listener
 */
static void
SBEndHtmlCenter(MWLISTENER *listener)
{
    HTML_END("center");
}

/**
 * A html <u> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlU(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("u");
}

/**
 * An html </u> element.
 *
 * @param listener
 */
static void
SBEndHtmlU(MWLISTENER *listener)
{
    HTML_END("u");
}

/**
 * A html <del> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlDel(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("del");
}

/**
 * An html </del> element.
 *
 * @param listener
 */
static void
SBEndHtmlDel(MWLISTENER *listener)
{
    HTML_END("del");
}

/**
 * A html <ins> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlIns(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("ins");
}

/**
 * An html </ins> element.
 *
 * @param listener
 */
static void
SBEndHtmlIns(MWLISTENER *listener)
{
    HTML_END("ins");
}

/**
 * A html <font> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlFont(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("font");
}

/**
 * An html </font> element.
 *
 * @param listener
 */
static void
SBEndHtmlFont(MWLISTENER *listener)
{
    HTML_END("font");
}

/**
 * A html <big> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlBig(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("big");
}

/**
 * An html </big> element.
 *
 * @param listener
 */
static void
SBEndHtmlBig(MWLISTENER *listener)
{
    HTML_END("big");
}

/**
 * A html <small> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlSmall(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("small");
}

/**
 * An html </small> element.
 *
 * @param listener
 */
static void
SBEndHtmlSmall(MWLISTENER *listener)
{
    HTML_END("small");
}

/**
 * A html <sub> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlSub(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("sub");
}

/**
 * An html </sub> element.
 *
 * @param listener
 */
static void
SBEndHtmlSub(MWLISTENER *listener)
{
    HTML_END("sub");
}

/**
 * A html <sup> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlSup(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("sup");
}

/**
 * An html </sup> element.
 *
 * @param listener
 */
static void
SBEndHtmlSup(MWLISTENER *listener)
{
    HTML_END("sup");
}

/**
 * A html <cite> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlCite(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("cite");
}

/**
 * An html </cite> element.
 *
 * @param listener
 */
static void
SBEndHtmlCite(MWLISTENER *listener)
{
    HTML_END("cite");
}

/**
 * A html <code> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlCode(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("code");
}

/**
 * An html </code> element.
 *
 * @param listener
 */
static void
SBEndHtmlCode(MWLISTENER *listener)
{
    HTML_END("code");
}

/**
 * A html <strike> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlStrike(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("strike");
}

/**
 * An html </strike> element.
 *
 * @param listener
 */
static void
SBEndHtmlStrike(MWLISTENER *listener)
{
    HTML_END("strike");
}

/**
 * A html <strong> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlStrong(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("strong");
}

/**
 * An html </strong> element.
 *
 * @param listener
 */
static void
SBEndHtmlStrong(MWLISTENER *listener)
{
    HTML_END("strong");
}

/**
 * A html <span> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlSpan(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("span");
}

/**
 * An html </span> element.
 *
 * @param listener
 */
static void
SBEndHtmlSpan(MWLISTENER *listener)
{
    HTML_END("span");
}

/**
 * A html <tt> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlTt(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("tt");
}

/**
 * An html </tt> element.
 *
 * @param listener
 */
static void
SBEndHtmlTt(MWLISTENER *listener)
{
    HTML_END("tt");
}

/**
 * A html <var> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlVar(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("var");
}

/**
 * An html </var> element.
 *
 * @param listener
 */
static void
SBEndHtmlVar(MWLISTENER *listener)
{
    HTML_END("var");
}

/**
 * A html <abbr> element.
 *
 * @param listener
 * @param attr
 */
static void
SBBeginHtmlAbbr(MWLISTENER *listener, pANTLR3_VECTOR attr)
{
    HTML_TAG("abbr");
}

/**
 * An html </abbr> element.
 *
 * @param listener
 */
static void
SBEndHtmlAbbr(MWLISTENER *listener)
{
    HTML_END("abbr");
}


/**
 * An instance of html <pre> body </pre>.  The body is unfiltered, the
 * same as for nowiki.
 *
 * @param listener
 * @param body
 * @param attr
 */
static void
SBOnHtmlPre(MWLISTENER *listener, pANTLR3_STRING body, pANTLR3_VECTOR attr)
{
    HTML_TAG("pre");
    SBOnSpecial(listener, body);
    HTML_END("pre");
}


static void
SBBeginGarbage(MWLISTENER *listener)
{
}

static void
SBEndGarbage(MWLISTENER *listener)
{
}
