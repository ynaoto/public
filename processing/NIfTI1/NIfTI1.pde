//String file = "avg152T1_LR_nifti.nii";
//String file = "zstat1.nii";
//String file = "MRI-n4.nii";
//String dir = "mni_icbm152_nlin_sym_09a_nifti/mni_icbm152_nlin_sym_09a/";
//String file = dir + "mni_icbm152_csf_tal_nlin_sym_09a.nii";
//String file = dir + "mni_icbm152_t1_tal_nlin_sym_09a_eye_mask.nii";
String dir = "mni_icbm152_nlin_asym_09a_nifti/mni_icbm152_nlin_asym_09a/";
String file = dir + "mni_icbm152_csf_tal_nlin_asym_09a.nii";

boolean isBigEndian = true;

void skip(InputStream input, int size) throws IOException {
  try {
    input.skip(size);
  }
  catch (IOException e) {
    throw e;
  }
}

int readUInt(InputStream input, int size) throws IOException {
  int n = 0;
  try {
    for (int i = 0; i < size; i++) {
      if (isBigEndian) {
        n = (n << 8)|(input.read() & 0x0ff);
      } else {
        n |= (input.read() & 0x0ff) << 8*i;
      }
    }
  }
  catch (IOException e) {
    throw e;
  }
  return n;
}

int readInt(InputStream input, int size) throws IOException {
  int n = 0;
  try {
    n = readUInt(input, size);
  }
  catch (IOException e) {
    throw e;
  }
  if ((n & (1 << 8*size - 1)) != 0) { // 符号拡張
    for (int i = size; i < 4; i++) {
      n |= 0x0ff << 8*i;
    }
  }
  return n;
}

float readFloat(InputStream input) throws IOException {
  int bits = 0;
  try {
    bits = readInt(input, 4);
  }
  catch (IOException e) {
    throw e;
  }
  return Float.intBitsToFloat(bits);
}

String readFixedString(InputStream input, int size) throws IOException {
  String s = "";
  try {
    byte[] buf = new byte[1024];
    int len = -1;
    for (int i = 0; i < size; i++) {
      buf[i] = (byte)input.read();
      if (len == -1 && buf[i] == 0) {
        len = i;
      }
    }
    if (len == -1) {
      len = size;
    }
    s = new String(buf, 0, len);
  }
  catch (IOException e) {
    throw e;
  }
  return s;
}

class Header {
  int sizeof_hdr;    /*!< MUST be 348           */
  int dim_info;      /*!< MRI slice ordering.   */
  int[] dim = new int[8];        /*!< Data array dimensions.*/
  float intent_p1;    /*!< 1st intent parameter. */
  float intent_p2;    /*!< 2nd intent parameter. */
  float intent_p3;    /*!< 3rd intent parameter. */
  int intent_code;  /*!< NIFTI_INTENT_* code.  */
  int datatype;      /*!< Defines data type!    */
  static final int DT_UINT8      =    2;
  static final int DT_INT16      =    4;
  static final int DT_INT32      =    8;
  static final int DT_FLOAT32    =   16;
  static final int DT_COMPLEX64  =   32;
  static final int DT_FLOAT64    =   64;
  static final int DT_RGB24      =  128;
  static final int DT_INT8       =  256;     /* signed char (8 bits)         */
  static final int DT_UINT16     =  512;     /* unsigned short (16 bits)     */
  static final int DT_UINT32     =  768;     /* unsigned int (32 bits)       */
  static final int DT_INT64      = 1024;     /* long long (64 bits)          */
  static final int DT_UINT64     = 1280;     /* unsigned long long (64 bits) */
  static final int DT_FLOAT128   = 1536;     /* long double (128 bits)       */
  static final int DT_COMPLEX128 = 1792;     /* double pair (128 bits)       */
  static final int DT_COMPLEX256 = 2048;     /* long double pair (256 bits)  */
  static final int DT_RGBA32     = 2304;     /* 4 byte RGBA (32 bits/voxel)  */
  /*static*/  String datatypeString(int datatype) {
    HashMap<Integer, String> map = new HashMap<Integer, String>();
    map.put(DT_UINT8, "DT_UINT8");
    map.put(DT_INT16, "DT_INT16");
    map.put(DT_INT32, "DT_INT32");
    map.put(DT_FLOAT32, "DT_FLOAT32");
    map.put(DT_COMPLEX64, "DT_COMPLEX64");
    map.put(DT_FLOAT64, "DT_FLOAT64");
    map.put(DT_RGB24, "DT_RGB24");
    map.put(DT_INT8, "DT_INT8");
    map.put(DT_UINT16, "DT_UINT16");
    map.put(DT_UINT32, "DT_UINT32");
    map.put(DT_INT64, "DT_INT64");
    map.put(DT_UINT64, "DT_UINT64");
    map.put(DT_FLOAT128, "DT_FLOAT128");
    map.put(DT_COMPLEX128, "DT_COMPLEX128");
    map.put(DT_COMPLEX256, "DT_COMPLEX256");
    map.put(DT_RGBA32, "DT_RGBA32");
    return map.get(datatype);
  }
  int bitpix;        /*!< Number bits/voxel.    */
  int slice_start;   /*!< First slice index.    */
  float[] pixdim = new float[8];     /*!< Grid spacings.        */
  float vox_offset;    /*!< Offset into .nii file */
  float scl_slope;    /*!< Data scaling: slope.  */
  float scl_inter;    /*!< Data scaling: offset. */
  int slice_end;     /*!< Last slice index.     */
  int slice_code;   /*!< Slice timing order.   */
  int xyzt_units;   /*!< Units of pixdim[1..4] */
  float cal_max;       /*!< Max display intensity */
  float cal_min;       /*!< Min display intensity */
  float slice_duration;/*!< Time for 1 slice.     */
  float toffset;       /*!< Time axis shift.      */

