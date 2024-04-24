import numpy as np # store array
from .processs import extractPatches, combinePatches

def decomposition_and_permutation(img_array,p1,reversed_image):
    # Extract image into 64 patches size 64x64
    small_patches = extractPatches(img_array, 64)

    # Swap patches
    swapped_patches=np.empty_like(small_patches)
    b=np.zeros(64)
    for i in range(64):
        b[i]=(p1*(i+1))%64
        if(reversed_image == False):
            swapped_patches[i]=small_patches[int(b[i])]
        else:
            swapped_patches[int(b[i])]=small_patches[i]

    # Combine patches
    reconstructed_image = np.empty_like(img_array, dtype=np.uint8)
    reconstructed_image = combinePatches(reconstructed_image, swapped_patches, 64)

    return reconstructed_image
