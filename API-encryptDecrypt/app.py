from flask import Flask, jsonify, request, send_file, make_response
from werkzeug.utils import secure_filename
import io
import base64
from PIL import Image # manipulate
from processes.cryptography import encrypt, decrypt
import numpy as np # store array
from flask_cors import CORS
import base64
import numpy as np

import time

from PIL import Image
import io

app = Flask(__name__)
CORS(app)

@app.route("/")
def index():
    return jsonify({
        "status": {
            "code": 200,
            "message": "Success fetching the API",
        },
        "data": None
    }), 200

@app.route("/encrypt", methods=["POST"])
def encryption():    
    # Retrieve input
    image = request.files["image"]
    p1 = float(request.form.get('p1'))
    p2 = float(request.form.get('p2'))
    k1 = int(request.form.get('k1'))
    k2 = int(request.form.get('k2'))
    x0 = float(request.form.get('x0'))
    a0 = float(request.form.get('a0'))
    x1 = float(request.form.get('x1'))
    a1 = float(request.form.get('a1'))
    a = int(request.form.get('a'))        
    b = int(request.form.get('b'))

    # Read the content of the image
    img = Image.open(image)

    # Encrypt and count time
    start_time = time.time()
    encrypt_res = encrypt(img, a, b, x0, a0, x1, a1, [p1,p2], k1, k2)
    end_time = time.time()
    execution_time = end_time - start_time
    print("Execution time:", execution_time, "seconds")
    
    # Save the result in memory buffer in image PNG
    img_bytes = io.BytesIO()
    encrypt_res['image'].save(img_bytes, format='PNG')

    # Read from memory
    img_bytes = img_bytes.getvalue()

    # Convert the result into string
    img_base64 = base64.b64encode(img_bytes).decode('utf-8')

    response_data = {
        'file': img_base64,
        'hash': encrypt_res['hash'],
        'width': encrypt_res['width'],
        'height': encrypt_res['height']
    }
    return jsonify(response_data)


@app.route("/decrypt", methods=["POST"])
def decryption():  
    # Retrieve input  
    image = request.files["image"]
    p1 = float(request.form.get('p1'))
    p2 = float(request.form.get('p2'))
    k1 = int(request.form.get('k1'))
    k2 = int(request.form.get('k2'))
    x0 = float(request.form.get('x0'))
    a0 = float(request.form.get('a0'))
    x1 = float(request.form.get('x1'))
    a1 = float(request.form.get('a1'))
    a = int(request.form.get('a'))        
    b = int(request.form.get('b'))
    width = int(request.form.get('width'))        
    height = int(request.form.get('height'))
    hashing = request.form.get('hashing')


    # Read the content of the image
    img = Image.open(image)

    # Decrypt and count time
    
    start_time = time.time()
    decrypt_res = decrypt(img, a, b, x0, a0, x1, a1, [p1,p2], k1, k2, hashing, width, height)
    end_time = time.time()
    execution_time = end_time - start_time
    print("Execution time:", execution_time, "seconds")

    # Save the result in memory buffer in image PNG
    img_bytes = io.BytesIO()
    decrypt_res['image'].save(img_bytes, format='PNG')
    
    # Read from memory
    img_bytes = img_bytes.getvalue()
    
    # Convert the result into string
    img_base64 = base64.b64encode(img_bytes).decode('utf-8')

    response_data = {
        'file': img_base64,
    }
    return jsonify(response_data)
        
if __name__ == "__main__":
    app.run()

