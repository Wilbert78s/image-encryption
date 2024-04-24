import hashlib # hashing
import numpy as np # store array

def logistic_map(x,a,b):
    result = (a*x*(1-x)+(4-a)*np.cos(b*np.arccos(x))/4)%1
    return result


def sine_map(x,a,b):
    result = (a*np.sin(np.pi*x)+(4-a)*np.cos(b*np.arccos(x))/4)%1
    return result


def sha3_keccak(binary_data):
    # Count SHA-3 Keccak value in hex
    keccak256_hash = hashlib.sha3_256(binary_data).hexdigest()

    # Format hash value into binary
    binary_string = format(int(keccak256_hash, 16), '0256b')
    return binary_string


def generate_map(a,b,x0, a0, x1, a1):
    # Create a 2D array with size [512][4*512] filled with zeros
    array_size_log = (512, 4 * 512)
    array_size_sine = (512, 512)
    log_map_res = np.zeros(array_size_log)
    sine_map_res = np.zeros(array_size_sine)

    # Generate log array
    for i in range(a):
        x0 = logistic_map(x0,a0,b) 
    for i in range(4 * 512):
        for j in range(512):         
            x0 = logistic_map(x0,a0,b)
            if (x0>0.5) :                
                log_map_res[j, i] = 1

    # Generate sine array
    for i in range(a):
        x1 = sine_map(x1,a1,b)
    for i in range(512):
        for j in range(512):
            x1 = sine_map(x1,a1,b)
            mapping = np.floor((x1 * 1e15) % 256) 
            sine_map_res[j,i] = mapping

    return {
        'log_map' : log_map_res,
        'sine_map': sine_map_res
        }


def performXOR(targets):
    # Perform XOR in every targets elements
    res = int(targets[0], 2)
    for binary in targets[1:]:
        res ^= int(binary, 2)
    
    return res


def secret_key(hashes, x0, a0, x1, a1):
    res=[]

    for hash in hashes:
        # Seperate hash into array with 32 elements contains 8 bits each
        k = [hash[i:i+8] for i in range(0, len(hash), 8)]

        # Perform XOR for a range of array index
        decimal_number_9_16 = performXOR(k[8:16])
        decimal_number_1_8 = performXOR(k[:8])
        decimal_number_1_32 = performXOR(k[:32])

        # Sum array element in integer
        sumOfK = sum(int(binary_str, 2) for binary_str in k) % 256

        # Generate parameter
        x0=(x0+decimal_number_9_16/128)/3
        a0=(a0+decimal_number_1_8/32)/3
        x1=(x1+decimal_number_1_32/128)/3
        a1=(a1+sumOfK/32)/3

        # Set generated parameter to associative array
        temp={'x0':x0,
            'a0':a0,
            'x1':x1,
            'a1':a1}
        
        res.append(temp)

    return res
