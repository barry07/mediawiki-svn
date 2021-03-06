/*
 * Copyright 2010  Andreas Jonsson
 *
 * This file is part of libmwparser.
 *
 * Libmwparser is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

lexer grammar mwWikitextLexer;

options {
    language = C;
}

tokens {
    EXTERNAL_LINK;
    TABLE_HEADING;
    TABLE_HEADING_INLINE;
    TABLE_CAPTION;
    BEGIN_INTERNAL_LINK;
    BEGIN_EXTERNAL_LINK;
    BEGIN_MEDIA_LINK;
    END_MEDIA_LINK;
    MEDIA_LINK;
    HORIZONTAL_RULE;
    NOWIKI;
    BEGIN_HEADING;
    END_HEADING;
    LIST_ELEMENT;
    TABLE_OF_CONTENTS;
    NON_PRINTABLE; // Will be sent to the hidden channel.

    TAGEXT_BLOCK;
    TAGEXT_INLINE;

    HTML_TABLE_OPEN;
    HTML_TABLE_CLOSE;
    HTML_TBODY_OPEN;
    HTML_TBODY_CLOSE;
    HTML_TR_OPEN;
    HTML_TR_CLOSE;
    HTML_TD_OPEN;
    HTML_TD_CLOSE;
    HTML_TH_OPEN;
    HTML_TH_CLOSE;
    HTML_CAPTION_OPEN;
    HTML_CAPTION_CLOSE;
    HTML_UL_OPEN;
    HTML_UL_CLOSE;
    HTML_DIV_OPEN;
    HTML_DIV_CLOSE;
    HTML_B_OPEN;
    HTML_B_CLOSE;
    HTML_DEL_OPEN;
    HTML_DEL_CLOSE;
    HTML_I_OPEN;
    HTML_I_CLOSE;
    HTML_INS_OPEN;
    HTML_INS_CLOSE;
    HTML_U_OPEN;
    HTML_U_CLOSE;
    HTML_FONT_OPEN;
    HTML_FONT_CLOSE;
    HTML_BIG_OPEN;
    HTML_BIG_CLOSE;
    HTML_SMALL_OPEN;
    HTML_SMALL_CLOSE;
    HTML_SUB_OPEN;
    HTML_SUB_CLOSE;
    HTML_SUP_OPEN;
    HTML_SUP_CLOSE;
    HTML_CITE_OPEN;
    HTML_CITE_CLOSE;
    HTML_CODE_OPEN;
    HTML_CODE_CLOSE;
    HTML_EM_OPEN;
    HTML_EM_CLOSE;
    HTML_S_OPEN;
    HTML_S_CLOSE;
    HTML_STRIKE_OPEN;
    HTML_STRIKE_CLOSE;
    HTML_STRONG_OPEN;
    HTML_STRONG_CLOSE;
    HTML_TT_OPEN;
    HTML_TT_CLOSE;
    HTML_VAR_OPEN;
    HTML_VAR_CLOSE;
    HTML_SPAN_OPEN;
    HTML_SPAN_CLOSE;
    HTML_ABBR_OPEN;
    HTML_ABBR_CLOSE;
    HTML_CENTER_OPEN;
    HTML_CENTER_CLOSE;
    HTML_BLOCKQUOTE_OPEN;
    HTML_BLOCKQUOTE_CLOSE;
    HTML_H1_OPEN;
    HTML_H1_CLOSE;
    HTML_H2_OPEN;
    HTML_H2_CLOSE;
    HTML_H3_OPEN;
    HTML_H3_CLOSE;
    HTML_H4_OPEN;
    HTML_H4_CLOSE;
    HTML_H5_OPEN;
    HTML_H5_CLOSE;
    HTML_H6_OPEN;
    HTML_H6_CLOSE;
    HTML_BR;
    HTML_IMG;
    HTML_UL_LI_OPEN;
    HTML_UL_LI_CLOSE;
    HTML_OL_OPEN;
    HTML_OL_CLOSE;
    HTML_OL_LI_OPEN;
    HTML_OL_LI_CLOSE;
    HTML_DL_OPEN;
    HTML_DL_CLOSE;
    HTML_DD_OPEN;
    HTML_DD_CLOSE;
    HTML_DT_OPEN;
    HTML_DT_CLOSE;
    HTML_P_OPEN;
    HTML_P_CLOSE;
}

@lexer::preincludes {
#include <mwconfig.h>
struct MWKEYVALUE_struct;

typedef enum 
{
    AGT_TABLE,
    AGT_HTML_TAG,
    AGT_TABLE_CELL,
}
    ATTRIBUTE_GARBAGE_TYPE;

}

@lexer::includes {
#include <mwlexercontext.h>
#include <mwutils.h>
#include <mwkeyvalue.h>
#include <mwmedialinkoption.h>
}

@lexer::members{
#include "mwlexerpredicates.h"

#define CX ((MWLEXERCONTEXT*)(ctx->pLexer->super))

#define BOL (LEXER->input->charPositionInLine <= 0)

#define PEEK(n, c) (LA(n) == antlr3c8toAntlrc(c))
#define ACTION(code)              { code }
#define MW_EMIT()              do { EMIT();                       } while (0)
#define MW_SETTYPE(type)       do { _type = type;                 } while (0)
#define MW_EMITNEW(type, text) do { EMITNEW(NEW_TOK(type, text)); } while (0)
#define MW_HIDE()              do { LEXSTATE->channel = HIDDEN;   } while (0)
#define D_(msg) (fputs(msg, stderr), fputc('\n', stderr), printLexerInfo(LEXER), true)
#define NEW_TOK(type, text) (newToken(LEXSTATE->tokFactory, type, text))
#define SUBSTR1(start) (INPUT->substr(INPUT, start, GETCHARINDEX() - 1))
#define SUBSTR2(start, end) (INPUT->substr(INPUT, start, end))
#define HEADING_LEVEL user1

static pANTLR3_COMMON_TOKEN
newToken(pANTLR3_TOKEN_FACTORY factory, ANTLR3_UINT32 type, pANTLR3_STRING text)
{
    pANTLR3_COMMON_TOKEN t = factory->newToken(factory);
    t->setType(t, type);
    t->setText(t, text);
    t->custom = NULL;
    return t;
}

static void
addAttribute(MWLEXERCONTEXT *context, pANTLR3_VECTOR *attrs, MWKEYVALUE attr)
{
    MWKEYVALUE *p = ANTLR3_MALLOC(sizeof(*p));
    *p = attr;
    if (*attrs == NULL) {
        *attrs = context->vectorFactory->newVector(context->vectorFactory);
    }
    (*attrs)->add(*attrs, p, ANTLR3_FREE_FUNC);
}

static void eofAction(void *param);

#define SPECULATION_FAILURE(context, ...) do {                           \
    MWLEXERSPECULATION *failures[] = { __VA_ARGS__ };                        \
    speculationFailure(context, sizeof(failures)/sizeof(MWLEXERSPECULATION*), failures); \
} while (0)


/**
 * Initiate a speculative execution.
 * @param context
 * @param speculation Storage space for the context backup.
 */
static void
speculationInitiate(MWLEXERCONTEXT *context, MWLEXERSPECULATION *speculation)
{
    context->lexer->eofAction          = eofAction;
    context->lexer->eofActionParameter = context;
    saveContext(context, &speculation->contextBackup);
    context->lexer->markTokenStream(context->lexer, &speculation->tstreamMark);
    speculation->istreamMark = context->lexer->input->istream->mark(context->lexer->input->istream);
    speculation->lcMark = MWLinkCollectionMark(context->linkCollection);
    speculation->active = true;
    speculation->istreamIndex = context->istreamIndex++;
}

/**
 * Indictate that a speculative execution has succeeded.
 */
static void
speculationSuccess(MWLEXERCONTEXT *context, MWLEXERSPECULATION *speculation)
{
    speculation->active = false;
}

/**
 * Abort speculative execution, without restoring the context.
 */
static void
speculationAbort(MWLEXERCONTEXT *context, MWLEXERSPECULATION *speculation)
{
    speculation->active = false;
}

/**
 * Indicate that one or several speculative executions has failed and
 * restore the context to the initiation point of the "oldest"
 * speculation.
 * @param context
 * @param n Number of speculations in the array.
 * @param speculation Array of speculation backup storage structures.
 */
