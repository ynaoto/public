Camera cam;
Light lit;
Cube cube;
float cz = 200;

void setup()
{
  size(640, 640);
  background(0);

  cam = new Camera();
  cam.d = 500;

  lit = new Light();
  lit.x = 0; lit.y = 0; lit.z = 10;

  cube = new Cube(200, color(255, 0, 0));
  cube.move(0, 0, cz);
}

void draw()
{
  background(0);
  
  lit.x = 100.0 * ((width/2) - mouseX) / width;
  lit.y = 100.0 * ((height/2) - mouseY) / height;

  cube.move(0, 0, -cz);
  cube.rot(PI/200, PI/100, 0);
  cube.move(0, 0, cz);
  cube.draw(cam, lit);  

  fill(255);
  text("cam.d: " + cam.d, 10, 30);
  text("lit: " + lit.x + ", " + lit.y + ", " + lit.z, 10, 50);
}
