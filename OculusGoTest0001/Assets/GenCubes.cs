using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class GenCubes : MonoBehaviour
{
    public Transform prefab;
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
        var dt = Time.deltaTime;
        if (1000 * dt < 32)
        {
            addCube();
        }
        else
        {
            delCube();
        }
        string s = "";
        s += "dt: " + (1000*dt) + "ms";
        s += "; quality: " + QualitySettings.GetQualityLevel();
        s += "; instacnes: " + instances.Count;
        s += "; objects: " + transform.childCount;
        Debug.Log(s);
    }
}
