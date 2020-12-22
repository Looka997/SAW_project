let reviewSent = [];

let fetch_send_review = (url, value, callback, ...params) => {
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


let displayAlert = (error, prod_id) => {
    let alert_to_show;
    let alert_to_hide;
    if (!!error){
        alert_to_show = $('#alert-danger' + prod_id);
        alert_to_hide = $('#alert-success' + prod_id);
    }else{
        alert_to_show = $('#alert-success' + prod_id);
        alert_to_hide = $('#alert-danger' + prod_id);
    }
    if (!alert_to_hide.hasClass('hidden')){
        alert_to_hide.addClass('hidden');
    }
    
    if (alert_to_show.hasClass('hidden')){
        alert_to_show.removeClass('hidden');
    }
}

let disableReviewForm = (prod_id) => {

};

let updateReviewCounter = (prod_id) => {

};

let onReviewInsert = (response, prod_id) => {
    displayAlert(response.error, prod_id);
    disableReviewForm(prod_id);
    updateReviewCounter(prod_id);
};

let submitReview = (reviewScore, reviewText, prod_id) => {
    let request = "score=" + reviewScore + "&content=" + reviewText + "&product=" + prod_id;
    fetch_send_review("api/send_review.php", request, onReviewInsert, prod_id)
};

$('.review_submit').click((event)=>{
    event.preventDefault();
    let prod_id = event.target.getAttribute('prod_id');
    if (!reviewSent.includes(prod_id)){
        let reviewText = $('#review_text' + prod_id).val();
        let reviewScore = $('#review_score' + prod_id).val();
        submitReview(reviewScore, reviewText, prod_id);
        reviewSent.push(prod_id);
    }
});