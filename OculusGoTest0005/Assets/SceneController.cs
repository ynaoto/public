using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class SceneController : MonoBehaviour
{
    public string nextSceneName;
    public Camera camera;
    GameObject cameraHolder;

    // Start is called before the first frame update
    void Start()
    {
        cameraHolder = new GameObject("cameraHolder");
        camera.transform.SetParent(cameraHolder.transform);
        cameraHolder.transform.SetParent(transform);
    }

    IEnumerator loadNextScene()
    {
        AsyncOperation asyncLoad = SceneManager.LoadSceneAsync(nextSceneName);
        while (!asyncLoad.isDone)
        {
            yield return null;
        }
    }

    // Update is called once per frame
    void Update()
    {
        var controller = OVRInput.GetActiveController();
        if (controller != OVRInput.Controller.None)
        {
            if (OVRInput.GetDown(OVRInput.Button.PrimaryIndexTrigger))
            {
                StartCoroutine(loadNextScene());
            }
            if (OVRInput.Get(OVRInput.Button.PrimaryTouchpad))
            {
                var v = OVRInput.Get(OVRInput.Axis2D.PrimaryTouchpad);
                var d = camera.transform.forward;
                cameraHolder.transform.Translate(0.1f*v.y*d);
            }
        }
    }
}
