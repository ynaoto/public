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

class Poly
{
  float x, y, z;
  float r, theta, phi;
  Point3D v[];
  private Point2D v2d[];
  
  Poly(int n)
  {
    v = new Point3D[n];
    v2d = new Point2D[n];
    for (int i = 0; i < v.length; i++) {
      v[i] = new Point3D();
    }
  }
  
  Point3D cross(Point3D v1, Point3D v2)
  {
    Point3D p = new Point3D();
    p.x = v1.y * v2.z - v1.z * v2.y;
    p.y = v1.z * v2.x - v1.x * v2.z;
    p.z = v1.x * v2.y - v1.y * v2.x;
    return p;
  }
  
  void draw(Camera cam, Point3D lit)
  {
    Point3D a = new Point3D();
    Point3D b = new Point3D();
    a.x = v[1].x - v[0].x;
    a.y = v[1].y - v[0].y;
    a.z = v[1].z - v[0].z;
    b.x = v[1].x - v[2].x;
    b.y = v[1].y - v[2].y;
    b.z = v[1].z - v[2].z;
    Point3D nrm = cross(a, b);
    float d = mag(nrm.x, nrm.y, nrm.z);
    nrm.x /= d;
    nrm.y /= d;
    nrm.z /= d;
    
    for (int i = 0; i < v.length; i++) {
      v2d[i] = cam.proj(v[i]);
      v2d[i].x += width / 2;
      v2d[i].y += height / 2;
    }
    float ax = v2d[1].x - v2d[0].x;
    float ay = v2d[1].y - v2d[0].y;
    float bx = v2d[2].x - v2d[0].x;
    float by = v2d[2].y - v2d[0].y;
    float ext = ax*by-ay*bx;
    if (0 < ext) {
      /*float*/ d = mag(lit.x, lit.y, lit.z);
      float p = (lit.x * nrm.x + lit.y * nrm.y + lit.z * nrm.z) / d;
      fill(120 * p + 130);
      noStroke();
      beginShape();
      for (int i = 0; i < v2d.length; i++) {
        vertex(v2d[i].x, v2d[i].y);
      }
      endShape(CLOSE);
    } else {
      /*
      fill(255, 0, 0);
      noStroke();
      beginShape();
      for (int i = 0; i < v2d.length; i++) {
        vertex(v2d[i].x, v2d[i].y);
      }
      endShape(CLOSE);
      */
    }
  }

  Point3D center()
  {
    Point3D c = new Point3D();
    c.x = c.y = c.z = 0;
    for (int i = 0; i < v.length; i++) {
      c.x += v[i].x;
      c.y += v[i].y;
      c.z += v[i].z;
    }
    c.x /= v.length;
    c.y /= v.length;
    c.z /= v.length;
    return c;
  }
  
  void rot(float rx, float ry, float rz)
  {
    for (int i = 0; i < v.length; i++) {
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
    }
  }
  
  void move(float dx, float dy, float dz)
  {
    for (int i = 0; i < v.length; i++) {
      v[i].x += dx;
      v[i].y += dy;
      v[i].z += dz;
    }
  }
}

