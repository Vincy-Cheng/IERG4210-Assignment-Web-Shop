document.querySelectorAll(".drop-zone-input").forEach(inputElement => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", e => {
        inputElement.click();
    });
    inputElement.addEventListener("change", e => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    })

    dropZoneElement.addEventListener("dragover", e => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone-over");
    });

    ["dragleave", "dragend"].forEach(type => {
        dropZoneElement.addEventListener(type, e => {
            dropZoneElement.classList.remove('drop-zone-over');
        });
    });

    dropZoneElement.addEventListener("drop", e => {
        e.preventDefault();
        // console.log(e.dataTransfer.files);
        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            // console.log(inputElement.files);
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }


        dropZoneElement.classList.remove("drop-zone-over");
    });
});

function updateThumbnail(dropZoneElement, file) {
    // console.log(dropZoneElement);
    // console.log(file);
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone-thumb");


    //show inmage

    if (file.type.startsWith("image/")) {
        if (dropZoneElement.querySelector(".drop-zone-prompt")) {
            dropZoneElement.querySelector(".drop-zone-prompt").remove();
        }
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone-thumb");

            dropZoneElement.appendChild(thumbnailElement);
        }
        // no need
        thumbnailElement.dataset.label = file.name;
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${ reader.result}')`;
        };
    }
}

// function redcolor() {
//     document.querySelector("header").style.color = "red";
// }

// function bluecolor() {
//     document.querySelector("header").style.color = "blue";
// }

// function clicked() {
//     alert("clicked");
// }