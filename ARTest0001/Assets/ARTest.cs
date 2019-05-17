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
    GameObject instance;
    Animator animator;


    void goUnityChan(Transform parent)
    {
        instance = Instantiate(prefab, parent);
        var musicStarter = instance.GetComponent<MusicStarter>();
        musicStarter.refAudioSource = GetComponent<AudioSource>();
        animator = instance.GetComponent<Animator>();
    }

    void planeChanged(ARPlanesChangedEventArgs args)
    {
        if (virgin && 0 < args.added.Count)
        {
            goUnityChan(args.added[0].transform);
            virgin = false;
        }
    }

    // Start is called before the first frame update
    void Start()
    {
        var planeManager = GetComponent<ARPlaneManager>();
        planeManager.planesChanged += planeChanged;
#if UNITY_EDITOR
        goUnityChan(defaultOrigin);
#endif
    }

    // Update is called once per frame
    void Update()
    {
        if (animator != null)
        {
            var stateInfo = animator.GetCurrentAnimatorStateInfo(0);
            if (1.0f <= stateInfo.normalizedTime)
            {
                animator.Play(null, 0, 0.0f);
            }
        }
    }
}
