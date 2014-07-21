class Entity {
  float x, y;
  float vx, vy;
  float phase;
  Entity() {
    x = random(width);
    y = random(height);
    vx = random(-1, 1);
    vy = random(-1, 1);
    phase = random(0, 2*PI);
  }
  void update() {
    x += vx;
    y += vy;
    phase += PI/60;
    if (2*PI < phase) {
      phase -= 2*PI;
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
  init_handles(5);
  for (int i = 0; i < 20; i++) {
    entities.add(new Entity());
  }
}

void draw() {
  fill(0, 0, 0, 10);
  rect(0, 0, width, height);
//  background(255);
  int n = entities.size();
  for (int i = 0; i < n; i++) {
    Entity a = entities.get(i);
    a.vx = a.vy = 0;
    
    for (Handle h : handles) {
      float dah = dist(a.x, a.y, h.x, h.y);
      a.vx += 3*(h.x - a.x)/sq(dah);
      a.vy += 3*(h.y - a.y)/sq(dah);
    }

    for (int j = 0; j < n; j++) {
      if (j == i) continue;
      Entity b = entities.get(j);
      float dab = dist(a.x, a.y, b.x, b.y);
      if (dab < 10) {
        float dvx = 10*(a.x - b.x)/dab;
        float dvy = 10*(a.y - b.y)/dab;
        a.vx += dvx;
        a.vy += dvy;
      }
    }
  }
  pushStyle();
  noStroke();
  for (int i = 0; i < n; i++) {
    Entity a = entities.get(i);
    a.update();
    a.x += random(-1, 1);
    a.y += random(-1, 1);
    fill(map(112, 0, 360, 0, 255), 255, 255,
      map(cos(a.phase), 0, 1, 0, 255));
    a.draw();
  }
  popStyle();
  draw_handles();
}

