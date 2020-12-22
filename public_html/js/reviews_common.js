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

let updateReviewCounter = (prod_id) => {

};

let updateAverageScore = (prod_id) => {

};