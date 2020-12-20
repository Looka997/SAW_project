let reviewSent = [];

let fetch_send_review = (url, value, callback) => {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: value
    })
    .then(response => response.json())
    .then(data => {
        callback(data)
    });
};

let submitReview = (reviewScore, reviewText, prod_id) => {
    let request = "score=" + reviewScore + "&content=" + reviewText + "&product=" + prod_id;
    fetch_send_review("api/send_review.php", request, console.log )
};

$('.review_submit').click((event)=>{
    event.preventDefault();
    if (!reviewSent.includes()){
        let prod_id = event.target.getAttribute('prod_id');
        let reviewText = $('#review_text' + prod_id).val();
        let reviewScore = $('#review_score' + prod_id).val();
        submitReview(reviewScore, reviewText, prod_id);
        reviewSent.push(prod_id);
    }
});