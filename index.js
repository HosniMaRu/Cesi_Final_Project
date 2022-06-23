document.getElementById("logPage").addEventListener("click", runLog);
document.getElementById("registerPage").addEventListener("click", runRegister);
document.getElementById("carrousel").addEventListener("click", () => {
	clearInterval(interval);
});
let interval = setInterval(() => {
	plusSlides(1);
}, 3000);
function runLog() {
	window.location.replace("./login/login.html");
}
function runRegister() {
	window.location.replace("./registro/registro.html");
}
let slideIndex = 1;
function plusSlides(n) {
	showSlides((slideIndex += n));
}
function currentSlide(n) {
	showSlides((slideIndex = n));
}

function showSlides(n) {
	let i;
	let slides = document.getElementsByClassName("mySlides");
	let dots = document.getElementsByClassName("dot");
	if (n > slides.length) {
		slideIndex = 1;
	}
	if (n < 1) {
		slideIndex = slides.length;
	}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	for (i = 0; i < dots.length; i++) {
		dots[i].className = dots[i].className.replace(" active", "");
	}
	slides[slideIndex - 1].style.display = "block";
	dots[slideIndex - 1].className += " active";
}

showSlides(slideIndex);
