using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class rot : MonoBehaviour
{
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        transform.Rotate(0.0f, 30.0f*Time.deltaTime, 0.0f);
        // Debug.Log(Input.location.isEnabledByUser);
        if (Input.location.isEnabledByUser)
        {
            var alt = Input.location.lastData.altitude;
            var lat = Input.location.lastData.latitude;
            var lng = Input.location.lastData.longitude;
            Debug.Log($"{alt}, {lat}, {lng}");
        }
    }
}
