
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
"<"{Name}   {
                   printf("element name = %s", &yytext[1]);
                   yy_push_state(startElement);
               }


<startElement>{
{}           printf("Here");
{Name}{Ws}?[=]{Ws}?["']    {
                                /* this is an attribute, so let's use those rules */
                                yy_push_state(attribute);
                                yyless(0);  /* put back the entire lexeme */
                           }
}

<attribute>{

{Name}{Ws}?[=]    {
                    printf(yytext);
                    yyless(yyleng - 1); /* put back the equals sign */
                    /* get the attribute name */
                    /* TODO - strip the spaces from the name */
                }
[=]{Ws}?        ;   /* ignore */
{AttValue}      {
                    char* value = NULL;
                    yy_pop_state();
                    
                    /* set the value of the attribute */
                    value = malloc(yyleng + 1);
                    memset(value, 0, yyleng + 1);
                    memcpy(value, yytext, yyleng);
                    printf(value);
                }
}


%%
int yywrap(){ return 1;}
int main(){ yylex();
}
