const search = document.getElementById("search");

const searchItems = document.getElementById('search-items');

search.addEventListener('input', searchWebtoon);


function searchWebtoon(e) {
    console.log('searching');
    searchUrl = 'search.php?s=' + e.target.value;
    searchWebtoons(searchUrl).then(webtoonsFound => document.getElementById("search-items").innerHTML = webtoonsFound);
    console.log('searching done');
    searchItems.textContent = e.target.value;
}

async function searchWebtoons(searchUrl) {
    const response = await fetch(searchUrl);
    const webtoonsFound = await response.text();
    return webtoonsFound;
}