  String descrip;   /*!< any text you like.    */
  String aux_file;  /*!< auxiliary filename.   */

  int qform_code;   /*!< NIFTI_XFORM_* code.   */
  int sform_code;   /*!< NIFTI_XFORM_* code.   */

  float quatern_b;    /*!< Quaternion b param.   */
  float quatern_c;    /*!< Quaternion c param.   */
  float quatern_d;    /*!< Quaternion d param.   */
  float qoffset_x;    /*!< Quaternion x shift.   */
  float qoffset_y;    /*!< Quaternion y shift.   */
  float qoffset_z;    /*!< Quaternion z shift.   */

  float[] srow_x = new float[4];    /*!< 1st row affine transform.   */
  float[] srow_y = new float[4];    /*!< 2nd row affine transform.   */
  float[] srow_z = new float[4];    /*!< 3rd row affine transform.   */

  String intent_name;/*!< 'name' or meaning of data.  */

  String magic;      /*!< MUST be "ni1\0" or "n+1\0". */

  void read(InputStream input) throws IOException {
    try {
      isBigEndian = true;
      sizeof_hdr = readInt(input, 4);
      if (sizeof_hdr != 348) {
        isBigEndian = false;
        int n = 0;
        for (int i = 0; i < 4; i++) {
          n |= (sizeof_hdr & 0x0ff) << 8*(3 - i);
          sizeof_hdr >>= 8;
        }
        sizeof_hdr = n;
      }
      println((isBigEndian ? "BIG" : "LITTLE") + " ENDIAN");
      println("Header: sizeof_hdr = " + sizeof_hdr);

      skip(input, 10 + 18 + 4 + 2 + 1);

      dim_info = readInt(input, 1);
      println("Header: dim_info = " + dim_info);

      for (int i = 0; i < 8; i++) {
        dim[i] = readInt(input, 2);
        println("Header: dim[" + i + "] = " + dim[i]);
      }

      intent_p1 = readFloat(input);
      intent_p2 = readFloat(input);
      intent_p3 = readFloat(input);
      println("Header: intent_p1 = " + intent_p1);
      println("Header: intent_p2 = " + intent_p2);
      println("Header: intent_p3 = " + intent_p3);

      intent_code = readInt(input, 2);
      println("Header: intent_code = " + intent_code);

      datatype = readInt(input, 2);
      println("Header: datatype = " + datatypeString(datatype));

      bitpix = (short)readInt(input, 2);
      println("Header: bitpix = " + (int)bitpix);

      slice_start = readInt(input, 2);
      println("Header: slice_start = " + slice_start);

      for (int i = 0; i < 8; i++) {
        pixdim[i] = readFloat(input);
        println("Header: pixdim[" + i + "] = " + pixdim[i]);
      }

      vox_offset = readFloat(input);
      println("Header: vox_offset = " + vox_offset);

      scl_slope = readFloat(input);
      println("Header: scl_slope = " + scl_slope);

      scl_inter = readFloat(input);
      println("Header: scl_inter = " + scl_inter);

      slice_end = readInt(input, 2);
      println("Header: slice_end = " + slice_end);

      slice_code = readInt(input, 1);
      println("Header: slice_code = " + slice_code);

      xyzt_units = readInt(input, 1);
      println("Header: xyzt_units = " + xyzt_units);

      cal_max = readFloat(input);
      cal_min = readFloat(input);
      println("Header: cal_max = " + cal_max);
      println("Header: cal_min = " + cal_min);

      slice_duration = readFloat(input);
      println("Header: slice_duration = " + slice_duration);

      toffset = readFloat(input);
      println("Header: toffset = " + toffset);

      skip(input, 4 + 4);

      descrip = readFixedString(input, 80);
      println("Header: descrip = [" + descrip + "]");

      aux_file = readFixedString(input, 24);
      println("Header: aux_file = [" + aux_file + "]");

      qform_code = readInt(input, 2);
      println("Header: qform_code = " + qform_code);

      sform_code = readInt(input, 2);
      println("Header: sform_code = " + sform_code);

      quatern_b = readFloat(input);
      quatern_c = readFloat(input);
      quatern_d = readFloat(input);
      qoffset_x = readFloat(input);
      qoffset_y = readFloat(input);
      qoffset_z = readFloat(input);
      println("Header: quatern_b = " + quatern_b);
      println("Header: quatern_c = " + quatern_c);
      println("Header: quatern_d = " + quatern_d);
      println("Header: qoffset_x = " + qoffset_x);
      println("Header: qoffset_y = " + qoffset_y);
      println("Header: qoffset_z = " + qoffset_z);

      for (int i = 0; i < 4; i++) {
        srow_x[i] = readFloat(input);
        println("Header: srow_x[" + i + "] = " + srow_x[i]);
      }
      for (int i = 0; i < 4; i++) {
        srow_y[i] = readFloat(input);
        println("Header: srow_y[" + i + "] = " + srow_y[i]);
      }
      for (int i = 0; i < 4; i++) {
        srow_z[i] = readFloat(input);
        println("Header: srow_z[" + i + "] = " + srow_z[i]);
      }

      intent_name = readFixedString(input, 16);
      println("Header: intent_name = [" + intent_name + "]");

      magic = readFixedString(input, 4);
      println("Header: magic = [" + magic + "]");
    }
    catch (IOException e) {
      throw e;
    }
  }
}

