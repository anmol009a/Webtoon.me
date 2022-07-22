// ================================================
// Method: 1
{
    async function getWebtoons(webtoonType) {
        console.log('Inside getWebtoons function');
        const response = await fetch(webtoonType);
        console.log('before response');
        const webtoons = await response.text();
        document.getElementById("webtoon-container").innerHTML = webtoons;
        return webtoons;
    }

    // let showWebtoons = getWebtoons('webtoon_grid.php');
    // showWebtoons.then(webtoons => document.getElementById("webtoon-container").innerHTML = webtoons);

    function showWebtoons(webtoonType, getWebtoonsFunction) {
        let showWebtoons = getWebtoons(webtoonType);
        showWebtoons.then(webtoons => document.getElementById("webtoon-container").innerHTML = webtoons);

    }

    showWebtoons('webtoon_grid.php', getWebtoons);

    // webtoon type btn handler
    {
        let fetchWebtoonTypeBtn = document.getElementById('webtoon-type-btn');
        fetchWebtoonTypeBtn.addEventListener('click', fetchWebtoonTypeBtnHandler)
        
        function fetchWebtoonTypeBtnHandler() {
            console.log('You have clicked the fetchWebtoonTypeBtn');
            
            
            if (fetchWebtoonTypeBtn.getAttribute("name") == "webtoon-btn") {
                showWebtoons('adult_webtoon_grid.php', getWebtoons);
                // -----------------------------------------
                fetchWebtoonTypeBtn.setAttribute("name", "adult-webtoon-btn");
                fetchWebtoonTypeBtn.innerText = "NON"
                
            } else {
                showWebtoons('webtoon_grid.php', getWebtoons);
                // ---------------------------------------------
                fetchWebtoonTypeBtn.setAttribute("name", "webtoon-btn");
                fetchWebtoonTypeBtn.innerText = "Webtoon"
            }
        }
        
    }
}


// ================================================
// Method: 2
{
    // Instantiate an xhr object
    const xhr = new XMLHttpRequest();
    
    // Open the object
    xhr.open('GET', 'webtoon_grid.php', true);
    
    // What to do on progress (optional)
    xhr.onprogress = function () {
        console.log('On progress');
    }
    
    // What to do when response is ready
    xhr.onload = function () {
        if (this.status === 200) {
            // console.log(this.responseText)
            // -----------------------------------------------------------
            let str = this.responseText;
            document.getElementById("webtoon-container").innerHTML = str;
            
            
        } else {
            console.log("Some error occured")
        }
    }
    xhr.send();
    
    // webtoon type btn handler
    {
        let fetchWebtoonTypeBtn = document.getElementById('webtoon-type-btn');
        fetchWebtoonTypeBtn.addEventListener('click', fetchWebtoonTypeBtnHandler)
        
        function fetchWebtoonTypeBtnHandler() {
            console.log('You have clicked the fetchWebtoonTypeBtn');
            
            // Instantiate an xhr object
            const xhr = new XMLHttpRequest();
            
            if (fetchWebtoonTypeBtn.getAttribute("name") == "webtoon-btn") {
                // Open the object
                xhr.open('GET', 'adult_webtoon_grid.php', true);
                
                // -----------------------------------------
                fetchWebtoonTypeBtn.setAttribute("name", "adult-webtoon-btn");
                fetchWebtoonTypeBtn.innerText = "NON"

            } else {
                xhr.open('GET', 'webtoon_grid.php', true);
                // ---------------------------------------------
                fetchWebtoonTypeBtn.setAttribute("name", "webtoon-btn");
                fetchWebtoonTypeBtn.innerText = "Webtoon"
            }

            // What to do on progress (optional)
            xhr.onprogress = function () {
                console.log('On progress');
            }

            // What to do when response is ready
            xhr.onload = function () {
                if (this.status === 200) {
                    console.log(this.responseText)
                    // -----------------------------------------------------------
                    let str = this.responseText;
                    document.getElementById("webtoon-container").innerHTML = str;


                } else {
                    console.log("Some error occured")
                }
            }
            xhr.send();
        }
    }
}