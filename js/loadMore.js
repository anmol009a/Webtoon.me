async function getWebtoons(webtoonType) {
    // console.log('Inside getWebtoons function');
    const response = await fetch(webtoonType);
    // console.log('before response');
    const webtoons = await response.text();
    // document.getElementById("webtoon-container").innerHTML = webtoons;
    return webtoons;
}

// ---------------------------------
if (document.getElementById('webtoon-type-btn').getAttribute("name") == "webtoon-btn") {
    a = getWebtoons(`webtoon_grid.php`);
    a.then(webtoons => document.getElementById("webtoon-container").innerHTML += webtoons)
} else {
    a = getWebtoons();
    a.then(webtoons => document.getElementById("webtoon-container").innerHTML += webtoons)
}


// load more btn handler
let webtoon_offset = 20;
let loadMoreBtn = document.getElementById('loadMoreBtn');
loadMoreBtn.addEventListener('click', loadMoreBtnHandler);

function loadMoreBtnHandler() {
    console.log('You have clicked the loadMoreBtn');

    if (document.getElementById('webtoon-type-btn').getAttribute("name") == "webtoon-btn") {
        a = getWebtoons(`webtoon_grid.php?webtoon_offset=${webtoon_offset}`);
        a.then(webtoons => document.getElementById("webtoon-container").innerHTML += webtoons)
        webtoon_offset += 20;
    } else {
        a = getWebtoons();
        a.then(webtoons => document.getElementById("webtoon-container").innerHTML += webtoons)
        webtoon_offset += 20;
    }
}