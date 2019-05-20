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
    Transform defaultOrigin;
    bool virgin = true;
    GameObject instance;
    Animator animator;

    void goUnityChan(Vector3 position)
    {
        instance = Instantiate(prefab, position, Quaternion.Euler(0, 180, 0));
        var musicStarter = instance.GetComponent<MusicStarter>();
        musicStarter.refAudioSource = GetComponent<AudioSource>();
    }

    void planeChanged(ARPlanesChangedEventArgs args)
    {
        if (virgin && 0 < args.added.Count)
        {
            goUnityChan(args.added[0].transform.position);
            virgin = false;
        }
    }

    // Start is called before the first frame update
    void Start()
    {
        var planeManager = FindObjectOfType<ARPlaneManager>();
        planeManager.planesChanged += planeChanged;

#if UNITY_EDITOR
        goUnityChan(defaultOrigin.transform.position);
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
