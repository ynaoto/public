Camera cam;
Poly surfaces[];

float sz = 200;
float cz = 200;

class Square extends Poly
{
  Square()
  {
    super(4);
    v[0].x = sz/2;
    v[0].y = sz/2;
    v[1].x = -sz/2;
    v[1].y = sz/2;
    v[2].x = -sz/2;
    v[2].y = -sz/2;
    v[3].x = sz/2;
    v[3].y = -sz/2;
    v[0].z = v[1].z = v[2].z = v[3].z = 0;
  }
}

void setup()
{
  size(640, 640);
  background(0);
  cam = new Camera();
  cam.d = 1;

  surfaces = new Square[6];
  Poly p;

  surfaces[0] = p = new Square();
  p.rot(0, -0*PI/2, 0);
  p.move(0, 0, -sz/2);

  surfaces[1] = p = new Square();
  p.rot(0, -1*PI/2, 0);
  p.move(sz/2, 0, 0);

  surfaces[2] = p = new Square();
  p.rot(0, -2*PI/2, 0);
  p.move(0, 0, sz/2);
  
  surfaces[3] = p = new Square();
  p.rot(0, -3*PI/2, 0);
  p.move(-sz/2, 0, 0);
  
  surfaces[4] = p = new Square();
  p.rot(-1*PI/2, 0, 0);
  p.move(0, sz/2, 0);
  
  surfaces[5] = p = new Square();
  p.rot(1*PI/2, 0, 0);
  p.move(0, -sz/2, 0);
  
  for (int i = 0; i < surfaces.length; i++) {
    p = surfaces[i];
    p.move(0, 0, cz);
  }
}

void draw()
{
  background(0);
  cam.d = 1000.0 * mouseX / width;
  for (int i = 0; i < surfaces.length; i++) {
    Poly p = surfaces[i];
    p.move(0, 0, -cz);
    p.rot(PI/200, PI/100, 0);
    p.move(0, 0, cz);
    p.draw(cam);
  }
  fill(255);
  text("cam.d: " + cam.d, 10, 30);
}
