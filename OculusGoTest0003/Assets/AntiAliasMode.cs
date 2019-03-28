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

    float minDt;
    float maxDt;
    float sumDt;
    int numDt;

    void updateAntialiasingMode()
    {
        ppl.antialiasingMode = aaModes[aaModeIdx];
        minDt = float.NaN;
        maxDt = float.NaN;
        sumDt = 0;
        numDt = 0;
    }

    // Start is called before the first frame update
    void Start()
    {
        ppl = GetComponent<PostProcessLayer>();
        updateAntialiasingMode();
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
                updateAntialiasingMode();
            }
        }
        var dt = Time.deltaTime;
        minDt = float.IsNaN(minDt) ? dt : Mathf.Min(minDt, dt);
        maxDt = float.IsNaN(maxDt) ? dt : Mathf.Max(maxDt, dt);
        sumDt += dt;
        numDt++;
        var ql = QualitySettings.GetQualityLevel();
        text.text = $"{QualitySettings.names[ql]}\n"
            + $"{ppl.antialiasingMode}\n"
            + $"{(int)(1000 * minDt)}; {(int)(1000 * dt)}; {(int)(1000 * maxDt)} ({(int)(1000 * sumDt / numDt)}) ms";
    }
}
