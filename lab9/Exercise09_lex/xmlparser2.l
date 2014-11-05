
%{
#include <stdio.h>
#include <string.h>
%}

%option stack yylineno
%x startElement
%s endElement
%x attribute
%x xmlDecl
%x processingInstruction

Ws              ([ \t\r\n]+)
Letter          [A-Za-z]
Digit           [0-9]
NameChar        {Letter}|{Digit}|[-._:]
Name            ({Letter}|[_:]){NameChar}*
Comment         "<!--"[^-]*[-]{2,}([^->][^-]*[-]{2,})*">"
CData           "<![CDATA["[^\]]*[\]]{2,}([^\]>][^\]]*[\]]{2,})*">"
CharData        [^<&]*
AttValue        (\"[^<&"]*\")|("'"[^<&']*"'")
CharRef         "&#"[0-9]+";"|"&#x"[0-9a-fA-F]+";"
EntityRef       "&"{Name}";"
Char            [\t\n\r\x20-\xFF]
VersionNum      "1.0"
VersionInfo     {Ws}"version"{Ws}?"="{Ws}?{VersionNum}
EncName         [A-Za-z]([A-Za-z0-9._]|"-")*
EncodingDecl    {Ws}"encoding"{Ws}?"="{Ws}?(\"{EncName}\"|"'"{EncName}"'")
SDDecl          {Ws}"standalone"{Ws}?"="{Ws}?(("'"("yes"|"no")"'")|(\"("yes"|"no")\"))
XMLDecl         "<?"[xX][mM][lL]{VersionInfo}" encoding=UTF-8 ?>"
TextDecl        "<?"[xX][mM][lL]{VersionInfo}{EncodingDecl}?{Ws}?"?>"
UnknownDecl     "<?"{Name}[^?]*[?]+([^?>][^?]*[?]+)*">"
PI              "<?"{Name}({Ws}[^?]*)?[?]+([^?>][^?]*[?]+)*">"

%%
{XMLDecl}      printf("xml declaration version = 1.0, encoding = UTF-8");
"<"{Name}{Ws}?{Letter}+?"="?{AttValue}?">"   {
                   char otherString[strlen(yytext)]; // note 6, not 5, there's one there for the null terminator
                   strncpy(otherString, yytext, strlen(yytext)-1);
                   otherString[strlen(yytext)] = '\0'; // place the null terminator
                   printf("element name = %s", &otherString[1]);
                   yy_push_state(startElement);
               }


<startElement>{
{Ws}           printf("Here");
}



%%
int yywrap(){ return 1;}
int main(){ yylex();
}
