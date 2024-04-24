import numpy as np # store array

rule_1 = {'A': '00', 'T': '11', 'C': '01', 'G': '10'}
rule_2 = {'A': '00', 'T': '11', 'C': '10', 'G': '01'}
rule_3 = {'A': '01', 'T': '10', 'C': '00', 'G': '11'}
rule_4 = {'A': '01', 'T': '10', 'C': '11', 'G': '00'}
rule_5 = {'A': '10', 'T': '01', 'C': '00', 'G': '11'}
rule_6 = {'A': '10', 'T': '01', 'C': '11', 'G': '00'}
rule_7 = {'A': '11', 'T': '00', 'C': '01', 'G': '10'}
rule_8 = {'A': '11', 'T': '00', 'C': '10', 'G': '01'}
rules = [rule_1,
        rule_2,
        rule_3,
        rule_4,
        rule_5,
        rule_6,
        rule_7,
        rule_8]

comp = {'A': 'T', 'T': 'A', 'C': 'G', 'G': 'C'}

def encode(img_array, number):
    # Pick encoding rule
    encoding_rule = rules[number-1]
    encoding_rule_reversed = {value: key for key, value in encoding_rule.items()}

    # Get image size
    M, N = img_array.shape[:2]

    # Convert each element to 8-bit binary and store it as a string
    binary_array = np.vectorize(lambda x: format(x, '08b'))(img_array)

    # Generate 3 arrays size M,4N and fill with DNA code
    rgb=[]
    for i in range(3):        
        layer = np.empty((M, 4*N), dtype='<U8')
        for row in range(layer.shape[0]):
            for col in range(0, layer.shape[1], 4):
                layer[row, col] = encoding_rule_reversed.get(binary_array[row, col // 4, i][:2])
                layer[row, col+1] = encoding_rule_reversed.get(binary_array[row, col // 4, i][2:4])
                layer[row, col+2] = encoding_rule_reversed.get(binary_array[row, col // 4, i][4:6])
                layer[row, col+3] = encoding_rule_reversed.get(binary_array[row, col // 4, i][6:])
        rgb.append(layer)

    # Combine arrays
    rgb_image_array = np.stack((rgb[0], rgb[1], rgb[2]), axis=2)

    return rgb_image_array


def decode(img, number):
    # Pick decoding rule
    encoding_rule = rules[number-1]

    # Decode each array element 
    img = np.vectorize(encoding_rule.get)(img)

    # Convert array size 512,2048,3 into 512,512,3
    result_array = np.core.defchararray.add(img[:, ::4, :], np.core.defchararray.add(img[:, 1::4, :], np.core.defchararray.add(img[:, 2::4, :], img[:, 3::4, :])))

    # Convert each binary value in element into integer
    result_array = np.vectorize(lambda x: int(x,2))(result_array)
    return result_array


def complementary(img,log_map):    
    # Find complement for every element with log_map value 1
    img[log_map == 1] = np.vectorize(comp.get)(img[log_map == 1])
    return img