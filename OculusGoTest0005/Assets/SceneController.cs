using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class SceneController : MonoBehaviour
{
    public string[] sceneNames;
    int sceneIdx = 0;
    AsyncOperation asyncLoad;

    void preloadNextScene()
    {
        int idx = (sceneIdx + 1) % sceneNames.Length;
        asyncLoad = SceneManager.LoadSceneAsync(sceneNames[idx], LoadSceneMode.Additive);
        asyncLoad.allowSceneActivation = false;
    }

    // Start is called before the first frame update
    void Start()
    {
        SceneManager.LoadScene(sceneNames[sceneIdx], LoadSceneMode.Additive);
        //preloadNextScene();
    }

    IEnumerator loadNextScene()
    {
        /*
        Debug.Log(nextSceneName + " to load");
        //asyncLoad = SceneManager.LoadSceneAsync(nextSceneName, LoadSceneMode.Single);
        asyncLoad = SceneManager.LoadSceneAsync(nextSceneName, LoadSceneMode.Additive);
        asyncLoad.allowSceneActivation = false;
        while (!asyncLoad.isDone)
        {
            yield return null;
        }
        asyncLoad.allowSceneActivation = true;
        Debug.Log(nextSceneName + " to load OK");

        Debug.Log(gameObject.scene.name + " to unload");
        var asyncUnload = SceneManager.UnloadSceneAsync(gameObject.scene.name);
        while (!asyncUnload.isDone)
        {
            yield return null;
        }
        Debug.Log(gameObject.scene.name + " to unload OK");
        */

        // asyncLoad = SceneManager.LoadSceneAsync(nextSceneName, LoadSceneMode.Additive);
        // asyncLoad.allowSceneActivation = false;
        while (!asyncLoad.isDone)
        {
            if (0.9f <= asyncLoad.progress)
            {
                SceneManager.UnloadSceneAsync(sceneNames[sceneIdx]);
                sceneIdx = (sceneIdx + 1) % sceneNames.Length;
                asyncLoad.allowSceneActivation = true;
            }
            yield return null;
        }
        // yield return asyncLoad;
        // asyncLoad.allowSceneActivation = true;
        // yield return SceneManager.UnloadSceneAsync(gameObject.scene.name);
        //SceneManager.UnloadSceneAsync(gameObject.scene.name);
    }

    IEnumerator loadNextScene2()
    {
        int idx = (sceneIdx + 1) % sceneNames.Length;
        asyncLoad = SceneManager.LoadSceneAsync(sceneNames[idx], LoadSceneMode.Additive);
        asyncLoad.allowSceneActivation = false;
        while (!asyncLoad.isDone)
        {
            Debug.Log("PROGRESS: " + asyncLoad.progress);
            if (0.9f <= asyncLoad.progress)
            {
                asyncLoad.allowSceneActivation = true;
                yield return SceneManager.UnloadSceneAsync(sceneNames[sceneIdx]);
                sceneIdx = (sceneIdx + 1) % sceneNames.Length;
            }
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
                // StartCoroutine(loadNextScene());
                StartCoroutine(loadNextScene2());
            }
        }
    }
}
