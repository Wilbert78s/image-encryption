from PIL import Image # manipulate
def padding(img):
    # Create a new blank image with the desired size (512x512)
    new_img = Image.new("RGB", (512, 512), color="white")

    # Paste the original image onto the new image with padding
    new_img.paste(img, (0,0))

    return new_img


def preProcessing(img):    
    # Convert image to RGB
    img = img.convert("RGB")

    # If image less than 512x512, then do padding
    if(img.width!=512 or img.height!=512):
        img = padding(img)

    return img


def postProcessing(img, width, height):
    # Crop image into the original shape
    unpadded_img = img.crop((0,0, width, height))

    return unpadded_img


def extractPatches(image_array, size):
    height, width = image_array.shape[:2]

    patch_row = height // size
    patch_col = width // size

    patches = []

    # Extract patches
    for i in range(patch_row):
        for j in range(patch_col):
            start_row = i * size
            end_row = (i + 1) * size
            start_col = j * size
            end_col = (j + 1) * size

            patch = image_array[start_row:end_row, start_col:end_col,:]
            patches.append(patch)
    return patches


def combinePatches(reconstructed_image, patches, size):
    patch_row = 512 // size
    patch_col = 512 // size

    patches_index = 0

    # Combine patches
    for i in range(patch_row):
        for j in range(patch_col):
            start_row = i * size
            end_row = (i + 1) * size
            start_col = j * size
            end_col = (j + 1) * size

            # Put patch into reconstructed image
            reconstructed_image[start_row:end_row, start_col:end_col,:] = patches[patches_index]

            # Move to the next swapped patch
            patches_index += 1
            
    return reconstructed_image