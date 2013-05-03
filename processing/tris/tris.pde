class Point2D
{
  float x, y;
}

class Point3D
{
  float x, y, z;
}

class Camera
{
  float d;
  Point2D proj(Point3D p)
  {
    Point2D q = new Point2D();
    q.x = d * p.x / (d + p.z);
    q.y = d * p.y / (d + p.z);
    return q;
  }
}

class Tri
{
  float x, y, z;
  float r, theta, phi;
  Point3D v[];
  private Point2D v2d[];
  
  Tri()
  {
    v = new Point3D[3];
    v2d = new Point2D[3];
    for (int i = 0; i < 3; i++) {
      v[i] = new Point3D();
    }
  }
  
  void draw(Camera cam)
  {
    for (int i = 0; i < 3; i++) {
      v2d[i] = cam.proj(v[i]);
      v2d[i].x += width / 2;
      v2d[i].y += height / 2;
    }
    float ax = v2d[1].x - v2d[0].x;
    float ay = v2d[1].y - v2d[0].y;
    float bx = v2d[2].x - v2d[0].x;
    float by = v2d[2].y - v2d[0].y;
    float ext = ax*by-ay*bx;
    if (ext < 0) {
      fill(255, 0, 0);
    } else {
      fill(255);
    }
    noStroke();
    beginShape();
    vertex(v2d[0].x, v2d[0].y);
    vertex(v2d[1].x, v2d[1].y);
    vertex(v2d[2].x, v2d[2].y);
    endShape(CLOSE);
  }

  void rot(float rx, float ry, float rz)
  {
    float cx = (v[0].x + v[1].x + v[1].x) / 3;
    float cy = (v[0].y + v[1].y + v[1].y) / 3;
    float cz = (v[0].z + v[1].z + v[1].z) / 3;
    for (int i = 0; i < 3; i++) {
      v[i].x -= cx; v[i].y -= cy; v[i].z -= cz;
      
      float r, theta;

      r = mag(v[i].z, v[i].y);
      theta = atan2(v[i].y, v[i].z);
      v[i].z = r * cos(theta + rx);
      v[i].y = r * sin(theta + rx);

      r = mag(v[i].z, v[i].x);
      theta = atan2(v[i].x, v[i].z);
      v[i].z = r * cos(theta + ry);
      v[i].x = r * sin(theta + ry);

      r = mag(v[i].x, v[i].y);
      theta = atan2(v[i].y, v[i].x);
      v[i].x = r * cos(theta + rz);
      v[i].y = r * sin(theta + rz);
      
      v[i].x += cx; v[i].y += cy; v[i].z += cz;
    }
  }
}

Camera cam;
ArrayList<Tri> stars;

void setup()
{
  size(640, 640);
  background(0);
  cam = new Camera();
  cam.d = 1;

  stars = new ArrayList<Tri>();
  for (int i = 0; i < 500; i++) {
    Tri p = new Tri();
    float r = 10;
    float x = random(-500, 500);
    float y = random(-500, 500);
    float z = random(1, 10000);
    for (int j = 0; j < 3; j++) {
      p.v[j].x = r * cos(j * 2*PI/3) + x;
      p.v[j].y = r * sin(j * 2*PI/3) + y;
      p.v[j].z = z;
    }
    p.rot(random(0, 2*PI), random(0, 2*PI), random(0, 2*PI));
    stars.add(p);
  }
}

void draw()
{
  background(0);
  cam.d = 1000.0 * mouseX / width;
  int n = stars.size();
  for (int i = 0; i < n; i++) {
    Tri p = stars.get(i);
    p.v[0].z -= 1;
    p.v[1].z -= 1;
    p.v[2].z -= 1;
    if (p.v[0].z < 0) {
      p.v[0].z += 100;
      p.v[1].z += 100;
      p.v[2].z += 100;
    }
    p.rot(PI/100, PI/100, PI/100);
    if (0 < p.v[0].z && 0 < p.v[1].z && 0 < p.v[2].z) {
      p.draw(cam);
    }
  }
  fill(255);
  text("cam.d: " + cam.d, 10, 30);
}
