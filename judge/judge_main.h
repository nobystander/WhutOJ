#ifndef JUDGE_MAIN_H
#define JUDGE_MAIN_H

#include<stdio.h>
#include<string.h>
#include <ctype.h>
#include<unistd.h>
#include<stdlib.h>
#include<pwd.h>

#include<dirent.h>
#include<fcntl.h>
#include<signal.h>
#include <errno.h>

// PATH_MAX, FILE_MAX
#ifdef __APPLE__
#include <sys/syslimits.h>
#elif defined(__LINUX__)
#include <linux/limits.h>
#endif


#include<sys/time.h>
#include<sys/resource.h>
#include<sys/types.h>
#include<sys/ptrace.h>
#include<sys/stat.h>
#include <sys/wait.h>


#include "syscall_checker.h"

#include<iostream>
#include<fstream>
using namespace std;

#define MB (1048576)

//CONFIG
#define JUDGE_USER_NAME "msi"
#define DATA_DIR "/home/msi/workspace/judge/data"
#define RUN_DIR "/home/msi/workspace/judge/run"



enum judge_status {
    JUDGE_SE = -1,
    JUDGE_PD = 0, // Pending
    JUDGE_RJ = 1,    // Running & judging
    JUDGE_CE = 2,     // Compile Error
    JUDGE_AC = 3,     // Accepted
    JUDGE_RE = 4,     // Runtime Error
    JUDGE_WA = 5,     // Wrong Answer
    JUDGE_TLE = 6,    // Time Limit Exceeded
    JUDGE_MLE = 7,    // Memory Limit Exceeded
    JUDGE_OLE = 8,    // Output Limit Exceeded
    JUDGE_PE = 9,     // Presentation Error
};

enum language_type {
    LANG_C,
    LANG_CPP,
    LANG_JAVA
};


const char language_suffix[][10] = {
    "c",
    "cpp",
    "java"
};


char input_dir[PATH_MAX]; //输入文件dir  /data/problem_id/input/
char output_dir[PATH_MAX]; //           /data/problem_id/input/
char input_path[PATH_MAX];
char output_path[PATH_MAX];
char code_dir[PATH_MAX];        //run/run_id/
char code_path[PATH_MAX]; //带测code
char code_exec[PATH_MAX];
char code_output_path[PATH_MAX];
char code_error_path[PATH_MAX];

long run_id;
long problem_id;
long language; //语言
long time_limit;
long memory_limit;

uid_t parent_uid,child_uid;
gid_t parent_gid,child_gid;
pid_t child_pid;



#endif
