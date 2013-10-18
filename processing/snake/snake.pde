class Bar {
  PVector c;
  float l, r, vr;

  Bar(PVector c, float l) {
    this.c = c;
    this.l = l;
  }
  
  PVector getEndPoint() {
    float x = l * cos(r) + c.x;
    float y = l * sin(r) + c.y;
    return new PVector(x, y);
  }

  PVector draw() {
    PVector e = getEndPoint();
    line(c.x, c.y, e.x, e.y);
    return e;
  }
}

ArrayList <Bar> snake;

void setup() {
  size(640, 640);
  
  snake = new ArrayList<Bar>();
  PVector c = new PVector(width / 2, height / 2);
  for (int i = 0; i < 10000; i++) {
    Bar bar = new Bar(c, 5);
    bar.r = 0;
    bar.vr = random(-0.01, 0.01);
    snake.add(bar);
    c = bar.getEndPoint();
  }
  
  background(0);
  stroke(255);
}

void draw() {
  clear();
  for (int i = 0; i < snake.size(); i++) {
    Bar bar = snake.get(i);
    bar.r += bar.vr;
    PVector e = bar.draw();
    if (i < snake.size() - 1) {
      snake.get(i+1).c = e;
    }
  }
}

