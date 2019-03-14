#if UNITY_ANDROID && !UNITY_STANDALONE && !UNITY_EDITOR
#define IS_OCULUS
#endif

using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Profiling;

public class GenCubes : MonoBehaviour
{
    public Transform prefab;
    public Transform prefab2;
    public Text text;
    public Transform controllerIcon;
    public Transform goalIcon;
    //List<Transform> instances = new List<Transform>(5000);  // HERE: ガバッと取っておく。ちょっと性能に効いてる？
    List<Transform> instances = new List<Transform>();

    List<Transform> instanceCashe = new List<Transform>();
    Transform getInstanceFromCashe()
    {
        Transform o = null;
        var r = 3.0f;
        var x = Random.Range(-r, r);
        var y = Random.Range(-r, r);
        var z = 0.0f;

        if (0 < instanceCashe.Count)
        {
            o = instanceCashe[0];
            instanceCashe.RemoveAt(0);
            o.position = new Vector3(x, y, z);
            o.gameObject.SetActive(true);
        }
        else
        {
            o = GameObject.Instantiate(prefab, new Vector3(x, y, z), Quaternion.identity, transform);
            // o = GameObject.Instantiate(prefab2, new Vector3(x, y, z), Quaternion.identity, transform);
        }

        return o;
    }
    void returnInstanceToCashe(Transform o)
    {
        //Destroy(o.gameObject);
        o.gameObject.SetActive(false);
        instanceCashe.Add(o);
    }

    void addCube()
    {
        var o = getInstanceFromCashe();
        instances.Add(o);
    }

    void delCube()
    {
        if (0 < instances.Count)
        {
            // var o = instances[0];
            // instances.RemoveAt(0);
            var i = instances.Count - 1;
            var o = instances[i];
            instances.RemoveAt(i);
            returnInstanceToCashe(o);
        }
    }

    // Start is called before the first frame update
    void Start()
    {
        Debug.Log("********" + transform.hierarchyCapacity);
        //transform.hierarchyCapacity = 1000;
    }

#if !IS_OCULUS
    Vector3? prevMousePosition = null;
#endif

    // Update is called once per frame
    void Update()
    {
#if IS_OCULUS
        var controller = OVRInput.Controller.RTrackedRemote;
        //var c = OVRInput.Get(OVRInput.Button.PrimaryIndexTrigger);
        //Debug.Log("XXXXXX " + c);
        var p = OVRInput.GetLocalControllerPosition(controller);
        var r = OVRInput.GetLocalControllerRotation(controller);
        //controllerIcon.SetPositionAndRotation(p, r);
        controllerIcon.localPosition = p;  // what does this mean for 3DoF devices e.g. Oculus Go?
        controllerIcon.localRotation = r;
#else
        if (Input.GetMouseButton(0))
        {
            var p = Input.mousePosition;
            if (prevMousePosition == null)
            {
                prevMousePosition = p;
            }
            var d = p - prevMousePosition;
            controllerIcon.Rotate(-d.Value.y, d.Value.x, 0.0f);
            prevMousePosition = p;
        }
        else
        {
            prevMousePosition = null;
        }
#endif

        RaycastHit hit;
        Vector3 dir = controllerIcon.TransformDirection(Vector3.forward);
        int layerMask = 1 << 31;

        // 以下の違いで測定できるような性能差は出ていない
        var maxDistance = Mathf.Infinity;
        //var maxDistance = 10.0f;

        if (Physics.Raycast(controllerIcon.position, dir, out hit, maxDistance, layerMask))
        {
            goalIcon.position = hit.point;
        }

        var dt = Time.deltaTime;
        if (dt < 1.0f / 30)  // まだ余裕
        {
            var n = 1;
            if (dt < 1.0f / 40)  // 超余裕
            {
                n = 10;
            }
            for (var i = 0; i < n; i++)
            {
                addCube();
            }
        }
        else if (1.0f / 20 < dt)  // ちょっときつい
        {
            var n = 1;
            if (1.0f / 15 < dt)  // もう無理
            {
                n = 10;
            }
            for (var i = 0; i < n; i++)
            {
                delCube();
            }
        }

        var goal = goalIcon.position;
        foreach (var o in instances)
        {
            o.position = Vector3.Lerp(o.position, goal, 0.1f);
            o.LookAt(goal);
            goal = o.position;
        }

        var ql = QualitySettings.GetQualityLevel();
        text.text = $"Quality: {QualitySettings.names[ql]}\n"
            + $"{1000 * dt:F1} ms; "
            + $"{instances.Count} instances";
    }
}
