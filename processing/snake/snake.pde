class Bar {
  float l, vr, r;
  PVector c;

  Bar(float l, float vr)
  {
    this.l = l;
    this.vr = vr;
    this.r = 0;
  }
  
  PVector getEndPoint()
  {
    return new PVector(l * cos(r) + c.x, l * sin(r) + c.y);
  }

  PVector draw()
  {
    PVector e = getEndPoint();
    line(c.x, c.y, e.x, e.y);
    return e;
  }
}

ArrayList <Bar> snake;

void setup()
{
  size(640, 640);
  stroke(255);
  snake = new ArrayList<Bar>();
  for (int i = 0; i < 10000; i++) {
    Bar bar = new Bar(5, random(-0.01, 0.01));
    snake.add(bar);
  }
}

void draw()
{
  background(0);
  PVector c = new PVector(width / 2, height / 2);
  for (Bar bar: snake) {
    bar.c = c;
    bar.r += bar.vr;
    c = bar.draw();
  }
}

