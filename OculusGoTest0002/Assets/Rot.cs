using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Rot : MonoBehaviour
{
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        var x = transform.position.x;
        var y = transform.position.y;
        var z = transform.position.z;
        transform.Rotate(1.0f*x, 1.0f*y, 1.0f*z);
    }
}
