#include <stdio.h>

void pr(char *d, int n)
{
  int leading = 1;
  int i;
  for (i = n - 1; 0 < i; i--) {
    if (!leading || 0 < d[i]) {
      printf("%d", d[i]);
      leading = 0;
    }
  }
  printf("%d\n", d[0]);
}

void set(char *d, int n, int x)
{
  int i;
  for (i = 0; i < n; i++) {
    d[i] = x % 10;
    x /= 10;
  }
}

void add(char *d, int n, int x)
{
  int c = 0;
  int i;
  for (i = 0; i < n; i++) {
    int y = d[i] + (x % 10) + c;
    d[i] = y % 10;
    c = y / 10;
    x /= 10;
  }
}

void mul(char *d, int n, int x)
{
  int c = 0;
  int i;
  for (i = 0; i < n; i++) {
    int y = d[i] * x + c;
    d[i] = y % 10;
    c = y / 10;
  }
}

int main()
{
  char a[40];
  set(a, sizeof(a) / sizeof(a[0]), 0);
  add(a, sizeof(a) / sizeof(a[0]), 1);
  int i;
  for (i = 0; i < 80; i++) {
    mul(a, sizeof(a) / sizeof(a[0]), 2);
  }
  add(a, sizeof(a) / sizeof(a[0]), 1);
  pr(a, sizeof(a) / sizeof(a[0]));
  return 0;
}
