from PIL import Image # manipulate
from IPython.display import display # show image

import numpy as np # store array
from .key_generation import generate_map, secret_key, sha3_keccak
from .decomposition_and_permutation import decomposition_and_permutation
from .substitution import substitution
from .DNA import encode, decode, complementary
from .bitwise_XOR import bitwise_XOR
from .processs import preProcessing, postProcessing

def encrypt(plain_img, a, b, x0, a0, x1, a1, prime, k1, k2):
    # Get image dimension
    height = plain_img.height
    width = plain_img.width

    # Image pre-processing
    plain_img = preProcessing(plain_img)

    # Generate hash
    hash_image = sha3_keccak(plain_img.tobytes())
    hash_pixel = sha3_keccak(bytes(str(width*height), 'utf-8'))
    hashes = np.array([hash_image, hash_pixel])

    # Generate Keys
    key = secret_key(hashes, x0, a0, x1, a1)
    
    # Convert img to array
    plain_img_array = np.array(plain_img)

    # Encrypt
    for i in range(2):
        map = generate_map(a, b, key[i]['x0'], key[i]['a0'], key[i]['x1'], key[i]['a1'])
        p1 = decomposition_and_permutation(plain_img_array, prime[i], False)
        p2 = substitution(p1, False)
        p3 = encode(p2, k1)
        p4 = complementary(p3, map['log_map'])
        p5 = decode(p4, k2)
        p6 = bitwise_XOR(p5, map['sine_map'])
        plain_img_array = p6
    
    # Convert into image
    cipher_image = Image.fromarray(p6, "RGB")

    res = {
        'height':height,
        'width':width,
        'hash':hash_image,
        'image':cipher_image,
    }
    return res


def decrypt(cipher_img, a, b, x0, a0, x1, a1, prime, k1, k2, hash_image, width, height):
    # Image pre-processing
    cipher_img = preProcessing(cipher_img)

    # Generate hash
    hash_pixel = sha3_keccak(bytes(str(width*height), 'utf-8'))    
    hashes = np.array([hash_image, hash_pixel])

    # Generate Keys
    key = secret_key(hashes, x0, a0, x1, a1)

    # Convert img to array
    cipher_img_array = np.array(cipher_img)

    # Decrypt
    for i in range(1,-1,-1):
        map = generate_map(a, b, key[i]['x0'], key[i]['a0'], key[i]['x1'], key[i]['a1'])
        d1 = bitwise_XOR(cipher_img_array, map['sine_map'])
        d2 = encode(d1, k2)
        d3 = complementary(d2, map['log_map'])
        d4 = decode(d3, k1)
        d5 = substitution(d4, True)
        d6 = decomposition_and_permutation(d5, prime[i], True)
        cipher_img_array = d6

    # Convert into image
    cipher_img = Image.fromarray(d6)

    # Image post-processing
    cipher_img = postProcessing(cipher_img, width, height)
    
    res = {
        'image':cipher_img
    }
    return res