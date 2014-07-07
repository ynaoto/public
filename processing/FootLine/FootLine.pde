float a = 2;
float b = 0.5;

float f(float x) {
  return a * x + b;
}

PVector foot(PVector p) {
  /*
  [0] (nx,ny) を、点 p から直線に降ろした垂線が直線と交わる点とします。
  [1] ny = a*nx + b    　　　　　　　　　　　-> (nx,ny)は直線に乗っているはずです。
  [2] (p.x-nx, p.y-ny)・(1, a) = 0    　　-> 垂線は直線と直交しているので内積は0です。  
      -> (p.x-nx)+a(p.y-ny) = 0　　　　　　-> 式の変形(内積の計算)
      -> nx = p.x + a(p.y-ny)            -> nxを求めるように式を変形
            = p.x + a(p.y-(a*nx + b))    -> nyを[1]の式で置き換え
            = p.x + a*p.y - a(a*nx + b)  -> カッコをばらす
      -> nx + a*a*nx = p.x + a*p.y - a*b -> nxを左辺に寄せるように変形
      -> nx(1+a*a) = p.x + a*p.y - a*b   -> nxでくくる
  */
  float nx = (p.x + a*p.y - a*b) / (1+a*a);
  float ny = a*nx + b;
  return new PVector(nx, ny);
}

void setup() {
  size(300, 300);
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
  for (int px = 0; px < width; px++) {
    float x = map(px, 0, width, minx, maxx);
    float py = map(f(x), miny, maxy, height, 0);
    point(px, py);
  }
  
  // マウスの点からf(x)への垂線を描く。
  PVector p = new PVector(
    map(mouseX, 0, width, minx, maxx),
    map(mouseY, height, 0, miny, maxy)
  );
  PVector np = foot(p);
  line(mouseX, mouseY,
       map(np.x, minx, maxx, 0, width),
       map(np.y, miny, maxy, height, 0));
  
  // 垂線の長さを描く。
  fill(0);
  text(p.dist(np), 30, 30);
}

