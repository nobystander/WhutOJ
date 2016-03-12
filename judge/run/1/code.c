#include<stdio.h>
#include<unistd.h> 
#include<sys/types.h>



int main()
{	
	int A[20];
int i;
	for(i = 0;i < 1000;++i)
	printf("%d\n",A[i]);
	int t;
	scanf("%d",&t);
	printf("%d \n",t);
	return 0;
}
