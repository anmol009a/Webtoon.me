// =========================================================
// Method: 1
// // targetting theme button
// var themeButton = document.getElementById('theme-button');

// // function to switch themes
// themeButton.onclick = function toggleTheme() {
//     // fetching current theme
//     let currentTheme = document.getElementById('body-theme');
// // checking current theme and then changing theme
// if (currentTheme.className === 'bg-dark text-light') {
//     currentTheme.className = ''; // changing theme class to light
// themeButton.innerText = 'Dark Mode'; // changing theme button text 
// } else {
//     currentTheme.className = 'bg-dark text-light'; // changing theme class to Dark
// themeButton.innerText = 'Light Mode'; // changing theme button text 
// }
// console.log(currentTheme);
// }

// ==============================================================
// Method: 2
// toogle method to change theme
function toogleTheme() {
    let element = document.body;
    element.classList.toggle("bg-dark");
    element.classList.toggle("text-light");
}