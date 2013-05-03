Camera cam;
Light lit;
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
  cam.d = 500;

  lit = new Light();
  lit.x = 0; lit.y = 0; lit.z = 10;

  surfaces = new Square[6];
  Poly p;

  color colors[]  = {
    /**/
    color(0, 0, 200),
    color(0, 200, 0),
    color(0, 200, 200),
    color(200, 0, 0),
    color(200, 0, 200),
    color(200, 200, 0),
    /**/
    /*
    color(200),
    color(200),
    color(200),
    color(200),
    color(200),
    color(200),
    /**/
  };
  
  surfaces[0] = p = new Square();
  p.c = colors[0];
  p.rot(0, -0*PI/2, 0);
  p.move(0, 0, -sz/2);

  surfaces[1] = p = new Square();
  p.c = colors[1];
  p.rot(0, -1*PI/2, 0);
  p.move(sz/2, 0, 0);

  surfaces[2] = p = new Square();
  p.c = colors[2];
  p.rot(0, -2*PI/2, 0);
  p.move(0, 0, sz/2);
  
  surfaces[3] = p = new Square();
  p.c = colors[3];
  p.rot(0, -3*PI/2, 0);
  p.move(-sz/2, 0, 0);
  
  surfaces[4] = p = new Square();
  p.c = colors[4];
  p.rot(-1*PI/2, 0, 0);
  p.move(0, sz/2, 0);
  
  surfaces[5] = p = new Square();
  p.c = colors[5];
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
  
  lit.x = 100.0 * ((width/2) - mouseX) / width;
  lit.y = 100.0 * ((height/2) - mouseY) / height;
  
  for (int i = 0; i < surfaces.length; i++) {
    Poly p = surfaces[i];
    p.move(0, 0, -cz);
    p.rot(PI/200, PI/100, 0);
    p.move(0, 0, cz);
    p.draw(cam, lit);
  }
  fill(255);
  text("cam.d: " + cam.d, 10, 30);
  text("lit: " + lit.x + ", " + lit.y + ", " + lit.z, 10, 50);
}
