import numpy as np # store array

def bitwise_XOR(img, sine_map):
    # Convert the image to a NumPy array
    img_array = np.array(img)

    # Make img_array and sine_map same data type
    img_array = img_array.astype(np.uint8)
    sine_map = sine_map.astype(np.uint8)

    # Perform bitwise XOR
    img_array[:,:,0] = np.bitwise_xor(img_array[:,:,0], sine_map)
    img_array[:,:,1] = np.bitwise_xor(img_array[:,:,1], sine_map)
    img_array[:,:,2] = np.bitwise_xor(img_array[:,:,2], sine_map)
    
    return img_array