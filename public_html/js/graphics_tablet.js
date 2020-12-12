let fileNames = [];

let baseDir = "assets/";
let canvas = document.getElementById("graphics_tablet");
let modelSelector = document.getElementById("model");
let upload = document.getElementById("upload");

let ctx = canvas.getContext("2d");

let api_url = "api/assets.php";
let image = new Image();
image.addEventListener("load", event => {
    ctx.drawImage(image, 0, 0);
})

// TODO: Ridimensionare canvas da decidere
canvas.width = "450";
canvas.height = "600";

function get_assets(callback) {
    fetch(api_url)
        .then(response => response.json())
        .then(data => {
            fileNames = data;
            callback();
        });
}

function update_canvas(modelName) {
    let path;

    fileNames.forEach((element) => {
        if (element.name === modelName) {
            path = baseDir + element.filename;
        }
    });

    if (!path) return;

    image.src = path;
}

get_assets(() => { update_canvas(modelSelector.value) });

modelSelector.addEventListener("change", event => {
    update_canvas(event.target.value);
});
