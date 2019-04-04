using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class SceneController : MonoBehaviour
{
    public string nextSceneName;

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        var controller = OVRInput.GetActiveController();
        if (OVRInput.GetDown(OVRInput.Button.PrimaryIndexTrigger, controller)) {
            SceneManager.LoadScene(nextSceneName, LoadSceneMode.Single);
        }
    }
}