static void
speculationFailure(MWLEXERCONTEXT *context, int n, MWLEXERSPECULATION *speculation[])
{
    MWLEXERSPECULATION *earliestFail = NULL;
    int i;
    for (i = 0; i < n; i++ ) {
        if (speculation[i]->active) {
            if (earliestFail == NULL) {
                earliestFail = speculation[i];
            } else if (speculation[i]->istreamIndex < earliestFail->istreamIndex) {
                earliestFail = speculation[i];
            }
            speculation[i]->active = false;
        }
    }
    if (earliestFail != NULL) {
        restoreContext(context, &earliestFail->contextBackup);
        context->lexer->restoreTokenStream(context->lexer, &earliestFail->tstreamMark);
        context->lexer->input->istream->rewind(context->lexer->input->istream, earliestFail->istreamMark);
        MWLinkCollectionRewind(context->linkCollection, earliestFail->lcMark);
        earliestFail->failurePoint = context->lexer->getCharIndex(context->lexer);
    }
}

/**
 * Check if a particular speculation has already been tried at the
 * current character index.
 * @return {\code true} if the speculation already has been tried and failed.
 */
static bool
alreadyTried(MWLEXERCONTEXT *context, MWLEXERSPECULATION *speculation) {
    return speculation->failurePoint == context->lexer->getCharIndex(context->lexer);
}

/**
 * Action to execute at the end of file.
 */
static void
eofAction(void *param)
{
    MWLEXERCONTEXT *context = param;
    speculationSuccess(context, &context->indentSpeculation);
    bool willFail = context->headingSpeculation.active 
                 || context->internalLinkSpeculation.active
                 || context->mediaLinkSpeculation[0].active
                 || context->mediaLinkSpeculation[1].active;
    SPECULATION_FAILURE(context,
                        &context->headingSpeculation,
                        &context->internalLinkSpeculation,
                        &context->mediaLinkSpeculation[0],
                        &context->mediaLinkSpeculation[1]);

    if (!willFail) {
        context->resolveLinks(context);
    }
}



}

fragment
NOWIKI
@init{ 
    ANTLR3_MARKER nowikiStart = 0;
    ANTLR3_MARKER nowikiEnd = 0;
    pANTLR3_VECTOR attrs = NULL;
}:
    N O W I K I  (SPACE_TAB ATTRIBUTE_LIST_HTML[&attrs]? )? '>'
    ((SPACE_CHAR|NEWLINE_CHAR) => (SPACE_CHAR|NEWLINE_CHAR))*
    {
        nowikiEnd = nowikiStart = GETCHARINDEX();
    }
    NOWIKI_BODY[&nowikiEnd]
    {
        ACTION(SETTEXT(SUBSTR2(nowikiStart, nowikiEnd));)
        MW_SETTYPE(NOWIKI);
        MW_EMIT();
    }
    ;

fragment
NOWIKI_BODY[ANTLR3_MARKER *nowikiEnd]
options{
    k = 1;
}:
    (((SPACE_CHAR|NEWLINE_CHAR)* ('</' N O W I K I SKIP_SPACE '>'|EOF))=>
      (SPACE_CHAR|NEWLINE_CHAR)* ('</' N O W I K I SKIP_SPACE '>'|EOF)   )
    |
    ({ *nowikiEnd = GETCHARINDEX(); } . ) NOWIKI_BODY[nowikiEnd]
    ;

fragment
HTML_PRE
@init{ 
    ANTLR3_MARKER preStart = 0;
    ANTLR3_MARKER preEnd = 0;
    pANTLR3_VECTOR attrs = NULL;
}:
    {!CX->htmlPreDisabled}?=> P R E (SPACE_TAB ATTRIBUTE_LIST_HTML[&attrs]? )? '>'
    ((SPACE_CHAR|NEWLINE_CHAR) => (SPACE_CHAR|NEWLINE_CHAR))*
    {
        preEnd = preStart = GETCHARINDEX();
    }
    PRE_BODY[&preEnd]
    {
        ACTION(SETTEXT(SUBSTR2(preStart, preEnd));)
        MW_SETTYPE(HTML_PRE);
        CUSTOM = attrs;
        MW_EMIT();
    }
    ;

fragment
PRE_BODY[ANTLR3_MARKER *preEnd]:
    (((SPACE_CHAR|NEWLINE_CHAR)* ('</' P R E SKIP_SPACE '>'|EOF))=>
      (SPACE_CHAR|NEWLINE_CHAR)* ('</' P R E SKIP_SPACE '>'|EOF)   )
    |
    ({ *preEnd = GETCHARINDEX(); } . ) PRE_BODY[preEnd]
    ;



HORIZONTAL_RULE: {BOL}?=> ('---' '-'+ SPACE_TAB*) | (('-'|'--'|'---') {MW_SETTYPE(SPECIAL);})
    ;

BEGIN_HEADING
@init{
    int level;
}: {BOL && !CX->wikitextHeadingOpenDisabled && !alreadyTried(CX, &CX->headingSpeculation)}?=>
   {
      level = 0;
      speculationInitiate(CX, &CX->headingSpeculation);
   }
   ({level < 6}?=> '=' {level++;})+
   {
      CX->headingLevel = level;
      CX->headingTextBegin = GETCHARINDEX();
      CX->headingBeginToken = NEW_TOK(BEGIN_HEADING, $text);
      CX->headingBeginToken->HEADING_LEVEL = CX->headingLevel;
      EMITNEW(CX->headingBeginToken);
      onWikitextHeadingOpen(CX);
   }
   ;

END_HEADING
@init {
    ANTLR3_MARKER mark = 0;
    ANTLR3_MARKER endHeadingText = 0;
}: 
   {!CX->wikitextHeadingCloseDisabled}?=> '=' {mark = MARK();endHeadingText = GETCHARINDEX();}
    ( ({CX->headingLevel == 1}?=>   END_HEADING_EOL[mark])
     | ({CX->headingLevel == 2}?=>(('=' END_HEADING_EOL[mark])
                                    | {REWIND(mark); MW_SETTYPE(SPECIAL);}))
     | ({CX->headingLevel == 3}?=>(('==' END_HEADING_EOL[mark])
                                    | {REWIND(mark); MW_SETTYPE(SPECIAL);}))
     | ({CX->headingLevel == 4}?=>(('===' END_HEADING_EOL[mark])
                                    | {REWIND(mark); MW_SETTYPE(SPECIAL);}))
     | ({CX->headingLevel == 5}?=>(('====' END_HEADING_EOL[mark])
                                    | {REWIND(mark); MW_SETTYPE(SPECIAL);}))
     | ({CX->headingLevel == 6}?=>(('=====' END_HEADING_EOL[mark])
                                    | {REWIND(mark); MW_SETTYPE(SPECIAL);})))
   {
       if ($type == END_HEADING) {
           CX->headingBeginToken->setText(CX->headingBeginToken, SUBSTR2(CX->headingTextBegin, endHeadingText));
       }
   }
   ;

fragment
END_HEADING_EOL[ANTLR3_MARKER mark]:
   SKIP_SPACE
   (({onWikitextHeadingClose(CX); speculationSuccess(CX, &CX->headingSpeculation);} NEWLINE)
   | {REWIND(mark); MW_SETTYPE(SPECIAL); MW_EMIT();})
   ;

INDENTED_LIST_TABLE
@init{
    ANTLR3_MARKER listStart = 0;
    ANTLR3_MARKER tableStart = 0;
    ANTLR3_MARKER spaceStart = 0;
}:
    {BOL}?=>
    {
        spaceStart = GETCHARINDEX();
    }
    /*
     * One bizarre feature of the MediaWiki syntax is that
     * a :+ list element containing a table may appear
     * indented on the line.
     */
    SPACE_TAB*
    ( 
       {
           listStart = GETCHARINDEX();
       }
       ':'+
       ( ('{|')=>
           {
              MW_EMITNEW(LIST_ELEMENT, SUBSTR1(listStart));
              tableStart = GETCHARINDEX();
           }
           BEGIN_TABLE_INTERNAL
           {
                 MW_EMITNEW(BEGIN_TABLE, SUBSTR1(tableStart));
           }
         |
           {
              if (spaceStart != listStart) {
                  MW_EMITNEW(SPECIAL, SUBSTR1(listStart));
              } else {
                  MW_EMITNEW(LIST_ELEMENT, SUBSTR1(listStart));
              }
           }
       )
    )
    ;

LIST_ELEMENT:
    {BOL}?=> (':'|'*'|'#'|';')+
    {
       onWikitextListElement(CX);
       MW_EMIT();
    }
    SKIP_SPACE
    ;

TABLE_OF_CONTENTS: {!CX->tableOfContentsDisabled}?=> '__TOC__'
   ;

BEGIN_TABLE:
    {BOL && !CX->wikitextTableOpenDisabled}?=> (SKIP_SPACE '{|')=> SKIP_SPACE
    BEGIN_TABLE_INTERNAL
    ;

