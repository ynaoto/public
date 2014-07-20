float[] a;

void walk(int startX, int startY) {
  float th = 0.47;
  int idx = startY*width + startX;
  pixels[idx] = color(map(a[idx], th, 1, 0, 30), 1, 1);
  a[idx] = -1;
  if (0 < startX) { // left
    idx = startY*width + startX - 1;
    if (th < a[idx]) {
      walk(startX-1, startY);
    }
  }
  if (startX < width-1) { // right
    idx = startY*width + startX + 1;
    if (th < a[idx]) {
      walk(startX+1, startY);
    }
  }
  if (0 < startY) { // up
    idx = (startY - 1)*width + startX;
    if (th < a[idx]) {
      walk(startX, startY-1);
    }
  }
  if (startY < height-1) { // down
    idx = (startY + 1)*width + startX;
    if (th < a[idx]) {
      walk(startX, startY+1);
    }
  }
}

void setup() {
  size(300, 300);
  colorMode(HSB, 360, 1, 1);
  frameRate(20);
  background(0);
  a = new float[width*height];
}

void draw() {
  fill(0, 0, 0, 30);
  noStroke();
  rect(0, 0, width, height);
//  background(0);
  strokeWeight(3);
  stroke(50, 1, 1);
  line(width/2, 0, width/2, 2*height/3);
  noStroke();
  fill(10, 1, 1);
  ellipse(width/2, 2*height/3, 10, 10);
  loadPixels();
  for (int i = 0; i < width*height; i++) {
    a[i] = random(0, 1);
  }
  walk(width/2, 2*height/3);
  updatePixels();
//  filter(BLUR);
}

