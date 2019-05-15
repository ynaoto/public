using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.XR.ARFoundation;
using UnityChan;

public class ARTest : MonoBehaviour
{
    [SerializeField]
    GameObject prefab;
    [SerializeField]
    Transform defaultOrigin;
    bool virgin = true;

    void goUnityChan(Transform parent)
    {
        var obj = Instantiate(prefab, parent);
        var musicStarter = obj.GetComponent<MusicStarter>();
        musicStarter.refAudioSource = GetComponent<AudioSource>();
    }

    void planeAdded(ARPlaneAddedEventArgs args)
    {
        if (virgin)
        {
            goUnityChan(args.plane.transform);
            virgin = false;
        }
    }

    // Start is called before the first frame update
    void Start()
    {
        var planeManager = GetComponent<ARPlaneManager>();
        planeManager.planeAdded += planeAdded;
        #if UNITY_EDITOR
        goUnityChan(defaultOrigin);
        #endif
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