END_TABLE: {BOL && !CX->wikitextTableCloseDisabled}?=>
        (SKIP_SPACE '|}')=> SKIP_SPACE '|}' { onWikitextTableClose(CX);}
    ;

TABLE_ROW_SEPARATOR @init{pANTLR3_VECTOR attrs = NULL;}: 
    {BOL && !CX->wikitextTableRowDisabled}?=> (SKIP_SPACE '|-')=> SKIP_SPACE '|' (('-')=>'-')+
    ATTRIBUTE_LIST_TABLE[&attrs]
    { CUSTOM = attrs; }
    ;

TABLE_CELL
@init{
    pANTLR3_VECTOR attrs = NULL;
}:
    {BOL && !CX->wikitextTableCellDisabled}?=>
    (SKIP_SPACE ('|'|'!') )=>
    SKIP_SPACE
    {
        attrs = NULL;
    }
    ( 
       '|'
       {
           onWikitextTableCell(CX);
       }
       (('+')=> '+'
           {
               MW_SETTYPE(TABLE_CAPTION);
           }
       )?
     | ('!' 
           {
               MW_SETTYPE(TABLE_HEADING);
               onWikitextTableHeading(CX);
               onWikitextTableCell(CX);
           }
       )
    )
    ATTRIBUTE_LIST_TABLE_CELL[&attrs]
    { 
       CUSTOM = attrs;
    }
    ;

TABLE_CELL_INLINE
@init{
    pANTLR3_VECTOR attrs = NULL;
}:
    {!CX->wikitextTableInlineCellDisabled}?=>
    {
        attrs = NULL;
    }
    ('|' | {!CX->wikitextTableInlineHeadingDisabled}?=> '!' ) 
    ('|' | {!CX->wikitextTableInlineHeadingDisabled}?=> '!' )
    ATTRIBUTE_LIST_TABLE_CELL[&attrs]
    { 
        CUSTOM = attrs;
        if (!CX->wikitextTableInlineHeadingDisabled) {
            MW_SETTYPE(TABLE_HEADING_INLINE);
        }
    }
    ;


/**
 * Internal link production, that covers the tokens INTERNAL_LNK,
 * BEGIN_INTERNAL_LINK, MEDIAL_LINK, and BEGIN_MEDIA_LINK.
 */
INTERNAL_LINK
@init{
    ANTLR3_MARKER mark = 0;
    pANTLR3_STRING linkTitle;
    pANTLR3_STRING linkAnchor=NULL;
    bool isCompleteLink = false;
    bool success = true;
    bool alreadyInInternalLink = false;
    bool isMediaLink = false;
    pANTLR3_VECTOR attr = NULL;
    MEDIALINKOPTION *mlOption = NULL;
    pANTLR3_STRING attrLink = NULL;
}:  {!CX->mediaLinkOpenDisabled && !alreadyTried(CX, &CX->internalLinkSpeculation)
        /*
         * We do not need to worry about whether a nested media link has
         * already failed or not, as if the internal media link fails, the
         * external will fail at the same time.
         */
        && !alreadyTried(CX, &CX->mediaLinkSpeculation[0])}?=>
    (
        {
            /*
             * If already in an internal link, we are going to fail
             * the currently ongoing speculation later on.  We cannot
             * fail a speculation until we have actually emitted a
             * token.
             */
            alreadyInInternalLink = CX->internalLinkOpenDisabled;
            if (!alreadyInInternalLink) {
                speculationInitiate(CX, &CX->internalLinkSpeculation);
            }
            /*
             * The nesting level is limited via the predicate control
             * logic so it will never happen that
             * mediaLinkOpenDisabled is false and at the same time
             * mediaLinkOpenNestingLevel > 1.  Hence, we can safely
             * initiate a speculation at the current nesting level.
             */
            speculationInitiate(CX, &CX->mediaLinkSpeculation[CX->mediaLinkOpenNestingLevel]);
        }
        '[['
        {
           mark = MARK();
        }
        (
           ((SPACE_TAB_CHAR)=> SPACE_TAB_CHAR)*
           (
            INTERNAL_LINK_TITLE[&linkTitle]
            SPACE_TAB_CHAR* {isMediaLink = CX->isMediaLinkTitle(CX, linkTitle);}
            ('#' INTERNAL_LINK_ANCHOR[&linkAnchor])?
            (
                 ']]' {isCompleteLink=true;}
               | '|' ({isMediaLink}?=> MEDIA_LINK_OPTIONS[&mlOption, &attrLink] | )
               | {success = false;}
            )
           )
          | {success = false;}
        )
    )
    {
        if (success) {
            pANTLR3_COMMON_TOKEN token = NEW_TOK(INTERNAL_LINK, linkTitle);
            if (isMediaLink) {
                MWLinkCollectionAdd(CX->linkCollection, MWLT_MEDIA, linkTitle, token);
                if (attrLink != NULL) {
                    /*
                     * Note that the value of the link attribute has not been validated
                     * in any way.
                     */
                    MWLinkCollectionAdd(CX->linkCollection, MWLT_LINKATTR, attrLink, token);
                }
                if (!alreadyInInternalLink) {
                    speculationAbort(CX, &CX->internalLinkSpeculation);
                }
                if (attr == NULL) {
                    attr = CX->vectorFactory->newVector(CX->vectorFactory);
                }
                /*
                 * We'll pack the link title in the attribute vector.
                 * The parser will unpack it and send it as a separate
                 * parameter to the client.
                 *
                 * Argument convention:
                 *
                 * options, linkTitle, linkAnchor, linkResolution, attributeLinkResolution
                 */

                attr->add(attr, mlOption, MWMediaLinkOptionFree);
                attr->add(attr, linkTitle, NULL);
                attr->add(attr, linkAnchor, NULL);
                attr->add(attr, NULL, NULL);
                attr->add(attr, NULL, NULL);
                token->custom = attr;
                if (isCompleteLink) {
                    token->setType(token, MEDIA_LINK);
                    speculationAbort(CX, &CX->mediaLinkSpeculation[CX->mediaLinkOpenNestingLevel]);
                } else {
                    onMediaLinkOpen(CX);
                    token->setType(token, BEGIN_MEDIA_LINK);
                }
            } else if (CX->isLegalTitle(CX, linkTitle)) {
                MWLinkCollectionAdd(CX->linkCollection, MWLT_INTERNAL, linkTitle, token);
                speculationAbort(CX, &CX->mediaLinkSpeculation[CX->mediaLinkOpenNestingLevel]);
                /*
                 * Convention for passing attributes to internal link:
                 *
                 * linkTitle, linkAnchor, linkResolution
                 */
                pANTLR3_VECTOR v = CX->vectorFactory->newVector(CX->vectorFactory);
                v->add(v, linkTitle, NULL);
                v->add(v, linkAnchor, NULL);
                v->add(v, NULL, NULL);
                token->custom = v;
                if (isCompleteLink) {
                    speculationAbort(CX, &CX->internalLinkSpeculation);
                } else {
                    onInternalLinkOpen(CX);
                    token->setType(token, BEGIN_INTERNAL_LINK);
                }
            }
            EMITNEW(token);
        } else {
            if (!alreadyInInternalLink) {
                speculationAbort(CX, &CX->internalLinkSpeculation);
            }
            speculationAbort(CX, &CX->mediaLinkSpeculation[CX->mediaLinkOpenNestingLevel]);
            REWIND(mark);
            MW_SETTYPE(SPECIAL);
            MW_EMIT();
        }
        if (alreadyInInternalLink) {
            SPECULATION_FAILURE(CX, &CX->internalLinkSpeculation);
        } else {
            SPECULATION_FAILURE(CX, &CX->externalLinkSpeculation);
        }
    }
    ;

INTERNAL_LINK_FAIL_CONDITION: {CX->internalLinkSpeculation.active}?=>
    '[[' 
    { 
        /*
         * We must actually emit this token before failing the
         * speculation, otherwise it will be emitted _after_
         * the token stream has been reverted.
         */
        MW_EMIT();
        SPECULATION_FAILURE(CX, &CX->internalLinkSpeculation); 
    }
    ;

fragment
MEDIA_LINK_OPTIONS[MEDIALINKOPTION **mlOption, pANTLR3_STRING *link]:

    (
     (SKIP_SPACE (MEDIA_LINK_OPTION[NULL]    |MEDIA_LINK_OPTION_WITH_VALUE[NULL,     NULL])
           SKIP_SPACE ('|'|{PEEK(1, ']') && PEEK(2, ']')}?=>) )=>
      SKIP_SPACE (MEDIA_LINK_OPTION[mlOption]|MEDIA_LINK_OPTION_WITH_VALUE[mlOption, link])
           SKIP_SPACE ('|'|{PEEK(1, ']') && PEEK(2, ']')}?=>) 
    )*
    ;

