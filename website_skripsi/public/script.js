function displayImage(input) {
    console.log("display image");
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const image = new Image();
            image.src = e.target.result;

            image.onload = function () {
                const width = this.width;
                const height = this.height;

                if (width <= 512 && height <= 512) {
                    document.getElementById("preview-image").src =
                        e.target.result;
                    document.getElementById("preview-image").style.display =
                        "block";
                } else {
                    alert(
                        "Please select an image with dimensions smaller or equal to 512x512."
                    );
                    resetInput();
                }
            };
        };

        reader.readAsDataURL(file);
    }
}

function resetInput() {
    document.getElementById("inputGroupFile02").value = "";
    document.getElementById("preview-image").src = "img/blank_image.png";
    document.getElementById("preview-image").style.display = "block";
}

document.getElementById("main").addEventListener("submit", function (event) {
    console.log("processing...");
    document.getElementById("overlay").style.display = "block";
});

function handleSelectChange(selectElement) {
    console.log("tes");
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    dbSelectedImage(selectedOption.value);
}

function dbSelectedImage(image_id) {
    console.log("getting image from db");

    fetch("/image/" + image_id, {
        method: "GET",
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            console.log(response);
            return response.json();
        })
        .then((data) => {
            console.log("Response:", data);

            var file = data.file;

            // Convert base64 to Blob
            var byteCharacters = atob(file);
            var byteNumbers = new Array(byteCharacters.length);
            for (var i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            var blob = new Blob([byteArray], { type: "image/png" });

            // Create a File object from the Blob
            var fileObject = new File([blob], "your_image.png" || "image.png", {
                type: "image/png",
            });

            // Create a FileList object containing the File object
            var fileList = new DataTransfer();
            fileList.items.add(fileObject);

            // Set the FileList object to the file input element
            var fileInput = document.getElementById("inputGroupFile02");
            if (fileInput) {
                fileInput.files = fileList.files;
            } else {
                console.error(
                    "Element with id 'inputGroupFile02' not found in the HTML"
                );
            }

            document.getElementById("preview-image").src =
                "data:image/png;base64," + file;
        })
        .catch((error) => {
            // Handle errors
            console.error("Error:", error);
        });
}

function downloadImage() {
    // Get the image URL
    console.log("testing");
    const img = document.getElementById("result-image");

    const link = document.createElement("a");
    link.href = img.src;
    // Set the download attribute to specify the filename for the download
    link.download = "image.png";

    // Append the anchor to the document body
    document.body.appendChild(link);

    // Trigger a click event on the anchor element
    link.click();

    // Remove the anchor from the document body
    document.body.removeChild(link);
}

document
    .getElementById("flexSwitchCheckDefault")
    .addEventListener("change", function () {
        var dynamicElementContainer = document.getElementById(
            "dynamicElementContainer"
        );
        dynamicElementContainer.innerHTML = "";

        var imageInput = document.getElementById("inputGroupFile02");
        if (this.checked) {
            var user_id = document.getElementById("user_id").value;
            console.log(user_id);
            fetch("/get-image/" + user_id, {
                method: "GET",
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    var images = data.images;
                    console.log(images);
                    imageInput.classList.add("visually-hidden");

                    var newSelect = document.createElement("select");
                    newSelect.setAttribute("class", "form-select");
                    newSelect.setAttribute(
                        "aria-label",
                        "Default select example"
                    );
                    dynamicElementContainer.appendChild(newSelect);

                    // Add options to the select element
                    images.forEach(function (image) {
                        var option1 = document.createElement("option");
                        option1.setAttribute("value", image.id);
                        option1.textContent = image.name;
                        newSelect.appendChild(option1);
                    });

                    // Set default option
                    var defaultOption = document.createElement("option");
                    defaultOption.setAttribute("selected", "selected");
                    defaultOption.textContent = "Select your image";
                    newSelect.appendChild(defaultOption);

                    newSelect.addEventListener("change", function () {
                        handleSelectChange(newSelect);
                    });
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        } else {
            imageInput.classList.remove("visually-hidden");
        }
    });
