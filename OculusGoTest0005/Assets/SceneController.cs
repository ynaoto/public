using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class SceneController : MonoBehaviour
{
    public string[] sceneNames;
    // int sceneIdx = 0;
    int sceneIdx;
    AsyncOperation asyncLoadNextScene;

    AsyncOperation startLoadScene(int idx)
    {
        var asyncLoad = SceneManager.LoadSceneAsync(sceneNames[idx], LoadSceneMode.Additive);
        asyncLoad.allowSceneActivation = false;
        return asyncLoad;
    }
    
    IEnumerator waitAsyncLoad(AsyncOperation asyncLoad)
    {
        while (!asyncLoad.isDone)
        {
            Debug.Log("PROGRESS: " + asyncLoad.progress);
            if (0.9f <= asyncLoad.progress)
            {
                asyncLoad.allowSceneActivation = true;
            }
            yield return null;
        }
        Debug.Log("COMPLETED: " + asyncLoad.progress);
    }

    IEnumerator activateNextScene()
    {
        yield return waitAsyncLoad(asyncLoadNextScene);
        asyncLoadNextScene = startLoadScene((sceneIdx + 1) % sceneNames.Length);
    }

    IEnumerator switchToNextScene()
    {
        yield return waitAsyncLoad(asyncLoadNextScene);
        yield return SceneManager.UnloadSceneAsync(sceneNames[sceneIdx]);
        sceneIdx = (sceneIdx + 1) % sceneNames.Length;
        asyncLoadNextScene = startLoadScene((sceneIdx + 1) % sceneNames.Length);
    }

    // Start is called before the first frame update
    void Start()
    {
        sceneIdx = 0;
        asyncLoadNextScene = startLoadScene(sceneIdx);
        StartCoroutine(activateNextScene());
    }

    // Update is called once per frame
    void Update()
    {
        var controller = OVRInput.GetActiveController();
        if (controller != OVRInput.Controller.None)
        {
            if (OVRInput.GetDown(OVRInput.Button.PrimaryIndexTrigger))
            {
                StartCoroutine(switchToNextScene());
            }
        }
    }
}
