using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Grid : MonoBehaviour
{
    [SerializeField]
    GameObject pointPrefab;

    void Awake()
    {
        for (float x = -1; x <= 1; x += 1.0f)
        {
            for (float y = 0; y <= 2; y += 1.0f)
            {
                for (float z = -1; z <= 1; z += 1.0f)
                {
                    Instantiate(pointPrefab, new Vector3(x, y, z), Quaternion.identity);
                }
            }
        }
    }

    // Start is called before the first frame update
    void Start()
    {

    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
