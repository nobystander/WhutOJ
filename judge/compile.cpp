#include<stdio.h>
#include<string.h>
#include<stdlib.h>
#include <unistd.h>

#include "language.h"

int main(int argc,char *argv[])
{
    if(argc != 3)
        exit(1);

    int language = atoi(argv[2]);
    chdir(argv[1]);
    char buf[1000];

    switch(language)
    {
        case LANG_C:
            sprintf(buf,"gcc -o %s ./%s -O2 -Wall -lm --static -std=c99 -DONLINE_JUDGE",language_execname[language],language_filename[language]);
            break;
        case LANG_CPP:
            sprintf(buf,"g++ -o %s ./%s -O2 -Wall -lm --static -DONLINE_JUDGE",language_execname[language],language_filename[language]);
            break;
        case LANG_JAVA:
            sprintf(buf,"javac -J-Xms32m -J-Xmx256m ./%s",language_filename[language]);
            break;
    }
    int status = system(buf);

    if(status != -1 && WIFEXITED(status) && WEXITSTATUS(status) == 0)
        puts("YES");
    else
        puts("NO");

    return 0;
}