fragment
MEDIA_LINK_OPTION[MEDIALINKOPTION **mlOption]
@init{
   ANTLR3_MARKER start = 0;
}:
    {
        if (*mlOption == NULL) {
            *mlOption = MWMediaLinkOptionNew();
        }
    }
    ( ('thumbnail'   { (*mlOption)->frame     = LOF_THUMBNAIL;    })
     |('left'        { (*mlOption)->halign    = LOHA_LEFT;        })
     |('right'       { (*mlOption)->halign    = LOHA_RIGHT;       })
     |('none'        { (*mlOption)->halign    = LOHA_NONE;        })
     |('center'      { (*mlOption)->halign    = LOHA_CENTER;      })
     |('frame'       { (*mlOption)->frame     = LOF_FRAME;        })
     |('framed'      { (*mlOption)->frame     = LOF_FRAME;        })
     |('frameless'   { (*mlOption)->frame     = LOF_FRAMELESS;    })
     |('upright'     { (*mlOption)->upright   = true;             })
     |('border'      { (*mlOption)->border    = true;             })
     |('baseline'    { (*mlOption)->valign    = LOVA_BASELINE;    })
     |('sub'         { (*mlOption)->valign    = LOVA_SUB;         })
     |('super'       { (*mlOption)->valign    = LOVA_SUPER;       })
     |('top'         { (*mlOption)->valign    = LOVA_TOP;         })
     |('text-top'    { (*mlOption)->valign    = LOVA_TEXT_TOP;    })
     |('middle'      { (*mlOption)->valign    = LOVA_MIDDLE;      })
     |('bottom'      { (*mlOption)->valign    = LOVA_BOTTOM;      })
     |('text-bottom' { (*mlOption)->valign    = LOVA_TEXT_BOTTOM; }))
    ;

fragment
MEDIA_LINK_OPTION_WITH_VALUE[MEDIALINKOPTION **mlOption, pANTLR3_STRING *link]
@init{
    ANTLR3_MARKER startVal = 0;
    bool hasHeight = false;
    bool hasWidth  = false;
    bool isLink    = false;
    ANTLR3_MARKER startVal1 = 0;
    ANTLR3_MARKER endVal1 = 0;
    ANTLR3_MARKER startVal2 = 0;
    ANTLR3_MARKER endVal2 = 0;
}:
    {
        if (*mlOption == NULL) {
            *mlOption = MWMediaLinkOptionNew();
        }
    }
    ((((  'alt=' 
      | ('link=' { isLink = true; }) )
         { startVal = GETCHARINDEX(); } (MEDIA_LINK_OPTION_VALUE_CHAR | {PEEK(1, ']') && !PEEK(2, ']')}?=> ']')*)
      {
          pANTLR3_STRING val = SUBSTR1(startVal);
          if (isLink) {
              *link = val;
          } else {
              (*mlOption)->alt = val;
          }
      }
    )
    | (({startVal1 = GETCHARINDEX(); } (({hasWidth=true; endVal1 = GETCHARINDEX();} DECIMAL_DIGIT)* 'x' {hasHeight=true;})?
        {startVal2 = GETCHARINDEX(); }  ({ endVal2 = GETCHARINDEX(); } DECIMAL_DIGIT)+ 'px')
       {
           if (hasHeight) {
               if (hasWidth) {
                   (*mlOption)->width = SUBSTR2(startVal1, endVal1);
               }
               (*mlOption)->height = SUBSTR2(startVal2, endVal2);
           } else {

               (*mlOption)->width = SUBSTR2(startVal2, endVal2);
           }
       }
      )
    )
    ;

END_INTERNAL_LINK: {!CX->internalLinkCloseDisabled}?=> ']]'
    {
        speculationSuccess(CX, &CX->internalLinkSpeculation);
        onInternalLinkClose(CX);
    }
    ;

END_MEDIA_LINK: {!CX->mediaLinkCloseDisabled}?=> ']]'
    {
        int n = CX->mediaLinkOpenNestingLevel;
        speculationSuccess(CX, &CX->mediaLinkSpeculation[n - 1]);
        onMediaLinkClose(CX);
    }
    ;

EXTERNAL_LINK
@init{
    bool success = true;
    bool complete = true;
    ANTLR3_MARKER urlStart = 0;
    ANTLR3_MARKER urlEnd = 0;
}:                 {!CX->externalLinkOpenDisabled && !alreadyTried(CX, &CX->externalLinkSpeculation)}?=>
    {
        speculationInitiate(CX, &CX->externalLinkSpeculation);
    }
   ('[' ((URL_PROTOCOL)=> {urlStart = GETCHARINDEX();} URL_PROTOCOL
             (( {urlEnd = GETCHARINDEX();} URL_CHAR)+ SPACE_TAB_CHAR* (']' | {complete = false;})
         | {success = false;})
    | {success = false;}) )
    {
        if (success) {
            pANTLR3_STRING url = SUBSTR2(urlStart, urlEnd);
            pANTLR3_COMMON_TOKEN token = NEW_TOK(EXTERNAL_LINK, url);
            token->custom = url;
            //MWLinkCollectionAdd(CX->linkCollection, MWLT_EXTERNAL, url, token);
            if (!complete) {
                token->setType(token, BEGIN_EXTERNAL_LINK);
                onExternalLinkOpen(CX);
            } else {
                speculationAbort(CX, &CX->externalLinkSpeculation);
            }
            EMITNEW(token);
        } else {
            speculationAbort(CX, &CX->externalLinkSpeculation);
            MW_SETTYPE(SPECIAL);
        }
    }
    ;

END_EXTERNAL_LINK: {!CX->externalLinkCloseDisabled}?=> ']'
    {
        speculationSuccess(CX, &CX->externalLinkSpeculation);
        onExternalLinkClose(CX);
    }
    ;

EXTERNAL_LINK_FAIL_CONDITION: {CX->externalLinkSpeculation.active}?=>
    '[' 
    { 
        /*
         * We must actually emit this token before failing the
         * speculation, otherwise it will be emitted _after_
         * the token stream has been reverted.
         */
        MW_EMIT();
        SPECULATION_FAILURE(CX, &CX->externalLinkSpeculation);
    }
    ;


fragment
URL_PROTOCOL:
	'http://'     |
	'https://'    |
	'ftp://'      |
	'irc://'      |
	'gopher://'   |
	'telnet://'   |
	'nntp://'     | // @bug 3808 RFC 1738
	'worldwind://'|
	'mailto:'     |
	'news:'       |
	'svn://'      |
	'git://'      |
	'mms://'
    ;

fragment
INTERNAL_LINK_TITLE[pANTLR3_STRING *linkTitle]
@init{
   ANTLR3_MARKER start = 0;
}:
    {
       start = GETCHARINDEX();
    }
    (~(NEWLINE_CHAR|TAB_CHAR|'|'|'['|']'|NON_PRINTABLE_CHAR))+
    {
       *linkTitle = SUBSTR1(start);
    }
    ;

fragment
INTERNAL_LINK_ANCHOR[pANTLR3_STRING *linkAnchor]
@init{
    ANTLR3_MARKER start = 0;
}:
    {
       start = GETCHARINDEX();
    }
    (~(NEWLINE_CHAR|'|'|'['|']'|NON_PRINTABLE_CHAR))*
    {
       *linkAnchor = SUBSTR1(start);
    }
    ;

HTML_ENTITY
@init{
    ANTLR3_MARKER mark = 0;
    bool success = false;
}:
    '&'
    {
        mark = MARK();
    }
    (       HTML_ENTITY_CHARS (';' { success = true; } |)
     | '#'  DECIMAL_NUMBER    (';' { success = true; } |)
     | '#x' HEX_NUMBER        (';' { success = true; } |)
     |
    )
    {
        if (!success) {
            REWIND(mark);
            MW_SETTYPE(SPECIAL);
        }
    }
    ;

INDENT: {BOL && !CX->indentedTextDisabled && !alreadyTried(CX, &CX->indentSpeculation)}?=>
    {speculationInitiate(CX, &CX->indentSpeculation);} SPACE_TAB {onIndentedText(CX);}
    ;

SPACE_TAB: (SPACE_CHAR | TAB_CHAR)+
    ;

ASCII_WORD: LETTER+
    ;

WORD: CHAR+
    ;

