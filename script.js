const form = document.querySelector(".form");

if(form){
form.addEventListener("submit", (e) => {
  e.preventDefault();
  alert("Rezervarea a fost trimisă! Te contactăm curând 😊");
});
}

const foodImages = [
"https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?w=400", // pizza
"https://images.unsplash.com/photo-1608756687911-aa1599ab3bd9?w=400", // paste
"https://images.unsplash.com/photo-1546793665-c74683f339c1?w=400", // salata
"https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400", // pizza quattro
"https://images.unsplash.com/photo-1619895092538-128341789043?w=400", // lasagna
"images/risotto.jpg" // risotto
];

let index = 0;

function changeFood(){

const img1 = document.getElementById("food1");
const img2 = document.getElementById("food2");

if(img1 && img2){

img1.src = foodImages[index];
img2.src = foodImages[index + 1];

index += 2;

if(index >= foodImages.length){
index = 0;
}

}

}

setInterval(changeFood, 3000);
