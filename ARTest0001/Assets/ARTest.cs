using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.XR.ARFoundation;
using UnityChan;

[RequireComponent(typeof(AudioSource))]
public class ARTest : MonoBehaviour
{
    [SerializeField]
    GameObject prefab;
    [SerializeField]
    Light light;
    [SerializeField]
    Transform defaultOrigin;
    bool virgin = true;
    GameObject instance;
    Animator animator;

    void goUnityChan(Transform parent)
    {
        instance = Instantiate(prefab, parent);
        var musicStarter = instance.GetComponent<MusicStarter>();
        musicStarter.refAudioSource = GetComponent<AudioSource>();
    }

    void planeChanged(ARPlanesChangedEventArgs args)
    {
        if (virgin && 0 < args.added.Count)
        {
            goUnityChan(args.added[0].transform);
            virgin = false;
        }
    }

    void cameraFrameReceived(ARCameraFrameEventArgs args)
    {
        if (light != null)
        {
            var le = args.lightEstimation;
            if (le.averageBrightness.HasValue)
            {
                light.intensity = le.averageBrightness.Value;
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
    }

    // Start is called before the first frame update
    void Start()
    {
        var planeManager = FindObjectOfType<ARPlaneManager>();
        planeManager.planesChanged += planeChanged;

        var cameraManager = FindObjectOfType<ARCameraManager>();
        cameraManager.frameReceived += cameraFrameReceived;

#if UNITY_EDITOR
        goUnityChan(defaultOrigin);
#endif
    }

    // Update is called once per frame
    void Update()
    {
        if (instance != null)
        {
            if (animator == null)
            {
                animator = instance.GetComponent<Animator>();
            }
            var stateInfo = animator.GetCurrentAnimatorStateInfo(0);
            if (1.0f <= stateInfo.normalizedTime)
            {
                animator.Play(null, 0, 0.0f);
            }
        }
    }
}