NEWLINE:
    ('\r\n' | NEWLINE_CHAR) { 
       onEol(CX);
       speculationSuccess(CX, &CX->indentSpeculation);
       SPECULATION_FAILURE(CX, &CX->headingSpeculation, &CX->externalLinkSpeculation);
    }
    ;

SPECIAL
options{
    backtrack = true;
}: SPECIAL_SYMBOL
    ;

APOS: '\''
    ;

/*
 * We will expect anything as input.  As \0 would probably cause serious
 * problems we will skip those already in the lexer.
 */
NON_PRINTABLE: (NON_PRINTABLE_CHAR)+ {MW_HIDE();}
   ;

HTML_OPEN_TAG
@init{
    ANTLR3_MARKER bodyStart = 0;
    ANTLR3_MARKER bodyEnd = 0;
    CX->inHtmlPre = false;
    CX->inNowiki = false;
    pANTLR3_VECTOR attrs = NULL;
}:
    '<' (
         ((HTML_OPEN_TAG_INTERNAL[NULL])=>
           (HTML_OPEN_TAG_INTERNAL[&attrs]
            {bodyEnd = bodyStart = GETCHARINDEX(); } 
            ({!CX->inEmptyHtmlTag && (CX->inHtmlPre || CX->inNowiki)}?=>
             ( ((SPACE_CHAR|NEWLINE_CHAR) => (SPACE_CHAR|NEWLINE_CHAR))*
               {bodyEnd = bodyStart = GETCHARINDEX(); } 
                 ( {CX->inNowiki}?=>  NOWIKI_BODY[&bodyEnd]|{CX->inHtmlPre}?=> PRE_BODY[&bodyEnd] ) )
             )?
            )
         )
        |  TAG_EXTENSION
        |  { MW_SETTYPE(SPECIAL); }
        )
        {
            if (CX->inNowiki) {
                CUSTOM = attrs;
                SETTEXT(SUBSTR2(bodyStart, bodyEnd));
                MW_SETTYPE(NOWIKI);
            } else if (CX->inHtmlPre) {
                CUSTOM = attrs;
                SETTEXT(SUBSTR2(bodyStart, bodyEnd));
                MW_SETTYPE(HTML_PRE);
                MW_EMIT();
                SPECULATION_FAILURE(CX, &CX->indentSpeculation);
            }
        }
    ;

fragment
TAG_EXTENSION
@init{
    ANTLR3_MARKER mark = 0;
    ANTLR3_MARKER nameStart = 0;
    ANTLR3_MARKER nameEnd = 0;
    ANTLR3_MARKER bodyStart = 0;
    ANTLR3_MARKER bodyEnd = 0;
    bool success = true;
    bool empty = false;
    pANTLR3_STRING name;
    pANTLR3_VECTOR attr = NULL;
    pANTLR3_STRING body = NULL;
    MWPARSER_TAGEXT *tagExt = NULL;
}:
    {
        mark = MARK();
        nameStart = GETCHARINDEX();
    }
    ({nameEnd = GETCHARINDEX();} LETTER)+
    (SPACE_TAB ATTRIBUTE_LIST_HTML[&attr]?)?
      ( ('>' | '/>' {empty = true;})
        (({name = SUBSTR2(nameStart, nameEnd), (tagExt = CX->getTagExtension(CX, name)) != NULL}?=>
           ({empty}?=> | {!empty}?=> {bodyEnd = bodyStart = GETCHARINDEX();} TAG_EXTENSION_BODY[name, &bodyEnd]) )
         | {success = false;})
      | {success = false;})
    {
        if (success) {
            if (tagExt->isBlock) {
                MW_SETTYPE(TAGEXT_BLOCK);
            } else {
                MW_SETTYPE(TAGEXT_INLINE);
            }
            if (attr == NULL) {
                attr = CX->vectorFactory->newVector(CX->vectorFactory);
            }
            if (!empty) {
                body = SUBSTR2(bodyStart, bodyEnd);
            }
            /*
             * Pack the name and body into the vector.
             */
            attr->add(attr, tagExt->name, NULL);
            attr->add(attr, body, NULL);
            CUSTOM = attr;
        } else {
            REWIND(mark);
            MW_SETTYPE(SPECIAL);
        }
        MW_EMIT();
    }
    ;

fragment
TAG_EXTENSION_BODY[pANTLR3_STRING name, ANTLR3_MARKER *bodyEnd]
@init{
    ANTLR3_MARKER start = 0;
    ANTLR3_MARKER end = 0;
    ANTLR3_MARKER tmpBodyEnd = 0;
}:
      (('</' ((LETTER)=> LETTER)+)=> '</' {start = GETCHARINDEX();} ((LETTER)=> {tmpBodyEnd = end = GETCHARINDEX();} LETTER)+ ((SPACE_TAB_CHAR)=> {tmpBodyEnd = GETCHARINDEX();} SPACE_TAB_CHAR)*
        (('>')=> '>' ({name->compareS(name, SUBSTR2(start, end)) == 0}?=> | {*bodyEnd = tmpBodyEnd;} TAG_EXTENSION_BODY[name, bodyEnd])

         | ({*bodyEnd = GETCHARINDEX();} . TAG_EXTENSION_BODY[name, bodyEnd])
         | {*bodyEnd = tmpBodyEnd;} EOF)
      )
    | EOF
    | ({*bodyEnd = GETCHARINDEX();} . TAG_EXTENSION_BODY[name, bodyEnd])
    ;

