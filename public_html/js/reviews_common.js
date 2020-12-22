let fetch_post = (url, value, callback, ...params) => {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: value
    })
    .then(response => response.json())
    .then(data => {
        callback(data,...params)
    });
};

let removeReviewForm = (prod_id) => {
    let parent_form = $("#review_text" + prod_id).parent();
    parent_form.remove();
};

let getReviewCounterNode = (prod_id) => {
    let parent_div = $('#alert-success' + prod_id).parent().parent();
    return parent_div.children('.show-reviews');
}

let setReviewCounter = (data, prod_id) => {
    let node = getReviewCounterNode(prod_id);
    node.html("Questo design ha " + data.count +" reviews");
}
let updateReviewCounter = (prod_id) => {
    let request = "count=" + "&product=" + prod_id;
    fetch_post("api/reviews.php", request, setReviewCounter, prod_id);
};

let setAverageScore = (data, prod_id) => {
    let node = $('#avg_score' + prod_id);
    node.text("Voto medio: " + data.avg_score);
}
let updateAverageScore = (prod_id) => {
    let request = "avg_score=" + "&product=" + prod_id;
    fetch_post("api/reviews.php", request, setAverageScore, prod_id);
};