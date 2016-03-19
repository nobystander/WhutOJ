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

int main()
{
  //  freopen("./test.txt","r",stdin);
    int kase;
    scanf("%d",&kase);
    while(kase--)
    {
        edges.clear();
        scanf("%d",&n);
        for(int i = 1;i <= n;++i) G[i].clear();
        for(int i = 0;i < n-1;++i)
        {
            int a,b,w;
            scanf("%d %d %d",&a,&b,&w);
            addEdge(a,b,w);
            addEdge(b,a,w);
        }
        dfs(1,-1,0);
        memset(cnt,0,sizeof(cnt));
        for(int i = 1;i <= n;++i)
            cnt[num[i]]++;

        scanf("%d",&q);
        while(q--)
        {
            int s;
            scanf("%d",&s);
            LL res = 0;
            LL temp = 0;
            for(int i = 0;i <= 140000;++i)
            {
                int t = i^s;
                if(i == t)
                    temp += cnt[i] + (LL)cnt[i]*(cnt[i]-1)/2;
                else
                    res += (LL)cnt[i]*cnt[t];
            }
            printf("%lld\n",res/2 + temp);
        }
    }
    return 0;
}