fragment
HTML_OPEN_TAG_INTERNAL[pANTLR3_VECTOR *attrs]
@init{
    bool isBlock = false;
    bool isHeading = false;
}:
    (
      ( 
       ( /* Start html block elements  */
        {isBlock = true;}
        (({!CX->htmlTableOpenDisabled}?=>      T A B L E           { MW_SETTYPE(HTML_TABLE_OPEN);      onHtmlTableOpen(CX); })      |
         ({!CX->htmlTbodyOpenDisabled}?=>      T B O D Y           { MW_SETTYPE(HTML_TBODY_OPEN);      onHtmlTbodyOpen(CX); })      |
         ({!CX->htmlCaptionOpenDisabled}?=>    C A P T I O N       { MW_SETTYPE(HTML_CAPTION_OPEN);    onHtmlCaptionOpen(CX); })    |
         ({!CX->htmlTrOpenDisabled}?=>         T R                 { MW_SETTYPE(HTML_TR_OPEN);         onHtmlTrOpen(CX); })         |
         ({!CX->htmlThOpenDisabled}?=>         T H                 { MW_SETTYPE(HTML_TH_OPEN);         onHtmlThOpen(CX); })         |
         ({!CX->htmlTdOpenDisabled}?=>         T D                 { MW_SETTYPE(HTML_TD_OPEN);         onHtmlTdOpen(CX); })         |
         ({!CX->htmlDivOpenDisabled}?=>        D I V               { MW_SETTYPE(HTML_DIV_OPEN);        onHtmlDivOpen(CX); })        |
         ({!CX->htmlPOpenDisabled}?=>          P                   { MW_SETTYPE(HTML_P_OPEN);          onHtmlPOpen(CX); })          |
         ({!CX->htmlPreDisabled}?=>            P R E               { MW_SETTYPE(HTML_PRE); CX->inHtmlPre = true; onHtmlPre(CX); })  |
         ({!CX->htmlCenterOpenDisabled}?=>     C E N T E R         { MW_SETTYPE(HTML_CENTER_OPEN);     onHtmlCenterOpen(CX); })     |
         ({!CX->htmlBlockquoteOpenDisabled}?=> B L O C K Q U O T E { MW_SETTYPE(HTML_BLOCKQUOTE_OPEN); onHtmlBlockquoteOpen(CX); }) |
        ({isHeading = true;}
         ({!CX->htmlH1OpenDisabled}?=>         H '1'               { MW_SETTYPE(HTML_H1_OPEN);         onHtmlH1Open(CX); })         |
         ({!CX->htmlH2OpenDisabled}?=>         H '2'               { MW_SETTYPE(HTML_H2_OPEN);         onHtmlH2Open(CX); })         |
         ({!CX->htmlH3OpenDisabled}?=>         H '3'               { MW_SETTYPE(HTML_H3_OPEN);         onHtmlH3Open(CX); })         |
         ({!CX->htmlH4OpenDisabled}?=>         H '4'               { MW_SETTYPE(HTML_H4_OPEN);         onHtmlH4Open(CX); })         |
         ({!CX->htmlH5OpenDisabled}?=>         H '5'               { MW_SETTYPE(HTML_H5_OPEN);         onHtmlH5Open(CX); })         |
         ({!CX->htmlH6OpenDisabled}?=>         H '6'               { MW_SETTYPE(HTML_H6_OPEN);         onHtmlH6Open(CX); }))        |
         ({!CX->htmlUlOpenDisabled}?=>         U L                 { MW_SETTYPE(HTML_UL_OPEN);         onHtmlUlOpen(CX); })         |
         ({!CX->htmlOlOpenDisabled}?=>         O L                 { MW_SETTYPE(HTML_OL_OPEN);         onHtmlOlOpen(CX); })         |
         ({!CX->htmlDlOpenDisabled}?=>         D L                 { MW_SETTYPE(HTML_DL_OPEN);         onHtmlDlOpen(CX); })         |
         ({!CX->htmlDdOpenDisabled}?=>         D D                 { MW_SETTYPE(HTML_DD_OPEN);         onHtmlDdOpen(CX); })         |
         ({!CX->htmlDtOpenDisabled}?=>         D T                 { MW_SETTYPE(HTML_DT_OPEN);         onHtmlDtOpen(CX); })         |
         ({!CX->htmlUlLiOpenDisabled}?=>       L I                 { MW_SETTYPE(HTML_UL_LI_OPEN);      onHtmlUlLiOpen(CX); })       |
         ({!CX->htmlOlLiOpenDisabled}?=>       L I                 { MW_SETTYPE(HTML_OL_LI_OPEN);      onHtmlOlLiOpen(CX); }))
         /* end block elements */                                                                                             )     |
         ({!CX->htmlSpanOpenDisabled}?=>       S P A N             { MW_SETTYPE(HTML_SPAN_OPEN);       onHtmlSpanOpen(CX); })       |
         ({!CX->htmlBOpenDisabled}?=>          B                   { MW_SETTYPE(HTML_B_OPEN);          onHtmlBOpen(CX); })          |
         ({!CX->htmlDelOpenDisabled}?=>        D E L               { MW_SETTYPE(HTML_DEL_OPEN);        onHtmlDelOpen(CX); })        |
         ({!CX->htmlIOpenDisabled}?=>          I                   { MW_SETTYPE(HTML_I_OPEN);          onHtmlIOpen(CX); })          |
         ({!CX->htmlInsOpenDisabled}?=>        I N S               { MW_SETTYPE(HTML_INS_OPEN);        onHtmlInsOpen(CX); })        |
         ({!CX->htmlUOpenDisabled}?=>          U                   { MW_SETTYPE(HTML_U_OPEN);          onHtmlUOpen(CX); })          |
         ({!CX->htmlFontOpenDisabled}?=>       F O N T             { MW_SETTYPE(HTML_FONT_OPEN);       onHtmlFontOpen(CX); })       |
         ({!CX->htmlBigOpenDisabled}?=>        B I G               { MW_SETTYPE(HTML_BIG_OPEN);        onHtmlBigOpen(CX); })        |
         ({!CX->htmlSmallOpenDisabled}?=>      S M A L L           { MW_SETTYPE(HTML_SMALL_OPEN);      onHtmlSmallOpen(CX); })      |
         ({!CX->htmlSubOpenDisabled}?=>        S U B               { MW_SETTYPE(HTML_SUB_OPEN);        onHtmlSubOpen(CX); })        |
         ({!CX->htmlSupOpenDisabled}?=>        S U P               { MW_SETTYPE(HTML_SUP_OPEN);        onHtmlSupOpen(CX); })        |
         ({!CX->htmlCiteOpenDisabled}?=>       C I T E             { MW_SETTYPE(HTML_CITE_OPEN);       onHtmlCiteOpen(CX); })       |
         ({!CX->htmlCodeOpenDisabled}?=>       C O D E             { MW_SETTYPE(HTML_CODE_OPEN);       onHtmlCodeOpen(CX); })       |
         ({!CX->htmlStrikeOpenDisabled}?=>     S T R I K E         { MW_SETTYPE(HTML_STRIKE_OPEN);     onHtmlStrikeOpen(CX); })     |
         ({!CX->htmlStrongOpenDisabled}?=>     S T R O N G         { MW_SETTYPE(HTML_STRONG_OPEN);     onHtmlStrongOpen(CX); })     |
         ({!CX->htmlTtOpenDisabled}?=>         T T                 { MW_SETTYPE(HTML_TT_OPEN);         onHtmlTtOpen(CX); })         |
         ({!CX->htmlVarOpenDisabled}?=>        V A R               { MW_SETTYPE(HTML_VAR_OPEN);        onHtmlVarOpen(CX); })        |
         ({!CX->htmlAbbrOpenDisabled}?=>       A B B R             { MW_SETTYPE(HTML_ABBR_OPEN);       onHtmlAbbrOpen(CX); })       |
         ({!CX->htmlBrDisabled}?=>             B R                 { MW_SETTYPE(HTML_BR);              onHtmlBr(CX); })             |
         ({!CX->htmlHrDisabled}?=>             H R                 { MW_SETTYPE(HORIZONTAL_RULE);      onHtmlHr(CX); })             |
         ({!CX->htmlImgDisabled}?=>            I M G               { MW_SETTYPE(HTML_IMG);             onHtmlImg(CX); })            |
         (                                     N O W I K I         { MW_SETTYPE(NOWIKI); CX->inNowiki = true;})
        )
        (SPACE_TAB 
           ATTRIBUTE_LIST_HTML[attrs]?
        )?
        (  '>'
         | ({PEEK(1, '/') && PEEK(2, '>')}?=> {CX->inEmptyHtmlTag = true; CX->emptyHtmlTagType = $type;})
        )
    )
    {
        if (CX->inEmptyHtmlTag || (!CX->inNowiki && !CX->inHtmlPre)) {
            if (!isHeading) {
                CUSTOM = *attrs;
                MW_EMIT();
            } else {
                CX->headingBeginToken = NEW_TOK($type, $text);
                CX->headingTextBegin = GETCHARINDEX();
                CX->headingBeginToken->custom = *attrs;
                EMITNEW(CX->headingBeginToken);
            }
            if (isBlock) {
                SPECULATION_FAILURE(CX, &CX->indentSpeculation);
            }
        }
    }
    ;

HTML_CLOSE_TAG
@init{
    ANTLR3_MARKER endHeadingText = 0;
}:
    {
        endHeadingText = GETCHARINDEX();
    }
    (
      '</'
      (
        (HTML_CLOSE_TAG_INTERNAL[0])=> HTML_CLOSE_TAG_INTERNAL[endHeadingText]
        | { MW_SETTYPE(SPECIAL); }
      )
    )
    |
    (
       {CX->inEmptyHtmlTag}?=> '/>' 
       {
            CX->inEmptyHtmlTag = false;
            $type = getEmptyHtmlEndToken(CX);
            if ($type == HTML_CLOSE_TAG) {
                /*
                 * The tag has no corresponding closing tag.
                 */
                 MW_HIDE();
            }
       }
    )
    ;


