async function getWebtoons(url) {
    const response = await fetch(url);
    const webtoons = await response.text();
    return webtoons;
}

// load more btn handler
let offset = 0;
let loadMoreBtn = document.getElementById('load-more-btn');
loadMoreBtn.addEventListener('click', loadMoreBtnHandler);

function loadMoreBtnHandler() {
    console.log('You have clicked the loadMoreBtn');

    offset++;
    a = getWebtoons(`webtoon_grid.php?p=${offset}`);
    a.then(webtoons => document.getElementById("post-listing").innerHTML += webtoons);

}