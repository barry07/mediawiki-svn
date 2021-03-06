/*
 * (c) 2006 by Magnus Manske
 * Released under the terms of the GNU public license (GPL)
*/
#ifndef ZENO_FILE_H
#define ZENO_FILE_H

#include <wx/file.h>
#include <wx/dynarray.h>

class ZenoArticle ;
class ZenoFile ;

WX_DECLARE_OBJARRAY(ZenoArticle, ArrayOfZenoArticles);

wxChar CharToQ ( wxChar c ) ;
wxString String2Q ( wxString s ) ;

class ZenoArticle
{
    public :
    ZenoArticle () ;
    ~ZenoArticle () ;
    wxString GetText() ;
    char *GetBlob() ;
    int Compare ( wxString s ) ;
    int Compare ( wxArrayInt t , bool anything_starting_with = false ) ;
    
    wxLongLong rFilePos ;
    unsigned long rFileLen ;
    unsigned char rCompression , rMime , rSubtype , rSearchFlag ;
    unsigned long rSubtypeParent , rLogicalNumber ;
    unsigned long rExtraLen ;
    wxString title ;
    char *rExtra ;
    int index ;
    
    ZenoFile *zfile ;
    bool ok ;
	char *data ;

    private:
    wxString GetTextFromZip() ;
    wxString GetTextFromPlain() ;
    void load_qunicode() ;
};

class ZenoFile
{
    public :
    ZenoFile() ;
    bool Open ( wxString filename ) ;
    bool Ok () ;
    ZenoArticle ReadSingleArticle ( unsigned long number ) ;
    unsigned long FindPageID ( wxString page , bool anything_starting_with = false ) ;
    char *GetBlob ( wxLongLong pos , unsigned long length ) ;
    
    unsigned long GetFirstArticleStartingWith ( wxString start ) ;
    unsigned long SeekArticleRelative ( unsigned long start , long diff ) ;
    wxArrayString GetArticleTitles ( unsigned long start , unsigned long number ) ;
    void ReadIndex () ;

    unsigned long rMagicNumber , rVersion , rCount ;
    wxLongLong rIndexPos ;
    unsigned long rIndexLen , rFlags ;
    wxLongLong rIndexPtrPos ;
    unsigned long rIndexPtrLen ;
    unsigned long rUnused[4] ;

	void SetCacheData ( long number , char *data ) ;
	void Log ( wxString message , wxString function = _T("") ) ;
    
    ArrayOfZenoArticles articles , cache ;
    unsigned long *indexlist ;

    private:
    wxString m_filename ;
    bool m_success ;
    
    void ReadIndex ( wxFile &f ) ;
    void ReadIndexList ( wxFile &f ) ;
    void Seek ( wxFile &f , wxLongLong pos ) ;
    void ReadArticleData ( wxFile &f , ZenoArticle &art ) ;
    void ReadSingleArticle ( unsigned long number , wxFile &f , ZenoArticle &art ) ;
	unsigned long ReadLong ( wxFile &f ) ;
	wxUint16 ReadWord ( wxFile &f ) ;
	unsigned char *ReadLongFromBuffer ( unsigned char *pos , unsigned long &l ) ;
	unsigned char *ReadWordFromBuffer ( unsigned char *pos , wxUint16 &l ) ;
	int LookInCache ( wxString page ) ;
	ZenoArticle LookInCache ( unsigned long number ) ;
	void AddToCache ( ZenoArticle art ) ;
	char *GetCacheData ( wxLongLong pos , unsigned long length ) ;
};


#endif
