//#define NO_DESTROY

using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Profiling;

public class GenCubes : MonoBehaviour
{
    public Transform prefab;
    public Text text;
    public Transform controllerIcon;
    public Transform goalIcon;
    List<Transform> instances;
#if NO_DESTROY
    int numActivated;
#endif

    void initCubes()
    {
        instances = new List<Transform>(1000);  // HERE: ガバッと取っておく。ちょっと性能に効いてる？
    #if NO_DESTROY
        for (var i = 0; i < 1000; i++) {
            var r = 3.0f;
            var x = Random.Range(-r, r);
            var y = Random.Range(-r, r);
            var z = 0.0f;
            var o = GameObject.Instantiate(prefab, new Vector3(x, y, z), Quaternion.identity, transform);
            o.gameObject.SetActive(false);
            instances.Add(o);
        }
        numActivated = 0;
    #endif
    }

    void addCube()
    {
    #if NO_DESTROY
        var o = instances[numActivated];
        o.gameObject.SetActive(true);
        numActivated++;
    #else
        var r = 3.0f;
        var x = Random.Range(-r, r);
        var y = Random.Range(-r, r);
        var z = 0.0f;
        var o = GameObject.Instantiate(prefab, new Vector3(x, y, z), Quaternion.identity, transform);
        instances.Add(o);
    #endif
    }

    void delCube()
    {
    #if NO_DESTROY
        if (0 <= numActivated)
        {
            var o = instances[numActivated - 1];
            o.gameObject.SetActive(false);
        }
    #else
        if (0 <= instances.Count)
        {
            var o = instances[0];
            Destroy(o.gameObject);
            instances.RemoveAt(0);
        }
    #endif
    }

    // Start is called before the first frame update
    void Start()
    {
        initCubes();
    }

    #if UNITY_EDITOR
    Vector3? prevMousePosition = null;
    #endif

    // Update is called once per frame
    void Update()
    {
    #if UNITY_EDITOR
        if (Input.GetMouseButton(0)) {
            var p = Input.mousePosition;
            if (prevMousePosition == null) {
                prevMousePosition = p;
            }
            var d = p - prevMousePosition;
            controllerIcon.Rotate(-d.Value.y, d.Value.x, 0.0f);
            prevMousePosition = p;
        } else {
            prevMousePosition = null;
        }
    #else   
        var c = OVRInput.Get(OVRInput.Button.PrimaryIndexTrigger);
        //Debug.Log("XXXXXX " + c);
        var p = OVRInput.GetLocalControllerPosition(OVRInput.Controller.RTrackedRemote);
        var r = OVRInput.GetLocalControllerRotation(OVRInput.Controller.RTrackedRemote);
        //controllerIcon.SetPositionAndRotation(p, r);
        controllerIcon.localPosition = p;  // what does this mean for 3DoF devices e.g. Oculus Go?
        controllerIcon.localRotation = r;
    #endif   

        RaycastHit hit;
        Vector3 dir = controllerIcon.TransformDirection(Vector3.forward);
        int layerMask = 1 << 31;

        // 以下の違いで測定できるような性能差は出ていない
        var maxDistance = Mathf.Infinity;
        //var maxDistance = 10.0f;

        if (Physics.Raycast(controllerIcon.position, dir, out hit, maxDistance, layerMask)) {
            goalIcon.position = hit.point;
        }

        var dt = Time.deltaTime;
        if (dt < 1.0f/30)  // まだ余裕
        {
            addCube();
        }
        else if (1.0f/15 < dt)  // ちょっときつすぎる
        {
            delCube();
        }

        var goal = goalIcon.position;
    #if NO_DESTROY
        for (var i = 0; i < numActivated; i++) {
            var o = instances[i];
            o.position = Vector3.Lerp(o.position, goal, 0.1f);
            goal = o.position;
        }
    #else
        foreach (var o in instances) {
            o.position = Vector3.Lerp(o.position, goal, 0.1f);
            goal = o.position;
        }
    #endif

        var ql = QualitySettings.GetQualityLevel();
    #if NO_DESTROY
        text.text = $"Quality: {QualitySettings.names[ql]}\n"
            + $"{1000 * dt:F1} ms; "
            + $"{numActivated} activated";
    #else
        text.text = $"Quality: {QualitySettings.names[ql]}\n"
            + $"{1000 * dt:F1} ms; "
            + $"{instances.Count} instances";
    #endif
    }
}
