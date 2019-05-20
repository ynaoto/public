using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.XR.ARFoundation;
using UnityEngine.XR.ARSubsystems;
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
    ARRaycastManager raycastManager;

    void goUnityChan(Vector3 position)
    {
        if (instance == null)
        {
            instance = Instantiate(prefab);
            animator = instance.GetComponent<Animator>();
            var musicStarter = instance.GetComponent<MusicStarter>();
            musicStarter.refAudioSource = GetComponent<AudioSource>();
        }

        instance.transform.position = position;
        var camera = FindObjectOfType<Camera>();
        var cp = camera.transform.position;
        var target = new Vector3(cp.x, position.y, cp.z);
        instance.transform.LookAt(target);
    }

    // Start is called before the first frame update
    void Start()
    {
        raycastManager = FindObjectOfType<ARRaycastManager>();

#if UNITY_EDITOR
        goUnityChan(defaultOrigin.transform.position);
#endif
    }

    static List<ARRaycastHit> s_Hits = new List<ARRaycastHit>();

    // Update is called once per frame
    void Update()
    {
        if (0 < Input.touchCount)
        {
            var touch = Input.GetTouch(0);
            if (raycastManager.Raycast(touch.position, s_Hits, TrackableType.PlaneWithinPolygon))
            {
                goUnityChan(s_Hits[0].pose.position);
            }
        }

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
