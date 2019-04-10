using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class CameraController : MonoBehaviour
{
    public Camera camera;
    public TextMesh text;

    // Start is called before the first frame update
    void Start()
    {
        camera.transform.SetParent(transform);
        text.transform.SetParent(camera.transform);
        text.transform.localPosition = new Vector3(0.0f, 0.0f, 15.0f);
        text.transform.localRotation = Quaternion.identity;
    }

    // Update is called once per frame
    void Update()
    {
        text.text = gameObject.scene.name + "; " + camera.transform.rotation;
        var controller = OVRInput.GetActiveController();
        if (controller != OVRInput.Controller.None)
        {
            if (OVRInput.Get(OVRInput.Button.PrimaryTouchpad))
            {
                var v = OVRInput.Get(OVRInput.Axis2D.PrimaryTouchpad);
                var d = camera.transform.forward;
                transform.Translate(0.1f*v.y*d);
            }
        }
    }
}
