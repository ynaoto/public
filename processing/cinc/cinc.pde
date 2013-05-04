int tx, ty;
int cx, cy;

void setup()
{
  size(320, 320);
  cx = tx = width/2;
  cy = ty = height/2;
}

int d2(int x1, int y1, int x2, int y2)
{
  int dx = x2 - x1, dy = y2 - y1;
  return dx*dx + dy*dy;
}

void draw()
{
  background(0);
  fill(0);
  stroke(255);
  ellipse(cx, cy, 300, 300);
  fill(255);
  int mx = mouseX, my = mouseY;
  if (d2(cx, cy, mx, my) < 135 * 135) {
    tx = mouseX;
    ty = mouseY;
  }
  ellipse(tx, ty, 30, 30);
}
