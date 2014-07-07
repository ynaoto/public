class Handle {
  float x, y;
  color c;
  float r;
  boolean selected;
  Handle (float x, float y, color c) {
    this.x = x;
    this.y = y;
    this.c = c;
    r = 10;
  }
  void draw() {
    pushStyle();
    color col = c;
    if (selected) {
      col = color((hue(c)+128) % 256, 255, 255);
    }
    fill(col);
    ellipse(x, y, 2*r, 2*r);
    popStyle();
  }
  boolean hit(float px, float py) {
    return dist(x, y, px, py) < r;
  }
}

class Slider extends Handle {
  float minv, maxv;
  float value;
  Slider(float x, float minv, float maxv, color c) {
    super(x, 0, c);
    this.minv = minv;
    this.maxv = maxv;
    setValue(0);
  }
  void setValue(float v) {
    value = v;
    y = map(v, minv, maxv, height, 0);
  }
  void moveTo(float y) {
    this.y = y;
    value = map(y, height, 0, minv, maxv); 
  }
  void draw() {
    super.draw();
    pushStyle();
    fill(0, 0, 0);
    text(value, x, y + 2*r);
    popStyle();
  }
}

ArrayList<Slider> sliders;
int numSliders = 6;
float minv = -10, maxv = 10;

float f(float x) {
  float a = sliders.get(0).value;
  float b = sliders.get(1).value;
  float c = sliders.get(2).value;
  float d = sliders.get(3).value;
  float e = sliders.get(4).value;
  float f = sliders.get(5).value;
  //return a*x*x*x*x*x + b*x*x*x*x + c*x*x*x + d*x*x + e*x + f;
  return a*sin(b*x+c) + d*sin(e*x+f); 
}

void setup() {
  size(300, 300);
  colorMode(HSB);
  sliders = new ArrayList<Slider>();
  for (int i = 0; i < numSliders; i++) {
    Slider s = new Slider(10 + i * 30, minv, maxv, color(100, 255, 255));
    sliders.add(s);
  }
}

void draw() {
  background(255);
  
  // 画面に描く座標の縦横幅を決めておく。
  float minx = -1, maxx = 1;
  float miny = -1, maxy = 1;
  
  // 真ん中の点を計算して座標の線を描く。
  float mx = map((minx+maxx)/2, minx, maxx, 0, width);
  float my = map((miny + maxy)/2, miny, maxy, height, 0);
  line(0, my, width, my);
  line(mx, 0, mx, height);
  
  // f(x)のグラフを描く。
  float lastY = 0;
  for (int px = 0; px < width; px++) {
    float x = map(px, 0, width, minx, maxx);
    float py = map(f(x), miny, maxy, height, 0);
    if (0 < px) {
      line(px - 1, lastY, px, py);
    } else {
      point(px, py);
    }
    lastY = py;
  }

  for (Slider s : sliders) {
    s.draw();
  }
}

Slider dragging = null;
float dragStartX, dragStartY;
float dragOriginX, dragOriginY;

void mouseMoved() {
  for (Slider s : sliders) {
    s.selected = s.hit(mouseX, mouseY);
  }
}

void mousePressed() {
  for (Slider s : sliders) {
    if (s.selected) {
      dragging = s;
      break;
    }
  }
  if (dragging != null) {
    dragStartX = mouseX;
    dragStartY = mouseY;
    dragOriginX = dragging.x;
    dragOriginY = dragging.y;
  }
}

void mouseDragged() {
  if (dragging == null) {
    return;
  }
  dragging.moveTo(dragOriginY + (mouseY - dragStartY));
}

void mouseReleased() {
  dragging = null;
}
