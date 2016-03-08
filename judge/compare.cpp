/*
    compare   targetfile  standardfile

*/
#include<unistd.h>
#include <sys/stat.h>
#include<cstdio>
#include<cstring>
#include<iostream>
#include<fstream>
using namespace std;

#define AC 0
#define WA 1
#define PE 2
#define SE 3


char *targetfile = NULL, *standardfile = NULL;
string strt,strs;

inline void trim(string &str)
{
    while(str.length() && ( *(str.end()-1) == ' ' || *(str.end()-1) == '\n'))
        str.erase(str.end()-1);
}

int judge()
{
    struct stat st,ss;
    stat(targetfile,&st);
    stat(standardfile,&ss);

    if(st.st_size < ss.st_size / 2 || st.st_size > ss.st_size * 2) return WA; //accelerate
    bool flag = false;
    ifstream fint(targetfile,ifstream::in), fins(standardfile,ifstream::in);
    fint.sync_with_stdio(false);
    fins.sync_with_stdio(false);
    strt.reserve(MAXN);
    strs.reserve(MAXN);

    while(fint.good() || fins.good())
    {
        if(fint.good())
            getline(fint,strt);
        else strt = "";

        if(fins.good())
            getline(fins,strs);
        else strs = "";

        if(strt != strs)
        {
            trim(strt);
            trim(strs);
            if(strt == strs)
                flag = true;
            else
                return WA;
        }
    }
    if(flag)
        return PE;
    return AC;
}


int main(int argc,char *argv[])
{
    if(argc != 3)
    {
        printf("%d\n",SE);
        return 0;
    }

    standardfile = argv[1];
    targetfile = argv[2];

    if(!targetfile || !standardfile)
    {
        printf("%d\n",SE);
        return 0;
    }

    if(access(targetfile,R_OK) != 0 || access(standardfile,R_OK) != 0)
    {
        printf("%d\n",SE);
        return 0;
    }

    printf("%d\n",judge());

    return 0;

}
