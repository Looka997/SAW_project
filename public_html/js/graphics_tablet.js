let canvas = document.getElementById("graphics_tablet");
let model = document.getElementById("model");
let upload = document.getElementById("upload");

let ctx = canvas.getContext("2d");

let api_url = "api/assets.php";
let image = new Image();
image.addEventListener("load", event => {
    ctx.drawImage(image, 0, 0);
})

// TODO: Ridimensionare canvas da decidere

function get_assets(callback) {
    let base_dir = "assets/";
    fetch(api_url)
        .then(response => response.json())
        .then(data => {
            data.forEach(element => {
                if (element.name === model.value)
                    callback(base_dir + element.filename);
            });
        });
}

function update_canvas(path) {
    image.src = path;
}

get_assets(update_canvas)

model.addEventListener("change", event => {
    get_assets(update_canvas);
});
