float[] tt = { 0, 0.25, 0.5, 0.75, 1 };

float L(int n, int i, float t) {
  float a = 1, b = 1;
  for (int j = 0; j <= n; j++) {
    if (j == i) continue;
    a *= t - tt[j];
    b *= tt[i] - tt[j];
  }
  return a/b;
}

int RESTING = 0;
int FLYING = 1;

class Entity {
  float x, y;
  float phase;
  int state;
  float t; // for flying
  float[] xx, yy; 
  Entity() {
    x = random(width);
    y = random(height);
    phase = random(0, 2*PI);
    state = RESTING;
    xx = new float[tt.length];
    yy = new float[tt.length];
  }
  void update() {
    phase += PI/60;
    if (2*PI < phase) {
      phase -= 2*PI;
    }
    if (state == RESTING && 99.98 < random(0, 100)) {
      state = FLYING;
      t = 0;
      xx[0] = x;
      yy[0] = y;
      for (int i = 1; i < tt.length; i++) {
        xx[i] = random(width);
        yy[i] = random(width);
      } 
    }
    if (state == FLYING) {
      x = 0; y = 0;
      for (int i = 0; i < tt.length; i++) {
        float a = L(tt.length-1, i, t);
        x += a*xx[i];
        y += a*yy[i];
      }
      t += random(0, 0.01);
      if (1 <= t) {
        state = RESTING;
      }
    }
  }
  void draw() {
    ellipse(x, y, 8, 8);
  }
}

ArrayList<Entity> entities = new ArrayList<Entity>();

void setup() {
  size(300, 300);
  colorMode(HSB);
  for (int i = 0; i < 20; i++) {
    entities.add(new Entity());
  }
  background(0);
  noStroke();
}

void draw() {
  fill(0, 0, 0, 10);
  rect(0, 0, width, height);
//  background(255);
  int n = entities.size();
  for (int i = 0; i < n; i++) {
    Entity a = entities.get(i);
    a.update();
    a.x += random(-1, 1);
    a.y += random(-1, 1);
    fill(map(112, 0, 360, 0, 255), 255, 255,
      map(cos(a.phase), 0, 1, 0, 255));
    a.draw();
  }
}

