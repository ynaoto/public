using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class GenCubes : MonoBehaviour
{
    public Transform prefab;
    public Text text;
    public Transform controllerIcon;
    public Transform goalIcon;
    List<Transform> instances = new List<Transform>();

    void addCube()
    {
        var r = 3.0f;
        var x = Random.Range(-r, r);
        var y = Random.Range(-r, r);
        var z = 0.0f;
        var o = GameObject.Instantiate(prefab, new Vector3(x, y, z), Quaternion.identity, transform);
        instances.Add(o);
    }

    void delCube()
    {
        var i = instances.Count - 1;
        if (0 <= i)
        {
            var o = instances[i];
            Destroy(o.gameObject);
            instances.RemoveAt(i);
        }
    }

    // Start is called before the first frame update
    void Start()
    {

    }

    // Update is called once per frame
    void Update()
    {
        var c = OVRInput.Get(OVRInput.Button.PrimaryIndexTrigger);
        //Debug.Log("XXXXXX " + c);
        var p = OVRInput.GetLocalControllerPosition(OVRInput.Controller.RTrackedRemote);
        var r = OVRInput.GetLocalControllerRotation(OVRInput.Controller.RTrackedRemote);
        //controllerIcon.SetPositionAndRotation(p, r);
        controllerIcon.localPosition = p;  // what does this mean for 3DoF devices e.g. Oculus Go?
        controllerIcon.localRotation = r;

        RaycastHit hit;
        Vector3 dir = controllerIcon.TransformDirection(Vector3.forward);
        int layerMask = 1 << 31;
        if (Physics.Raycast(controllerIcon.position, dir, out hit, Mathf.Infinity, layerMask)) {
            goalIcon.position = hit.point;
        }

        var dt = Time.deltaTime;
        if (1000 * dt < 32)
        {
            addCube();
        }
        else
        {
            delCube();
        }

        var lastP = goalIcon.position;
        foreach (var o in instances) {
            o.position += 0.1f*(lastP - o.position);
            lastP = o.position;
        }

        string s = "";
        var ql = QualitySettings.GetQualityLevel();
        s += $"Quality: {QualitySettings.names[ql]}";
        s += "\n";
        s += $"{1000*dt:F1} ms; ";
        s += $"{instances.Count} instances";
        text.text = s;
    }
}
