using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class location : MonoBehaviour
{
    private TextMesh textMesh;
    private Camera mainCamera;

    // Start is called before the first frame update
    void Start()
    {
        Input.location.Start(0.1f, 0.1f);
        Input.compass.enabled = true;
        textMesh = GetComponent<TextMesh>();
        mainCamera = Camera.main;
    }

    // Update is called once per frame
    void Update()
    {
        textMesh.transform.position = mainCamera.transform.position + 1.0f*mainCamera.transform.forward;
        textMesh.transform.LookAt(mainCamera.transform.position);
        textMesh.transform.Rotate(0.0f, 180.0f, 0.0f);
        var msg = new List<string>();
        if (Input.location.isEnabledByUser)
        {
            if (Input.location.status == LocationServiceStatus.Running)
            {
                var alt = Input.location.lastData.altitude;
                var lat = Input.location.lastData.latitude;
                var lng = Input.location.lastData.longitude;
                var ha = Input.location.lastData.horizontalAccuracy;
                var va = Input.location.lastData.verticalAccuracy;
                var t = Input.location.lastData.timestamp;
                msg.Add($"alt:{alt:#.###}, lat:{lat:#.###}, lng:{lng:#.###}\n"
                        + $"horizontalAccuracy:{ha:#.###}, verticalAccuracy:{va:#.###}\n"
                        + $"@{t}");
            }
            else
            {
                msg.Add($"{Input.location.status}");
            }
        }
        else
        {
            msg.Add($"location service is not enabled by user.");
        }
        if (Input.compass.enabled)
        {
            var th = Input.compass.trueHeading;
            var ha = Input.compass.headingAccuracy;
            var t = Input.compass.timestamp;
            // msg.Add($"trueHeading:{th:#.###}, headingAccuracy:{ha:#.###} @{t}");
            msg.Add($"trueHeading:{th:#.###}, headingAccuracy:{ha} @{t}");
        }
        else
        {
            msg.Add($"compass is not enabled.");
        }
        textMesh.text = string.Join("\n", msg);
    }
}
