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
    q.x = p.x / (d + p.z);
    q.y = p.y / (d + p.z);
    return q;
  }
}

Camera cam;
ArrayList<Point3D> stars;

void setup()
{
  size(640, 640);
  background(0);
  cam = new Camera();
  cam.d = 1;

  stars = new ArrayList<Point3D>();
  for (int i = 0; i < 500; i++) {
    Point3D p = new Point3D();
    p.x = random(-500, 500);
    p.y = random(-500, 500);
    p.z = random(1, 100);
    stars.add(p);
  }
}

void draw()
{
  background(0);
  int n = stars.size();
  for (int i = 0; i < n; i++) {
    Point3D p = stars.get(i);
    p.z -= 0.1;
    if (0 < p.z) {
      Point2D q;
      float a = 20 / (cam.d + p.z);
      
      p.x -= 10;
      q = cam.proj(p);
      fill(255, 0, 0, 150);
      ellipse(q.x + width/2, q.y + height/2, a, a);
      p.x += 10;

      p.x += 10;
      q = cam.proj(p);
      fill(0, 0, 255, 150);
      ellipse(q.x + width/2, q.y + height/2, a, a);
      p.x -= 10;
    } else {
      p.z = 100;
    }
  }
}
