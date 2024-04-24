import math
import os
from PIL import Image
import numpy as np
from processs import preProcessing

def count(img1, img2):
    mse = np.mean((img1 - img2) ** 2)
    
    if mse == 0:        
        print(f"MSE value is 0")
        print(f"PSNR value is 100 dB")
        return
    PIXEL_MAX = 255.0
    PSNR = 20 * math.log10(PIXEL_MAX / math.sqrt(mse))
    
    print(f"MSE value is {mse}")
    print(f"PSNR value is {PSNR} dB")


def main():
    dir_path = os.path.dirname(os.path.realpath(__file__))
    # Loading images (original image and compressed image)
    cipher = Image.open(os.path.join(dir_path, 'images\\cipher.png'))
    plain = Image.open(os.path.join(dir_path, 'images\\plain.png'))
    original = Image.open(os.path.join(dir_path, 'images\\original.png'))
    
    if original is None or cipher is None or plain is None:
        print("Error: One or both images failed to load.")
        return
    
    original = np.array(preProcessing(original))
    plain = np.array(preProcessing(plain))
    cipher = np.array(preProcessing(cipher))
    # plain = preProcessing(np.array(plain))
    # cipher = preProcessing(np.array(cipher))
    
    print("-- Original and Cipher --")
    count(original, cipher)
    # print()
    print("-- Original and Plain --")
    count(original, plain)


if __name__ == '__main__':
    main()
