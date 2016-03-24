#pragma comment(linker, "/STACK:1024000000,1024000000")
#include<cstdio>
#include<cstring>
#include<algorithm>
#include<vector>
using namespace std;

const int maxn = 100000+10;
const int maxm = 150000;
typedef long long LL;
struct Edge
{
    int from,to,w;
    Edge(int u,int v,int w):from(u),to(v),w(w) {}
};

vector<Edge> edges;
vector<int> G[maxn];

void addEdge(int from,int to,int w)
{
    edges.push_back(Edge(from,to,w));
    int m = edges.size();
    G[from].push_back(m-1);
}

int n,q;

int num[maxn];

void dfs(int u,int fa,int sum)
{
    num[u] = sum;
    for(int i = 0;i < G[u].size();++i)
    {
        Edge& e = edges[G[u][i]];
        if(e.to == fa) continue;
        dfs(e.to,u,sum^e.w);
    }
}

int cnt[maxm];

int cal(int n)
{
if(n == 0) return 1;
else if(n==1) return 2;
else return cal(n-1) + cal(n-2);
}

int main()
{
  //  freopen("./test.txt","r",stdin);
    int kase;
    int a,b;
cal(30);
scanf("%d %d",&a,&b);
printf("%d\n",a+b);
    return 0;
}