"use strict";
document.getElementById("goHome").addEventListener("click", goHome);
const boton = document.getElementById("buttonRegistro");
boton.addEventListener("click", registrarUsuario);
const inputEmail = document.getElementById("emailSignUp");
const inputPassword = document.getElementById("passwordSignUp");

grecaptcha.ready(function () {
	grecaptcha
		.execute("6LemHlMgAAAAAGD8ffNCg2Je52M2sJsuLQU5xkH3", {
			action: "validate_captcha",
		})
		.then(function (token) {
			document.getElementById("g-recaptcha-response").value = token;
			checkRecaptcha();
		});
});
function checkRecaptcha() {
	let inputCaptcha_valor = document.getElementById(
		"g-recaptcha-response"
	).value;
	console.log(inputCaptcha_valor);
	if (inputCaptcha_valor != "") {
		boton.disabled = false;
		return true;
	}
	return false;
}
function goHome() {
	window.location.href = "../index.html";
}
function registrarUsuario() {
	let inputEmail_valor = inputEmail.value;
	let inputPassword_valor = inputPassword.value;

	let emailBoolean = true;
	let passwordBoolean = true;

	if (inputEmail_valor == "" || !isNaN(inputEmail_valor)) {
		emailBoolean = false;
	}
	if (inputPassword_valor == "" || !isNaN(inputPassword_valor)) {
		passwordBoolean = false;
	}
	$.ajax({
		url: "./log_API.php",
		type: "POST",
		data: {
			api: "loginUser",
			email: inputEmail_valor,
			password: inputPassword_valor,
			captcha: document.getElementById("g-recaptcha-response").value,
		},
		dataType: "json",
		success: function (response) {
			if (response == 0) {
				console.warn(response);
			} else {
				console.log(response);
				if ("error" in response) {
					console.warn("ERROR");
					emailBoolean = false;
					console.log(response);
				} else {
					console.warn("OK");
					emailBoolean = true;
					response.usuario = JSON.parse(response.usuario);
					crearCookie(response.usuario);
				}
				coloresCampos(emailBoolean, passwordBoolean);
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
			emailBoolean = false;
			coloresCampos(emailBoolean, passwordBoolean);
		},
	});
}

function coloresCampos(emailBoolean, passwordBoolean) {
	if (emailBoolean) {
		inputEmail.classList.remove("inputError");
		inputEmail.classList.add("inputSuccess");
	} else {
		inputEmail.classList.remove("inputSuccess");
		inputEmail.classList.add("inputError");
	}
	if (passwordBoolean) {
		inputPassword.classList.remove("inputError");
		inputPassword.classList.add("inputSuccess");
	} else {
		inputPassword.classList.remove("inputSuccess");
		inputPassword.classList.add("inputError");
	}
}

function crearCookie(user) {
	console.log(user);
	var exdays = 30;
	var d = new Date();
	d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
	var expires = "expires=" + d.toUTCString();
	document.cookie = "email=" + user.email + "; " + expires;
	document.cookie = "nombre=" + user.nombre + "; " + expires;
	document.cookie = "token=" + user.token + "; " + expires;

	window.location.replace("../dashboard/dashboard.html?id=" + user.id);
}

function getCookie(cname) {
	let name = cname + "=";
	let decodedCookie = decodeURIComponent(document.cookie);
	let ca = decodedCookie.split(";");
	for (let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while (c.charAt(0) == " ") {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}
