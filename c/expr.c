#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <assert.h>

typedef enum {
  TOK_NUM,
  TOK_PLUS, TOK_MINUS,
  TOK_MUL,
  TOK_LPAR, TOK_RPAR,
  TOK_EOL, TOK_EOF,
  TOK_INVALID,
} Tok;

static char *
tok2s(Tok tok)
{
  switch (tok) {
  case TOK_NUM: return "TOK_NUM";
  case TOK_PLUS: return "TOK_PLUS";
  case TOK_MINUS: return "TOK_MINUS";
  case TOK_MUL: return "TOK_MUL";
  case TOK_LPAR: return "TOK_LPAR";
  case TOK_RPAR: return "TOK_RPAR";
  case TOK_EOL: return "TOK_EOL";
  case TOK_EOF: return "TOK_EOF";
  case TOK_INVALID: return "TOK_INVALID";
  }

  fprintf(stderr, "can't happen!\n");
  abort();
}

static void
getnum(FILE *fp, char *buf, int buf_size)
{
  int c;
  int i = 0;
  while (i < buf_size - 1 && (c = fgetc(fp)) != EOF && isdigit(c))
    buf[i++] = c;
  buf[i] = '\0';
  ungetc(c, fp);
}

static Tok
gettok(FILE *fp, char *buf, int buf_size)
{
  int c;

  while ((c = fgetc(fp)) != EOF && c != '\n' && isspace(c))
    ;

  switch (c) {
  case EOF: return TOK_EOF;
  case '\n': return TOK_EOL;
  case '+': return TOK_PLUS;
  case '-': return TOK_MINUS;
  case '*': return TOK_MUL;
  case '(': return TOK_LPAR;
  case ')': return TOK_RPAR;
  }

  assert(2 <= buf_size);
  buf[0] = c;
  buf[1] = '\0';

  if (isdigit(c)) {
    getnum(fp, buf + 1, buf_size - 1);
    return TOK_NUM;
  }

  return TOK_INVALID;
}

#define BUF_SIZE 16

static int plus(int a, int b) { return a + b; }
static int minus(int a, int b) { return a - b; }
static int mul(int a, int b) { return a * b; }

static Tok expr(FILE *fp, int *result);

static Tok
term(FILE *fp, int *result)
{
  /*
   * TERM :=
   *   | '(' EXPR ')'
   *   | NUM
   *   | NUM '*' TERM
   */
  Tok tok;
  char buf[BUF_SIZE];
  int acc, n, (*op)(int, int) = NULL;

  tok = gettok(fp, buf, BUF_SIZE);
  if (tok == TOK_EOF) {
    return TOK_EOF;
  } else if (tok == TOK_LPAR) {
    if ((tok = expr(fp, &acc)) != TOK_RPAR) {
      fprintf(stderr, "term: incomplete pair of parenthesis\n");
      return TOK_INVALID;
    }
  } else if (tok == TOK_NUM) {
    acc = strtol(buf, NULL, 10);
  } else {
    fprintf(stderr, "term: invalid token %s\n", tok2s(tok));
    return TOK_INVALID;
  }

  tok = gettok(fp, buf, BUF_SIZE);
  if (tok == TOK_PLUS || tok == TOK_MINUS || tok == TOK_RPAR
  || tok == TOK_EOL || tok == TOK_EOF) {
    *result = acc;
    return tok;
  } else if (tok == TOK_MUL) {
    op = mul;
  } else {
    fprintf(stderr, "term: invalid operator %s\n", tok2s(tok));
    return TOK_INVALID;
  }

  if ((tok = term(fp, &n)) != TOK_INVALID) {
    assert(op != NULL);
    *result = op(acc, n);
  }
  return tok;
}

static Tok
expr(FILE *fp, int *result)
{
  /*
   * EXPR :=
   *   | TERM
   *   | TERM '+'|'-' TERM ...
   */
  Tok tok;
  int acc;

  tok = term(fp, &acc);

  while (tok != TOK_EOL && tok != TOK_EOF && tok != TOK_RPAR) {
    int n, (*op)(int, int) = NULL;

    if (tok == TOK_PLUS) {
      op = plus;
    } else if (tok == TOK_MINUS) {
      op = minus;
    } else {
      fprintf(stderr, "term: invalid operator %s\n", tok2s(tok));
      break;
    }

    if ((tok = term(fp, &n)) == TOK_INVALID) {
      fprintf(stderr, "expr: invalid token %s\n", tok2s(tok));
      break;
    }

    assert(op != NULL);
    acc = op(acc, n);
  }

  if (tok != TOK_INVALID) {
    *result = acc;
  }
  return tok;
}

int
main()
{
  Tok tok;
  int a;

  /*// test term() function
  while ((tok = term(stdin, &a)) != TOK_EOF) {
    if (tok != TOK_INVALID) {
      printf("term>>> tok = %s; a = %d\n", tok2s(tok), a);
    }
  }
  /**/

  /*// test expr() function
  while ((tok = expr(stdin, &a)) != TOK_EOF) {
    if (tok != TOK_INVALID) {
      printf("expr>>> tok = %s; a = %d\n", tok2s(tok), a);
    }
  }
  /**/

  if ((tok = expr(stdin, &a)) != TOK_INVALID) {
    printf("%d\n", a);
    return 0;
  }

  return 1;
}
