"use strict";
const button = document.getElementById("send");
document.getElementById("send").addEventListener("click", registrarUsuario);
grecaptcha.ready(function () {
	// do request for recaptcha token
	// response is promise with passed token
	grecaptcha
		.execute("6LemHlMgAAAAAGD8ffNCg2Je52M2sJsuLQU5xkH3", {
			action: "validate_captcha",
		})
		.then(function (token) {
			// add token value to form
			document.getElementById("g-recaptcha-response").value = token;
			console.log(token);
			checkRecaptcha();
		});
});
function checkRecaptcha() {
	const captcha_value = document.getElementById("g-recaptcha-response").value;
	if (captcha_value != "") {
		button.disabled = false;
		return true;
	}
	return false;
}

///////

function registrarUsuario() {
	let email_value = document.getElementById("email").value;
	let name_value = document.getElementById("name").value;
	let phone_value = document.getElementById("phone").value;
	let password_value = document.getElementById("password").value;
	let captcha_value = document.getElementById("g-recaptcha-response").value;
	let checkEmail = email_value.length > 3 || isNaN(email_value);
	let checkName = name_value.length > 3 || isNaN(name_value);
	let checkPhone = phone_value.length == 9 || !isNaN(phone_value);
	let checkPassword = password_value.length > 3 || isNaN(password_value);
	if (
		checkEmail &&
		checkName &&
		checkPhone &&
		checkPassword &&
		checkRecaptcha()
	) {
		$.ajax({
			url: "./registro.php",
			type: "POST",
			data: {
				action: "checkEmail",
				email: email_value,
				name: name_value,
				phone: phone_value,
				password: password_value,
				captcha: captcha_value,
			},
			dataType: "json",
			success: function (response) {
				console.log(response);
				if (response == 0) {
					console.error("response");
					console.error(response);
				} else {
					if ("error" in response) {
						console.log("ERROR");
						checkEmail = false;
					} else {
						console.log("OK");
						checkEmail = true;
						console.log(response.success);
						console.log(response.userToken);
						console.log(response.sendEmail);
						showMessage(name_value);
					}
					colorInput(checkEmail, checkName, checkPhone, checkPassword);
				}
			},
			error: function (error) {
				console.error("error");
				console.error(error);
				colorInput(checkEmail, checkName, checkPhone, checkPassword);
			},
		});
	} else {
		colorInput(checkEmail, checkName, checkPhone, checkPassword);
	}
}
function showMessage(name_value) {
	let success = document.getElementById("registerSuccess");
	let text = document.createElement("h2");
	text.innerHTML = `${name_value} Le hemos enviado un email para confirmar el registro.`;
	success.appendChild(text);
	document.getElementById("regiserForm").style.display = "none";
}
function colorInput(checkEmail, checkName, checkPhone, checkPassword) {
	if (checkEmail) {
		document.getElementById("email").classList.remove("input_error");
		document.getElementById("email").classList.add("input_success");
	} else {
		document.getElementById("email").classList.remove("input_success");
		document.getElementById("email").classList.add("input_error");
	}
	if (checkName) {
		document.getElementById("name").classList.remove("input_error");
		document.getElementById("name").classList.add("input_success");
	} else {
		document.getElementById("name").classList.remove("input_success");
		document.getElementById("name").classList.add("input_error");
	}
	if (checkPhone) {
		document.getElementById("phone").classList.remove("input_error");
		document.getElementById("phone").classList.add("input_success");
	} else {
		document.getElementById("phone").classList.remove("input_success");
		document.getElementById("phone").classList.add("input_error");
	}
	if (checkPassword) {
		document.getElementById("password").classList.remove("input_error");
		document.getElementById("password").classList.add("input_success");
	} else {
		document.getElementById("password").classList.remove("input_success");
		document.getElementById("password").classList.add("input_error");
	}
}
