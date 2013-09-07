#include <stdio.h>

struct _BigNum
{
  int n;
  char a[40];
};

void init(struct _BigNum *bn)
{
  int i;
  bn->n = sizeof(bn->a) / sizeof(bn->a[0]);
  for (i = 0; i < bn->n; i++) {
    bn->a[i] = 0;
  }
}

void pr(struct _BigNum *bn)
{
  int n = bn->n;
  char *d = bn->a;
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

void set(struct _BigNum *bn, int x)
{
  int n = bn->n;
  char *d = bn->a;
  int i;
  for (i = 0; i < n; i++) {
    d[i] = x % 10;
    x /= 10;
  }
}

void add(struct _BigNum *bn, int x)
{
  int n = bn->n;
  char *d = bn->a;
  int c = 0;
  int i;
  for (i = 0; i < n; i++) {
    int y = d[i] + (x % 10) + c;
    d[i] = y % 10;
    c = y / 10;
    x /= 10;
  }
}

void mul(struct _BigNum *bn, int x)
{
  int n = bn->n;
  char *d = bn->a;
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
  struct _BigNum a;
  init(&a);
  set(&a, 0);
  add(&a, 1);
  int i;
  for (i = 0; i < 80; i++) {
    mul(&a, 2);
  }
  add(&a, 1);
  pr(&a);
  return 0;
}
