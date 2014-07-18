float[] tt = { 0, 1, 2, 3, 4 };

float L(int n, int i, float t) {
  float a = 1, b = 1;
  for (int j = 0; j <= n; j++) {
    if (j == i) continue;
    a *= t - tt[j];
  }
  for (int j = 0; j <= n; j++) {
    if (j == i) continue;
    b *= tt[i] - tt[j];
  }
  return a/b;
}

void setup() {
  size(300, 300);
  colorMode(HSB);
  init_handles(tt.length);
}

void draw() {
  fill(0, 0, 255, 10);
  rect(0, 0, width, height);
  int n = handles.size();
  for (float t = 0; t <= 1; t += 0.01) {
    float x = 0, y = 0;
    for (int i = 0; i < n; i++) {
      Handle h = handles.get(i);
      float a = L(n-1, i, t);
      x += a*h.x;
      y += a*h.y;
    }
    fill(map(t, 0, 1, 0, 255), 255, 255);
    ellipse(x, y, 10, 10);
  }
  draw_handles();
}

