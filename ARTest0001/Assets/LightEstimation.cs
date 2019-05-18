using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.XR.ARFoundation;

[RequireComponent(typeof(Light))]
public class LightEstimation : MonoBehaviour
{
    [SerializeField]
    [Range(0, 1)]
    float minumumIntensity = 0.15f;
    Light light;

    void Awake()
    {
        light = GetComponent<Light>();
    }

    void cameraFrameReceived(ARCameraFrameEventArgs args)
    {
        var le = args.lightEstimation;
        if (le.averageBrightness.HasValue)
        {
            light.intensity = Mathf.Lerp(minumumIntensity, 1.0f, le.averageBrightness.Value);
        }
        if (le.averageColorTemperature.HasValue)
        {
            light.colorTemperature = le.averageColorTemperature.Value;
        }
        if (le.colorCorrection.HasValue)
        {
            light.color = le.colorCorrection.Value;
        }
    }

    // Start is called before the first frame update
    void Start()
    {
        var cameraManager = FindObjectOfType<ARCameraManager>();
        cameraManager.frameReceived += cameraFrameReceived;
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
