using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BehaviorTest : MonoBehaviour
{
    // Start is called before the first frame update
    void Start()
    {
        //Debug.Log($"{this.name}: Start");
    }

    // Update is called once per frame
    void Update()
    {
        //Debug.Log($"{this.name}: Update");
    }

    void OnTriggerEnter(Collider other)
    {
        //Debug.Log($"{this.name}: OnTriggerEnter");
    }
}
