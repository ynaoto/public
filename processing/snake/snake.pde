class Bar {
  PVector c;
  float r;
  float th;

  PVector getEndPoint()
  {
    float x1 = r * cos(th) + c.x;
    float y1 = r * sin(th) + c.y;
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
  Bar lastBar = null;
  for (int i = 0; i < 2; i++) {
    Bar bar = new Bar();
    if (lastBar != null) {
      bar.c = lastBar.getEndPoint();
    } else {
      bar.c = new PVector(width / 2, height / 2); 
    }
    bar.r = 100;
    bar.th = 0;
    snake.add(bar);
    lastBar = bar;
  }
  
  background(0);
}

void mousePressed() {
}

void draw() {
  pushStyle();
  fill(0, 1);
  rect(0, 0, width, height);
  fill(#FCA708, 50);
  for (int i = 0; i < snake.size(); i++) {
    Bar bar = snake.get(i);
    bar.draw();
  }
  popStyle();
}

