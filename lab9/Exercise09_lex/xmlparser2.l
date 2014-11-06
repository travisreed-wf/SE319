
%{
#include <stdio.h>
#include <string.h>
int unclosedElements = 0;

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
"<"{Name}      {
                   printf("element name = %s ", &yytext[1]);
                   unclosedElements += 1;
                   yy_push_state(startElement);
               }


<startElement>{
{Name}{Ws}?[=]{Ws}?["']    {
                                /* this is an attribute, so let's use those rules */
                                yy_push_state(attribute);
                                yyless(0);  /* put back the entire lexeme */
                           }
"/>"            {
                    yy_pop_state();
                    printf("empty");
                    unclosedElements -= 1;
                }

[>]             {
                    yy_pop_state();
                    yy_push_state(endElement);

                }
[ \t\n]         ; /* ignore whitespace */
}

<attribute>{

{Name}{Ws}?[=]    {
                    printf(" %s", yytext);
                    yyless(yyleng - 1); /* put back the equals sign */
                    /* get the attribute name */
                }
[=]{Ws}?        ;   /* ignore */
{AttValue}      {
                    char* value = NULL;
                    yy_pop_state();
                    
                    /* set the value of the attribute */
                    value = malloc(yyleng + 1);
                    memset(value, 0, yyleng + 1);
                    memcpy(value, yytext, yyleng);
                    printf(" %s", value);
                }
}
<endElement>{
"</"{Name}">"   {
                    yy_pop_state();
                    unclosedElements -= 1;
                }


{CharData}      {
                    printf(" text=%s\n", yytext);
                }
}
%%
int yywrap(){ return 1;}
int main(){ 
    yylex();
    if (unclosedElements != 0){
        printf("\nInvalid xml, an element is not closed\n");
        return 0;
    }
    printf("\n");
}
