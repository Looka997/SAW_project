let filenames = [];
let modelInfo = {
    wRatio: undefined,
    hRatio: undefined,
    xRatio: undefined,
    yRatio: undefined,
};

let baseDir = "assets/";
let canvas = document.getElementById("graphics_tablet");
let modelSelector = document.getElementById("model");
let upload = document.getElementById("upload");

let ctx = canvas.getContext("2d");

let api_url = "api/assets.php";
let modelImage = new Image();
modelImage.addEventListener("load", (event) => {
    draw_canvas();
});

let uploadImage = new Image();
uploadImage.addEventListener("load", (event) => {
    draw_canvas();
});

canvas.width = 450;
canvas.height = 600;

if (canvas.width / canvas.height !== 450 / 600) {
    canvas.width = 450;
    canvas.height = 600;
}

function get_assets(callback) {
    fetch(api_url)
        .then((response) => response.json())
        .then((data) => {
            filenames = data;
            callback();
        });
}

function draw_user_image() {
    let userImageWidth = 0;
    let userImageHeight = 0;
    if (uploadImage.width > uploadImage.height) {
        let ratio = (canvas.width * modelInfo.wRatio) / uploadImage.width;
        userImageWidth = canvas.width * modelInfo.wRatio;
        userImageHeight = uploadImage.height * ratio;
    } else {
        let ratio = (canvas.height * modelInfo.hRatio) / uploadImage.height;
        userImageWidth = uploadImage.width * ratio;
        userImageHeight = canvas.height * modelInfo.hRatio;
    }

    ctx.drawImage(
        uploadImage,
        canvas.width * modelInfo.xRatio,
        canvas.height * modelInfo.yRatio,
        userImageWidth,
        userImageHeight
    );
}

function draw_canvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(modelImage, 0, 0, canvas.width, canvas.height);

    draw_user_image();
}

function update_image(modelName) {
    let path;

    filenames.forEach((element) => {
        if (element.name === modelName) {
            path = baseDir + element.filename;
            modelInfo.xRatio = element.image_x_ratio;
            modelInfo.yRatio = element.image_y_ratio;
            modelInfo.wRatio = element.image_w_ratio;
            modelInfo.hRatio = element.image_h_ratio;
        }
    });

    if (!path) return;

    modelImage.src = path;
}

get_assets(() => {
    update_image(modelSelector.value);
});

modelSelector.addEventListener("change", (event) => {
    update_image(event.target.value);
});

upload.addEventListener("change", (event) => {
    let input = event.target;
    let reader = new FileReader();

    reader.onload = (event) => {
        uploadImage.src = event.target.result;
    };

    reader.readAsDataURL(input.files[0]);
});
