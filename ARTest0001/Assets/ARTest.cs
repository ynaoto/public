using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.XR.ARFoundation;

public class ARTest : MonoBehaviour
{
    [SerializeField]
    GameObject prefab;
    bool virgin = true;

    void planeAdded(ARPlaneAddedEventArgs args)
    {
        if (virgin)
        {
            Instantiate(prefab, args.plane.transform);
            virgin = false;
        }
    }

    // Start is called before the first frame update
    void Start()
    {
        var planeManager = GetComponent<ARPlaneManager>();
        planeManager.planeAdded += planeAdded;
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