class Image {
  Header header;
  class Voxel {
    float x, y, z;
    float value;
  }
  Voxel[][][] voxels;
  Image(Header header) {
    this.header = header;
  }
  float readValue(InputStream input) throws IOException {
    float a;
    try {
      switch (header.datatype) {
      case Header.DT_INT8:    
        a = (float)readInt(input, 1); 
        break;
      case Header.DT_INT16:   
        a = (float)readInt(input, 2); 
        break;
      case Header.DT_INT32:   
        a = (float)readInt(input, 4); 
        break;
      case Header.DT_UINT8:   
        a = (float)readUInt(input, 1); 
        break;
      case Header.DT_UINT16:  
        a = (float)readUInt(input, 2); 
        break;
      case Header.DT_UINT32:  
        a = (float)readUInt(input, 4); 
        break;
      case Header.DT_FLOAT32: 
        a = readFloat(input); 
        break;
      case Header.DT_COMPLEX64:
      case Header.DT_FLOAT64:
      case Header.DT_RGB24:
      case Header.DT_INT64:
      case Header.DT_UINT64:
      case Header.DT_FLOAT128:
      case Header.DT_COMPLEX128:
      case Header.DT_COMPLEX256:
      case Header.DT_RGBA32:
      default:
        throw new IOException("invalid datatype: " + header.datatype);
      }
    }
    catch (IOException e) {
      throw e;
    }
    return a*header.scl_slope + header.scl_inter;
  }
  void read(InputStream input) throws IOException {
    voxels = new Voxel[header.dim[1]][header.dim[2]][header.dim[3]];
    try {
      if (header.scl_slope == 0.0) {
        header.scl_slope = 1.0;
        println("Notice: scl_slope is missing. Set to " + header.scl_slope);
      }
      float min = Float.MAX_VALUE;
      float max = Float.MIN_VALUE;
      for (int k = 0; k < header.dim[3]; k++) {
        for (int j = 0; j < header.dim[2]; j++) {
          for (int i = 0; i < header.dim[1]; i++) {
            Voxel v = new Voxel();
            if (0 < header.sform_code) {
              v.x = header.srow_x[0] * i + header.srow_x[1] * j + header.srow_x[2] * k + header.srow_x[3];
              v.y = header.srow_y[0] * i + header.srow_y[1] * j + header.srow_y[2] * k + header.srow_y[3];
              v.z = header.srow_z[0] * i + header.srow_z[1] * j + header.srow_z[2] * k + header.srow_z[3];
            } else if (0 < header.qform_code) {
              v.x = header.pixdim[1] * i + header.qoffset_x;
              v.y = header.pixdim[2] * j + header.qoffset_y;
              v.z = header.pixdim[3] * k + header.qoffset_z;
            } else {
              v.x = header.pixdim[1] * i;
              v.y = header.pixdim[2] * j;
              v.z = header.pixdim[3] * k;
            }
            v.value = readValue(input);
            if (v.value < min) {
              min = v.value;
            }
            if (max < v.value) {
              max = v.value;
            }
            voxels[i][j][k] = v;
          }
        }
      }
      if (header.cal_max == 0.0) {
        header.cal_min = min;
        header.cal_max = max;
        println("Notice: cal_{min,max} is missing. Set to " + header.cal_min + " - " + header.cal_max);
      }
    }
    catch (IOException e) {
      throw e;
    }
  }
}

