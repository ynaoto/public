using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using TMPro;
using UnityEngine.Rendering.PostProcessing;

public class AntiAliasMode : MonoBehaviour
{
    public TextMeshPro text;
    PostProcessLayer ppl;
    PostProcessLayer.Antialiasing[] aaModes = {
        PostProcessLayer.Antialiasing.None,
        PostProcessLayer.Antialiasing.FastApproximateAntialiasing,
        PostProcessLayer.Antialiasing.SubpixelMorphologicalAntialiasing,
        PostProcessLayer.Antialiasing.TemporalAntialiasing,
    };
    int aaModeIdx = 0;

    // Start is called before the first frame update
    void Start()
    {
        ppl = GetComponent<PostProcessLayer>();
        ppl.antialiasingMode = aaModes[aaModeIdx];
    }

    // Update is called once per frame
    void Update()
    {
        var controller = OVRInput.GetActiveController();
        if (controller != OVRInput.Controller.None)
        {
            if (OVRInput.GetDown(OVRInput.Button.PrimaryIndexTrigger, controller))
            {
                aaModeIdx = (aaModeIdx + 1) % aaModes.Length;
                ppl.antialiasingMode = aaModes[aaModeIdx];
            }
        }
        text.text = ppl.antialiasingMode.ToString();
    }
}
