using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CameraMover : MonoBehaviour
{
    Transform _centerEyeAnchor;
    public float moveSpeed = 1.0f;

    void Awake()
    {
        _centerEyeAnchor = transform.Find("TrackingSpace/CenterEyeAnchor");
    }

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        var controller = OVRInput.GetActiveController();
        if (controller != OVRInput.Controller.None)
        {
            Vector2 primaryTouchpad = OVRInput.Get(OVRInput.Axis2D.PrimaryTouchpad);
            Vector3 distance = _centerEyeAnchor.rotation * new Vector3(primaryTouchpad.x, 0, primaryTouchpad.y);
            transform.position += distance * moveSpeed * Time.deltaTime;
        }
    }
}
