#ifndef COMPILE_H
#define COMPILE_H


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

#include "language.h"
#include "config.h"


#define COMPILE_ERROR_NAME "compile_error"
#define COMPILE_LOG_NAME "compile_log"


uid_t parent_uid,child_uid;
gid_t parent_gid,child_gid;
pid_t child_pid;
int language;

FILE* compile_log_fp;


#endif