fragment
HTML_CLOSE_TAG_INTERNAL[ANTLR3_MARKER endHeadingText]
@init{
    bool isBlock = false;
    bool isHeading = false;
}:
    (
      (
       ( /* begin html block elements */
        {isBlock = true;}
        (({!CX->htmlTableCloseDisabled}?=>      T A B L E           { MW_SETTYPE(HTML_TABLE_CLOSE);      onHtmlTableClose(CX); })      |
         ({!CX->htmlTbodyCloseDisabled}?=>      T B O D Y           { MW_SETTYPE(HTML_TBODY_CLOSE);      onHtmlTbodyClose(CX); })      |
         ({!CX->htmlCaptionCloseDisabled}?=>    C A P T I O N       { MW_SETTYPE(HTML_CAPTION_CLOSE);    onHtmlCaptionClose(CX); })    |
         ({!CX->htmlTrCloseDisabled}?=>         T R                 { MW_SETTYPE(HTML_TR_CLOSE);         onHtmlTrClose(CX); })         |
         ({!CX->htmlThCloseDisabled}?=>         T H                 { MW_SETTYPE(HTML_TH_CLOSE);         onHtmlThClose(CX); })         |
         ({!CX->htmlTdCloseDisabled}?=>         T D                 { MW_SETTYPE(HTML_TD_CLOSE);         onHtmlTdClose(CX); })         |
         ({!CX->htmlUlCloseDisabled}?=>         U L                 { MW_SETTYPE(HTML_UL_CLOSE);         onHtmlUlClose(CX); })         |
         ({!CX->htmlPCloseDisabled}?=>          P                   { MW_SETTYPE(HTML_P_CLOSE);          onHtmlPClose(CX); })          |
         ({!CX->htmlCenterCloseDisabled}?=>     C E N T E R         { MW_SETTYPE(HTML_CENTER_CLOSE);     onHtmlCenterClose(CX); })     |
         ({!CX->htmlBlockquoteCloseDisabled}?=> B L O C K Q U O T E { MW_SETTYPE(HTML_BLOCKQUOTE_CLOSE); onHtmlBlockquoteClose(CX); }) |
        ({isHeading = true;}
         ({!CX->htmlH1CloseDisabled}?=>         H '1'               { MW_SETTYPE(HTML_H1_CLOSE);         onHtmlH1Close(CX); })         |
         ({!CX->htmlH2CloseDisabled}?=>         H '2'               { MW_SETTYPE(HTML_H2_CLOSE);         onHtmlH2Close(CX); })         |
         ({!CX->htmlH3CloseDisabled}?=>         H '3'               { MW_SETTYPE(HTML_H3_CLOSE);         onHtmlH3Close(CX); })         |
         ({!CX->htmlH4CloseDisabled}?=>         H '4'               { MW_SETTYPE(HTML_H4_CLOSE);         onHtmlH4Close(CX); })         |
         ({!CX->htmlH5CloseDisabled}?=>         H '5'               { MW_SETTYPE(HTML_H5_CLOSE);         onHtmlH5Close(CX); })         |
         ({!CX->htmlH6CloseDisabled}?=>         H '6'               { MW_SETTYPE(HTML_H6_CLOSE);         onHtmlH6Close(CX); }))        |
         ({!CX->htmlUlCloseDisabled}?=>         U L                 { MW_SETTYPE(HTML_UL_CLOSE);         onHtmlUlClose(CX); })         |
         ({!CX->htmlOlCloseDisabled}?=>         O L                 { MW_SETTYPE(HTML_OL_CLOSE);         onHtmlOlClose(CX); })         |
         ({!CX->htmlDlCloseDisabled}?=>         D L                 { MW_SETTYPE(HTML_DL_CLOSE);         onHtmlDlClose(CX); })         |
         ({!CX->htmlDdCloseDisabled}?=>         D D                 { MW_SETTYPE(HTML_DD_CLOSE);         onHtmlDdClose(CX); })         |
         ({!CX->htmlDtCloseDisabled}?=>         D T                 { MW_SETTYPE(HTML_DT_CLOSE);         onHtmlDtClose(CX); })         |
         ({!CX->htmlUlLiCloseDisabled}?=>       L I                 { MW_SETTYPE(HTML_UL_LI_CLOSE);      onHtmlUlLiClose(CX); })       |
         ({!CX->htmlOlLiCloseDisabled}?=>       L I                 { MW_SETTYPE(HTML_OL_LI_CLOSE);      onHtmlOlLiClose(CX); }))
         /* end hml block elements */                                                                                          )       |
         ({!CX->htmlSpanCloseDisabled}?=>       S P A N             { MW_SETTYPE(HTML_SPAN_CLOSE);       onHtmlSpanClose(CX); })       |
         ({!CX->htmlBCloseDisabled}?=>          B                   { MW_SETTYPE(HTML_B_CLOSE);          onHtmlBClose(CX); })          |
         ({!CX->htmlDelCloseDisabled}?=>        D E L               { MW_SETTYPE(HTML_DEL_CLOSE);        onHtmlDelClose(CX); })        |
         ({!CX->htmlICloseDisabled}?=>          I                   { MW_SETTYPE(HTML_I_CLOSE);          onHtmlIClose(CX); })          |
         ({!CX->htmlInsCloseDisabled}?=>        I N S               { MW_SETTYPE(HTML_INS_CLOSE);        onHtmlInsClose(CX); })        |
         ({!CX->htmlUCloseDisabled}?=>          U                   { MW_SETTYPE(HTML_U_CLOSE);          onHtmlUClose(CX); })          |
         ({!CX->htmlFontCloseDisabled}?=>       F O N T             { MW_SETTYPE(HTML_FONT_CLOSE);       onHtmlFontClose(CX); })       |
         ({!CX->htmlBigCloseDisabled}?=>        B I G               { MW_SETTYPE(HTML_BIG_CLOSE);        onHtmlBigClose(CX); })        |
         ({!CX->htmlSmallCloseDisabled}?=>      S M A L L           { MW_SETTYPE(HTML_SMALL_CLOSE);      onHtmlSmallClose(CX); })      |
         ({!CX->htmlSubCloseDisabled}?=>        S U B               { MW_SETTYPE(HTML_SUB_CLOSE);        onHtmlSubClose(CX); })        |
         ({!CX->htmlSupCloseDisabled}?=>        S U P               { MW_SETTYPE(HTML_SUP_CLOSE);        onHtmlSupClose(CX); })        |
         ({!CX->htmlCiteCloseDisabled}?=>       C I T E             { MW_SETTYPE(HTML_CITE_CLOSE);       onHtmlCiteClose(CX); })       |
         ({!CX->htmlCodeCloseDisabled}?=>       C O D E             { MW_SETTYPE(HTML_CODE_CLOSE);       onHtmlCodeClose(CX); })       |
         ({!CX->htmlStrikeCloseDisabled}?=>     S T R I K E         { MW_SETTYPE(HTML_STRIKE_CLOSE);     onHtmlStrikeClose(CX); })     |
         ({!CX->htmlStrongCloseDisabled}?=>     S T R O N G         { MW_SETTYPE(HTML_STRONG_CLOSE);     onHtmlStrongClose(CX); })     |
         ({!CX->htmlTtCloseDisabled}?=>         T T                 { MW_SETTYPE(HTML_TT_CLOSE);         onHtmlTtClose(CX); })         |
         ({!CX->htmlVarCloseDisabled}?=>        V A R               { MW_SETTYPE(HTML_VAR_CLOSE);        onHtmlVarClose(CX); })        |
         ({!CX->htmlAbbrCloseDisabled}?=>       A B B R             { MW_SETTYPE(HTML_ABBR_CLOSE);       onHtmlAbbrClose(CX); })
        ) SPACE_TAB_CHAR* '>'
     ) {
        MW_EMIT();
        if (isHeading) {
            CX->headingBeginToken->setText(CX->headingBeginToken, SUBSTR2(CX->headingTextBegin, endHeadingText));
        }
        if (isBlock) {
            SPECULATION_FAILURE(CX, &CX->indentSpeculation);
        }
    }
    ;

fragment
BEGIN_TABLE_INTERNAL
@init{
    pANTLR3_VECTOR attrs = NULL;
}:
    '{|' {onWikitextTableOpen(CX);}
    ATTRIBUTE_LIST_TABLE[&attrs]
    { CUSTOM = attrs; }
    ;

fragment
ATTRIBUTE_LIST_TABLE[pANTLR3_VECTOR *attrs]
@init{
    MWKEYVALUE attr;
    bool       success = false;
}:
    SKIP_SPACE
    (
       (
          ((ATTRIBUTE_NAME[NULL])=> ATTRIBUTE[&attr, &success]
             (ATTRIBUTE_PEEK_TABLE
               {
                   if (success) {
                       addAttribute(CX, attrs, attr);
                   }
               }
              |)
          |
           ATTRIBUTE_GARBAGE_TABLE)
       )
       SKIP_SPACE
    )*
   (NEWLINE|EOF)
    ;

fragment
ATTRIBUTE_LIST_TABLE_CELL[pANTLR3_VECTOR *attrs]
@init{
    MWKEYVALUE attr;
    bool       success = false;
    ANTLR3_MARKER mark = 0;
}:
    {
        mark = MARK();
    }
    (
    SKIP_SPACE
    (
       (
          ((ATTRIBUTE_NAME[NULL])=> ATTRIBUTE[&attr, &success]
              (ATTRIBUTE_PEEK_TABLE_CELL
               {
                   if (success) {
                       addAttribute(CX, attrs, attr);
                   }
               }
               |)
           |
           ATTRIBUTE_GARBAGE_TABLE_CELL)
        )
       SKIP_SPACE
    )*
    ( {!PEEK(2, '|')}?=> '|'
     |
     {
         REWIND(mark);
         if (*attrs != NULL) {
             (*attrs)->free(*attrs);
             *attrs = NULL;             
         }
     }
    )
    )
    ;

fragment
ATTRIBUTE_LIST_HTML[pANTLR3_VECTOR *attrs]
@init{
    MWKEYVALUE attr;
    bool       success = false;
}:
    (
       (
          ((ATTRIBUTE_NAME[NULL])=> ATTRIBUTE[&attr, &success] 
              (ATTRIBUTE_PEEK_HTML
               {
                   if (success) {
                       addAttribute(CX, attrs, attr);
                   }
               }
               |
              )
          |
           ATTRIBUTE_GARBAGE_HTML)
       )
       SKIP_SPACE
    )+
    ;

