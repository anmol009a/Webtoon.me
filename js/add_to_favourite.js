var favUrl = "src/add_to_favourite.php?";

async function addToFavourite(webtoonId) {
    // sclice to get webtoon ID
    webtoonId = webtoonId.slice(4);

    // initialize form as fetch sends data as JSON
    let formData = new FormData();
    formData.append('webtoon_id', webtoonId);

    // send POST request
    const response = await fetch(favUrl + "webtoon_id=" + webtoonId, { method: 'POST', body: formData });
    const res = await response.text();
    // console.log(res);

    // show alert
    alert(res);
}
