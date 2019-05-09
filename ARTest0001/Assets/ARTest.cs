using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.XR.ARFoundation;

public class ARTest : MonoBehaviour
{
    void faceAdded(ARFaceAddedEventArgs args)
    {
        Debug.Log("**** faceAdded");
    }

    void planeAdded(ARPlaneAddedEventArgs args)
    {
        Debug.Log("**** planeAdded");
    }

    // Start is called before the first frame update
    void Start()
    {
        var xxx = GetComponent<ARFaceManager>();
        xxx.faceAdded += faceAdded;

        var yyy = GetComponent<ARPlaneManager>();
        yyy.planeAdded += planeAdded;
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
