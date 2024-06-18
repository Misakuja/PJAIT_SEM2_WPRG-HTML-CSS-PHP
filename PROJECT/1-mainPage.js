function openSideNav() {
    document.getElementById("sideNav").style.width = "250px";
}

function closeSideNav() {
    document.getElementById("sideNav").style.width = "0";
}

const images = [
    "https://images.alphacoders.com/109/1094371.jpg",
    "https://i.imgur.com/AXE2Vg1.png",
    "https://i.imgur.com/v4rd78Z.png",
    "https://i.imgur.com/lgehqA3.jpeg"
];
let currentIndex = 0;

function changeImage() {
    const headerBackgroundDiv = document.getElementById('header-background');
    headerBackgroundDiv.style.backgroundImage = `url('${images[currentIndex]}')`;
    currentIndex = (currentIndex + 1) % images.length;
}
changeImage();
setInterval(changeImage, 5000);

