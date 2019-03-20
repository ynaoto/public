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
    //public Transform prefab;
    public Rigidbody prefab;
    public Transform prefab2;
    public Text text;
    public Transform controllerIcon;
    public Transform goalIcon;
    public Rigidbody attractor;
    public Rigidbody antiAttractor;

    //List<Transform> instances = new List<Transform>(5000);  // HERE: ガバッと取っておく。ちょっと性能に効いてる？
    List<Rigidbody> instances = new List<Rigidbody>();
    List<GameObject> attractors = new List<GameObject>();
    List<GameObject> antiAttractors = new List<GameObject>();

    List<Rigidbody> instanceCashe = new List<Rigidbody>();
    Rigidbody getInstanceFromCashe()
    {
        Rigidbody o = null;
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
            //o = GameObject.Instantiate(prefab, new Vector3(x, y, z), Quaternion.identity, transform);
            o = GameObject.Instantiate<Rigidbody>(prefab, new Vector3(x, y, z), Quaternion.identity, transform);
            // o = GameObject.Instantiate(prefab2, new Vector3(x, y, z), Quaternion.identity, transform);
        }

        return o;
    }
    void returnInstanceToCashe(Rigidbody o)
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
        attractors.Add(goalIcon.gameObject);
    }

#if !IS_OCULUS
    Vector3? prevMousePosition = null;
#endif

    IEnumerator enjoyYourLife(GameObject o, List<GameObject> list)
    {
        yield return new WaitForSeconds(3.0f);
        list.Remove(o);
        GameObject.Destroy(o);
    }

    Transform findNearestGoal(GameObject o, List<GameObject> list)
    {
        float minDist = float.MaxValue;
        Transform result = list[0].transform;
        foreach (var g in list)
        {
            float d = Vector3.Distance(o.transform.position, g.transform.position);
            if (d < minDist)
            {
                minDist = d;
                result = g.transform;
            }
        }
        return result;
    }

    // Update is called once per frame
    void Update()
    {
        var shootAttractor = false;
        var shootAntiAttractor = false;
#if IS_OCULUS
        var controller = OVRInput.Controller.RTrackedRemote;

        if (OVRInput.GetDown(OVRInput.Button.PrimaryIndexTrigger, controller)) {
            shootAttractor = true;
        }
        if (OVRInput.GetDown(OVRInput.Button.PrimaryTouchpad, controller)) {
            shootAntiAttractor = true;
        }

        var p = OVRInput.GetLocalControllerPosition(controller);
        var r = OVRInput.GetLocalControllerRotation(controller);
        //controllerIcon.SetPositionAndRotation(p, r);
        controllerIcon.localPosition = p;  // what does this mean for 3DoF devices e.g. Oculus Go?
        controllerIcon.localRotation = r;
#else
        if (Input.GetKeyDown(KeyCode.Space))
        {
            if (Input.GetKey(KeyCode.LeftShift) || Input.GetKey(KeyCode.RightShift))
            {
                shootAntiAttractor = true;
            }
            else
            {
                shootAttractor = true;
            }
        }
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

        Vector3 dir = controllerIcon.TransformDirection(Vector3.forward);

        if (shootAttractor)
        {
            var o = GameObject.Instantiate<Rigidbody>(attractor);
            o.AddForce(100.0f * dir, ForceMode.Impulse);
            attractors.Add(o.gameObject);
            StartCoroutine(enjoyYourLife(o.gameObject, attractors));
        }
        if (shootAntiAttractor)
        {
            var o = GameObject.Instantiate<Rigidbody>(antiAttractor);
            o.AddForce(100.0f * dir, ForceMode.Impulse);
            antiAttractors.Add(o.gameObject);
            StartCoroutine(enjoyYourLife(o.gameObject, antiAttractors));
        }

        RaycastHit hit;
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

        foreach (var o in instances)
        {
            var goal = findNearestGoal(o.gameObject, attractors);
            o.transform.LookAt(goal);
            o.AddRelativeForce(1.0f * Vector3.forward, ForceMode.Force);
        }

        var ql = QualitySettings.GetQualityLevel();
        text.text = $"Quality: {QualitySettings.names[ql]}\n"
            + $"{1000 * dt:F1} ms; "
            + $"{instances.Count} instances";
    }
}
