class Bar {
  PVector c;
  float l;
  float r;
  float vr;

  PVector getEndPoint() {
    float x1 = l * cos(r) + c.x;
    float y1 = l * sin(r) + c.y;
    return new PVector(x1, y1);
  }

  void draw() {
    PVector e = getEndPoint();
    line(c.x, c.y, e.x, e.y);
  }
}

ArrayList <Bar> snake;

void setup() {
  size(640, 640);
  
  snake = new ArrayList<Bar>();
  PVector lastC = new PVector(width / 2, height / 2);
  for (int i = 0; i < 10000; i++) {
    Bar bar = new Bar();
    bar.c = lastC;
    bar.l = 5;
    bar.r = 0;
    bar.vr = random(-0.1, 0.1);
    snake.add(bar);
    lastC = bar.getEndPoint();
  }
  
  background(0);
  stroke(255);
}

void mousePressed() {
}

void draw() {
  fill(0);
  rect(0, 0, width, height);
  for (int i = 0; i < snake.size(); i++) {
    Bar bar = snake.get(i);
    bar.r += bar.vr;
    bar.draw();
    if (i < snake.size() - 1) {
      snake.get(i+1).c = bar.getEndPoint();
    }
  }
}

