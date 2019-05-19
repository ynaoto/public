using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Grid : MonoBehaviour
{
    [SerializeField]
    GameObject pointPrefab;

    void Awake()
    {
        for (float x = -2; x <= 2; x += 0.5f)
        {
            for (float y = -2; y <= 2; y += 0.5f)
            {
                for (float z = -2; z <= 2; z += 0.5f)
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
