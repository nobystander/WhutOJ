#include "compile.h"

void report_log(const char s[])
{
    fprintf(compile_log_fp,"%s\n",s);
}

void reopen(int fileno,const char* path,int oflag,mode_t mode)
{
    int tmp_fileno = open(path,oflag,mode);
    if(tmp_fileno == -1)
    {
        report_log("ERROR : open failed");
        exit(1);
    }
    dup2(tmp_fileno,fileno);
    close(tmp_fileno);
}


void compile()
{
    nice(10);

    reopen(STDERR_FILENO, COMPILE_ERROR_NAME,  O_WRONLY | O_CREAT | O_APPEND, S_IRWXU | S_IRGRP | S_IROTH);
    struct rlimit LIM;

    //CPU用时限制，软->SIGXCPU, 硬SIGKILL
    LIM.rlim_cur = LIM.rlim_max = COMPILE_TIME;
    if(setrlimit(RLIMIT_CPU,&LIM) < 0)
    {
        report_log("ERROR : setrlimit CPU");
        exit(1);
    }
    alarm(0); //取消之间，防止sleep恶意运行
    alarm(LIM.rlim_cur * 10);

    setuid(child_uid);
    setgid(child_gid);
    setpgid(0, 0);  //除了要终止子进程，还需要终止gcc等进程

    report_log("Now start compile");

    switch(language)
    {
        case LANG_C:
            execlp("gcc",
                  "gcc",
                  "-o",
                  language_execname[language],
                  language_filename[language],
                  "-O2",
                  "-Wall",
                  "-lm",
                  "--static",
                  "-std=c99",
                  "-DONLINE_JUDGE",
                  (char *)NULL);

           // sprintf(buf,"gcc -o %s ./%s -O2 -Wall -lm --static -std=c99 -DONLINE_JUDGE",language_execname[language],language_filename[language]);
            break;
        case LANG_CPP:
            execlp("g++",
                  "g++",
                  "-o",
                  language_execname[language],
                  language_filename[language],
                  "-O2",
                  "-Wall",
                  "-lm",
                  "--static",
                  "-DONLINE_JUDGE",
                  (char *)NULL);
          //  sprintf(buf,"g++ -o %s ./%s -O2 -Wall -lm --static -DONLINE_JUDGE",language_execname[language],language_filename[language]);
            break;
        case LANG_JAVA:
            execlp("javac",
                    "javac",
                    language_filename[language],
                    (char *)NULL);
       //     sprintf(buf,"javac -J-Xms32m -J-Xmx256m ./%s",language_filename[language]);
            break;
        default:
            report_log("ERROR : Unknown Language");
            exit(1);

    }
}

int watch()
{
    int status = 0;
    int used_time = 0;
    struct timeval case_startv, case_nowv;
    struct timezone case_startz, case_nowz;
    gettimeofday(&case_startv, &case_startz);

   // int cnt = 0;

    while(1)
    {
        usleep(50000);
//        cnt++;
        gettimeofday(&case_nowv, &case_nowz);
        used_time = case_nowv.tv_sec - case_startv.tv_sec;


        if(waitpid(child_pid,&status,WNOHANG) == 0) //还在运行
        {
            if(used_time > COMPILE_TIME)
            {
                report_log("Compile time limit exceed");
                FILE * t = fopen(COMPILE_ERROR_NAME,"a");
                fprintf(t,"Use too much time To compile\n");
                fclose(t);
                kill(-child_pid, SIGTERM);
                sleep(2);
                kill(-child_pid, SIGKILL);
                return 0;

            }
        }
        else
        {

            if(WIFEXITED(status))
            {
                if (EXIT_SUCCESS == WEXITSTATUS(status))
                {
                    report_log("Compile success!");
                    return 1; //success
                }
                else if (WEXITSTATUS(status) == 1)
                {
                    report_log("Compile error!");
                    return 0;
                }
                else
                {
                    report_log("ERROR : Unknown exit status");
                    return 0;
                }
            }
            else
            {
                if(WIFSIGNALED(status))
                {


                    report_log("Compile time limit exceed");
                    FILE * t = fopen(COMPILE_ERROR_NAME,"a");
                    fprintf(t,"Use too much time To compile\n");
                    fclose(t);
                    kill(-child_pid, SIGTERM);
                    sleep(2);
                    kill(-child_pid, SIGKILL);
                }
                else if(WIFSTOPPED(status))
                {
                    report_log("ERROR : Stop by other signals");
                }
                else
                {
                    report_log("ERROR : Unknown stop reason");
                }

                return 0;
            }

        }

    }
}





void init()
{
    if((compile_log_fp = fopen(COMPILE_LOG_NAME,"w+")) == NULL)
    {
        fprintf(stderr,"INIT ERROR : Open compile_log failed\n");
        exit(1);
    }

    struct passwd * child_user = getpwnam(JUDGE_USER_NAME);
    if(child_user == NULL)
    {
        report_log("ERROR : Can't find this user");
        exit(1);
    }
    child_uid = child_user->pw_uid;
    child_gid = child_user->pw_gid;

}




int main(int argc,char *argv[])
{
    if(argc != 3)
    {
        fprintf(stderr,"INIT ERROR : param [dir_path] [language]\n");
        exit(1);
    }

    language = atoi(argv[2]);
    char buf[PATH_MAX];
    sprintf(buf,"chmod %s %s","777",argv[1]);
    if(system(buf) != 0)
    {
        fprintf(stderr,"INIT ERROR : chmod failed\n");
        exit(1);
    }


    if(chdir(argv[1]) != 0)
    {
        fprintf(stderr,"INIT ERROR : can not enter this dir\n");
        exit(1);
    }

    init();

    parent_uid = geteuid();
    parent_gid = getegid();
    if(parent_uid != 0)
    {
        report_log("ERROR : compiler should be run as root.");
        exit(1);
    }

    int parent_pid = getpid();

    report_log("Now start compile");
    child_pid = fork();
    if(child_pid == 0)
    {
        compile();
        exit(0);
    }
    else
    {
        int res = watch();
        if(res)
            puts("YES");
        else
            puts("NO");
    }



    fclose(compile_log_fp);

    return 0;
}
