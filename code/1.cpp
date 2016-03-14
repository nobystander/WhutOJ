#include<bits/stdc++.h>
using namespace std;
typedef long long LL;

int main()
{
//	freopen("test.txt","r",stdin);
	int n;
	scanf("%d",&n);
	int x[4],y[4];
	for(int i=0;i<n;++i)
	{
		scanf("%d %d",x+i,y+i);
	}
	if(n == 1) puts("-1");
	else if(n == 2)
	{
		if(x[0] == x[1] || y[0] == y[1]) puts("-1");
		else printf("%d\n",abs(x[0]-x[1])*abs(y[0]-y[1]));
	}
	else if(n >= 3)
	{
		if(x[0] == x[1])
		{
			printf("%d\n",abs(y[0]-y[1])*abs(x[2]-x[1]));
		}
		else if(x[0] == x[2])
		{
			printf("%d\n",abs(y[0]-y[2])*abs(x[2]-x[1]));
		}
		else
		{
			printf("%d\n",abs(y[1]-y[2])*abs(x[2]-x[0]));
		}
	}
	return 0;
}
