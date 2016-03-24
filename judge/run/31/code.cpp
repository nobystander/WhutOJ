 #include<stdio.h>

int main()
{
int t = 0;
for(int i = 0;i < 10000000;++i)
 t += i%100;
int a,b;
scanf("%d %d",&a,&b);
printf("%d\n",a+b);
} 