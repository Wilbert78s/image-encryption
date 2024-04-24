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