Header header;
Image image;

float th;

void setup() {
  size(400, 400, P3D);
  InputStream input = createInput(file);
  try {
    header = new Header();
    header.read(input);
    skip(input, (int)header.vox_offset - header.sizeof_hdr);
    image = new Image(header);
    image.read(input);
    println("file reading completed");
  }
  catch (IOException e) {
    e.printStackTrace();
  }
  finally {
    try {
      input.close();
    } 
    catch (IOException e) {
      e.printStackTrace();
    }
  }
  colorMode(HSB);
  th = header.cal_min + 0.5*(header.cal_max - header.cal_min);
}

float rx = 0;
float ry = 0;
float tx = 0;
float ty = 0;
float scale = 1;

int dx = 1;
int dy = 1;
int dz = 10;

void draw() {
  background(255);
  fill(0);
  text("th: " + th, 8, 16);
  text("dz: " + dz, 8, 32);

  pushMatrix();
  translate(width/2, height/2);

  beginCamera();
  camera(0, 0, 300, 0, 0, 0, 0, 1, 0);
  translate(tx, ty);
  scale(scale);
  rotateX(rx);
  rotateY(ry);
  ry += 0.01;
  endCamera();

  for (int i = 0; i < header.dim[1]; i += dx) {
    for (int j = 0; j < header.dim[2]; j += dy) {
      for (int k = 0; k < header.dim[3]; k += dz) {
        Image.Voxel v = image.voxels[i][j][k];
        if (v.value < th) continue;
//        if (50*50 < v.x*v.x + v.z*v.z + v.y*v.y) continue;
//        float a = 2, b = 1, c = 0;
//        if (a*v.x + b*v.y + c < v.z) continue;
        stroke(map(v.value, header.cal_min, header.cal_max, 0, 255), 255, 255);
        point(v.x, -v.z, v.y);
      }
    }
  }

  popMatrix();
}

void mouseDragged() {
  if (keyPressed && key == CODED && keyCode == CONTROL) {
    scale -= 0.1*(mouseY - pmouseY);
  } else if (keyPressed && key == CODED && keyCode == SHIFT) {
    tx += (mouseX - pmouseX);
    ty += (mouseY - pmouseY);
  } else {
    rx -= 0.01*(mouseY - pmouseY);
    ry += 0.01*(mouseX - pmouseX);
  }
}

void keyPressed() {
  float dth = (header.cal_max - header.cal_min)/100;
  if (key == CODED && keyCode == RIGHT) {
    th += dth;
  } else if (key == CODED && keyCode == LEFT) {
    th -= dth;
  } else if (key == CODED && keyCode == UP) {
    dz += 1;
  } else if (key == CODED && keyCode == DOWN) {
    if (1 < dz) dz -= 1;
  }
}