fragment
ATTRIBUTE[MWKEYVALUE *attr, bool *success]:
    ATTRIBUTE_NAME[&attr->key] SKIP_SPACE
    (
         ('=' SKIP_SPACE
              ((ATTRIBUTE_VALUE[NULL])=> (ATTRIBUTE_VALUE[&attr->value] {*success = true;})
               | {*success = false; }
              )
         )
         | {*success = false;}
    )
    ;

fragment
ATTRIBUTE_NAME[pANTLR3_STRING *name]
@init{
    ANTLR3_MARKER start = 0;
}:
    { start = GETCHARINDEX(); } 
    (('xml:')=>'xml:'|('xmlns:')=>'xmlns:')? (LETTER|DECIMAL_DIGIT)+ 
    { *name = SUBSTR1(start); }
    ;
 
fragment
ATTRIBUTE_VALUE[pANTLR3_STRING *value]
@init{
    ANTLR3_MARKER start = 0;
}:
    (
        ('"' 
           { start = GETCHARINDEX(); } 
           ~('"'|'<'|NEWLINE_CHAR|NON_PRINTABLE_CHAR)+ 
           { *value = SUBSTR1(start);} 
         '"')
    |  ('\''  
          { start = GETCHARINDEX(); } 
          ~('\''|'<'|NEWLINE_CHAR|NON_PRINTABLE_CHAR)+ 
          { *value = SUBSTR1(start);}
        '\'')
     // Regexp from Sanitizer.php: [a-zA-Z0-9!#$%&()*,\\-.\\/:;<>?@[\\]^_`{|}~]
     // The '<' and the '>' has been removed below.
    | 
        { start = GETCHARINDEX(); }
        (LETTER|DECIMAL_DIGIT|'!'|'#'|'$'|'%'|'&'|'('|')'|'*'|','|'-'|'.'
         |'/'|':'|';'|'?'|'@'|'['|']'|'^'|'_'|'`'|'{'|'|'|'}'|'~')+
        { *value = SUBSTR1(start);}
    //  This case (from Sanitizer.php) can never be matched as it is already covered by
    //  the previous case:
    //  (\#[0-9a-fA-F]+) # Technically wrong, but lots of
    //                   # colors are specified like this.
    //                   # We'll be normalizing it.
    //    | '#' HEX_DIGIT+
    )
    ;


fragment
ATTRIBUTE_PEEK_TABLE_CELL: {PEEK(1, ' ')||PEEK(1, '\t')||PEEK(1, '|')}?=>
    ;

fragment
ATTRIBUTE_GARBAGE_TABLE_CELL:
    /*
     * In a cell attribute list, the characters '|' and the '[[' token are not allowed.
     */
    (NON_WHITESPACE_OR_BAR_OR_OPEN_BRACKET_CHAR | {!PEEK(2, '[')}?=> '[')+
    ;

fragment
ATTRIBUTE_PEEK_TABLE:  {PEEK(1, ' ')||PEEK(1, '\t')||PEEK(1, '\n')||PEEK(1,'\r')||LA(1)==EOF}?=>
    ;

fragment
ATTRIBUTE_GARBAGE_TABLE: NON_WHITESPACE_CHAR+
    ;

fragment
ATTRIBUTE_PEEK_HTML:  {PEEK(1, ' ')||PEEK(1, '\t')||PEEK(1, '/')||PEEK(1, '>')}?=>
    ;

fragment
ATTRIBUTE_GARBAGE_HTML:
    (NON_WHITESPACE_OR_GT_OR_SLASH_CHAR | {!PEEK(2, '>')}?=> '/')+
    ;

//fragment CHARACTER:           WHITESPACE_CHAR | NON_WHITESPACE_CHAR | HTML_ENTITY;

fragment WHITESPACE:          WHITESPACE_CHAR+;
fragment WHITESPACE_CHAR:     SPACE_CHAR ;
fragment TAB_CHAR:            '\t'; 
fragment SPACE_CHAR:          ' ';
fragment SPACE_TAB_CHAR:      SPACE_CHAR|TAB_CHAR;
fragment NEWLINE_CHAR:        '\n' | '\r';
fragment NEWLINES:            NEWLINE+;
fragment NON_WHITESPACE_CHAR:   ~(SPACE_CHAR | TAB_CHAR | NEWLINE_CHAR);
fragment NON_WHITESPACE_OR_GT_OR_SLASH_CHAR:   ~(SPACE_TAB_CHAR | NEWLINE_CHAR |'>'|'/');
fragment NON_WHITESPACE_OR_BAR_OR_OPEN_BRACKET_CHAR: ~(SPACE_TAB_CHAR | NEWLINE_CHAR | '|' | '[' |'!'|
                              '-'|
                              '}');
fragment MEDIA_LINK_OPTION_VALUE_CHAR: ~(NON_PRINTABLE_CHAR|'|'|']');
fragment SKIP_SPACE:          ((SPACE_TAB_CHAR)=> SPACE_TAB_CHAR)*;
fragment LETTER:              UCASE_LETTER | LCASE_LETTER;
fragment HTML_ENTITY_CHARS:   HTML_ENTITY_CHAR+;
fragment HTML_ENTITY_CHAR:    UCASE_LETTER | LCASE_LETTER | DECIMAL_DIGIT;
fragment UCASE_LETTER:        'A'..'Z';
fragment LCASE_LETTER:        'a'..'z';
fragment HTML_UNSAFE_SYMBOL:  '<' | '>' | '&';
fragment UNDERSCORE:          '_';
fragment DECIMAL_NUMBER:      DECIMAL_DIGIT+;
fragment DECIMAL_DIGIT:       '0'..'9';
fragment HEX_NUMBER:          HEX_DIGIT+;
fragment HEX_DIGIT:           DECIMAL_DIGIT | ('A'..'F') | ('a'..'f');
fragment SPECIAL_SYMBOL:      '!'|'"'|'#'|'$'|'%'|'&'|'('|
                              ')'|'*'|'+'|','|'-'|'.'|'/'|':'|
                              ';'|'<'|'='|'>'|'?'|'@'|'['|'\\'|
                              ']'|'^'|'_'|'`'|'{'|'|'|'}'|'~';
fragment URL_CHAR: ~('<'|'>'|'['|']'|'\u0000' .. '\u0020'|'\u007F');


/* This should map the latin-1 range 0x80-0xff to the corresponding unicode codepoints: */
fragment LEGAL_TITLE_CHAR_RANGE: 'a'
    ;
fragment LEGAL_TITLE_CHARS:   LETTER|DECIMAL_DIGIT|'%'|'!'|
                              '"'|'$'|'&'|'\''|'('|')'|'*'|
                              ','|'-'|'.'|':'|';'|'='|'?'|'@'|
                              '\\'|'^'|'_'|'`'|'~'|LEGAL_TITLE_CHAR_RANGE|'+'
    ;

fragment NON_PRINTABLE_CHAR: ('\u0000' .. '\u0008') |'\u000b'|'\u000c'| ('\u000e' .. '\u001f')  | ('\u007f' .. '\u009f')
    ;

fragment
CHAR:  ~(SPECIAL_SYMBOL|SPACE_CHAR|TAB_CHAR|NEWLINE_CHAR|APOS|NON_PRINTABLE_CHAR|LETTER);

// perl -le 'print "fragment\n$_ : ('\''" . (lc $_) . "'\'' | '\''$_'\'') ;" for "A" .. "Z"'
fragment
A : ('a' | 'A') ;
fragment
B : ('b' | 'B') ;
fragment
C : ('c' | 'C') ;
fragment
D : ('d' | 'D') ;
fragment
E : ('e' | 'E') ;
fragment
F : ('f' | 'F') ;
fragment
G : ('g' | 'G') ;
fragment
H : ('h' | 'H') ;
fragment
I : ('i' | 'I') ;
fragment
J : ('j' | 'J') ;
fragment
K : ('k' | 'K') ;
fragment
L : ('l' | 'L') ;
fragment
M : ('m' | 'M') ;
fragment
N : ('n' | 'N') ;
fragment
O : ('o' | 'O') ;
fragment
P : ('p' | 'P') ;
fragment
Q : ('q' | 'Q') ;
fragment
R : ('r' | 'R') ;
fragment
S : ('s' | 'S') ;
fragment
T : ('t' | 'T') ;
fragment
U : ('u' | 'U') ;
fragment
V : ('v' | 'V') ;
fragment
W : ('w' | 'W') ;
fragment
X : ('x' | 'X') ;
fragment
Y : ('y' | 'Y') ;
fragment
Z : ('z' | 'Z') ;
