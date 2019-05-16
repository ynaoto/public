using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class MirageSoloController : MonoBehaviour
{
    GvrControllerInputDevice gvrControllerInput;

    // Start is called before the first frame update
    void Start()
    {
        gvrControllerInput = GvrControllerInput.GetDevice(GvrControllerHand.Dominant);
    }

    // Update is called once per frame
    void Update()
    {
        if (gvrControllerInput.GetButton(GvrControllerButton.TouchPadTouch))
        {
            var pos = gvrControllerInput.TouchPos;
            var maxv = 300.0f * 1000f / 60f / 60f; // m/s
            transform.Translate(maxv * pos.y * Time.deltaTime * Camera.main.transform.forward);
        }
    }
}
