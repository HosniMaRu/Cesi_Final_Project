function auto_grow(element) {
	element.style.height = "5px";
	element.style.height = element.scrollHeight - 4 + "px";
}
getData();
document
	.getElementById("textarea")
	.addEventListener("keypress", function (event) {
		if (event.key === "Enter") {
			event.preventDefault();
			document.getElementById("add").click();
		}
	});
document.getElementById("goHome").addEventListener("click", goHome);
document.getElementById("add").addEventListener("click", addData);
function addData() {
	let taskValue = document.getElementById("task").value;
	let lenguageValue = document.getElementById("lenguage").value;
	let textareaValue = document.getElementById("textarea").value;
	$.ajax({
		url: "./todoList.php",
		type: "POST",
		data: {
			api: "add",
			task: taskValue,
			lang: lenguageValue,
			textarea: textareaValue,
			id: getParam("id"),
		},
		dataType: "json",
		success: function (response) {
			if (response == 0) {
				console.warn(response);
			} else {
				if ("error" in response) {
					console.warn("ERROR");
					console.log(response);
				} else {
					console.warn("OK");
					console.log(response);
					clearTable();
					for (let i = 0; i < response.length; i++) {
						printTable(response[i]);
					}
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}

function getData() {
	$.ajax({
		url: "./todoList.php",
		type: "POST",
		data: {
			api: "get",
			id: getParam("id"),
		},
		dataType: "json",
		success: function (response) {
			if (response == 0) {
				console.warn(response);
			} else {
				if ("error" in response) {
					console.warn("ERROR");
					console.log(response);
				} else {
					console.warn("OK");
					console.log(response);
					for (let i = 0; i < response.length; i++) {
						if (response[i].id) {
							printTable(response[i]);
						}
					}
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}

function deleteRow(id) {
	$.ajax({
		url: "./todoList.php",
		type: "POST",
		data: {
			api: "delete",
			idrow: id,
			id: getParam("id"),
		},
		dataType: "json",
		success: function (response) {
			if (response == 0) {
				console.warn(response);
			} else {
				if ("error" in response) {
					console.warn("ERROR");
					console.log(response);
				} else {
					console.warn("OK");
					console.log(response);
					clearTable();
					for (let i = 0; i < response.length; i++) {
						if (response[i].id) {
							printTable(response[i]);
						}
					}
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}
function modifyRow(id) {
	$.ajax({
		url: "./todoList.php",
		type: "POST",
		data: {
			api: "get",
			idrow: id,
			id: getParam("id"),
		},
		dataType: "json",
		success: function (response) {
			if (response == 0) {
				console.warn(response);
			} else {
				if ("error" in response) {
					console.warn("ERROR");
					console.log(response);
				} else {
					console.warn("OK");
					console.log(response);
					window.location.replace(
						"../detalle/detalle.html?id=" +
							response[0].id +
							"&idlist=" +
							getParam("id") +
							"&nombre=" +
							getParam("nombre")
					);
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}
function printTable(response) {
	let tbody = document.getElementById("tbody");
	let tr = document.createElement("tr");

	let tdTask = document.createElement("td");
	tdTask.innerHTML = response.task;
	tr.appendChild(tdTask);

	let tdLenguage = document.createElement("td");
	tdLenguage.innerHTML = response.lenguage;
	tr.appendChild(tdLenguage);

	let tdDescripcion = document.createElement("td");
	tdDescripcion.innerHTML = response.descripcion;
	tdDescripcion.classList.add("input_desc");
	tr.appendChild(tdDescripcion);

	let tdModify = document.createElement("td");
	tdModify.innerHTML = "MODIFY";
	tdModify.addEventListener("click", () => {
		modifyRow(response.id);
	});
	tdModify.classList.add("table_button");
	tr.appendChild(tdModify);

	let tdDelete = document.createElement("td");
	tdDelete.innerHTML = "DELETE";
	tdDelete.addEventListener("click", () => {
		deleteRow(response.id);
	});

	tdDelete.classList.add("table_button");
	tr.appendChild(tdDelete);

	tbody.appendChild(tr);
}
function clearTable() {
	document.getElementById("tbody").innerHTML = "";
}
function getParam(paramName) {
	let queryString = window.location.search;
	let urlParams = new URLSearchParams(queryString);
	return urlParams.get(paramName);
}
function goHome() {
	$.ajax({
		url: "../login/logApi.php",
		type: "POST",
		data: {
			api: "logOut",
			nombre: getParam("nombre"),
		},
		dataType: "json",
		success: function (response) {
			console.log(response);
			if (response == 0) {
				console.warn(response);
			} else {
				console.log(response);
				if ("error" in response) {
					console.warn("ERROR");
					console.log(response);
				} else {
					console.warn("OK");
					console.log(response);
					console.log("response");
					deleteCookie();
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}
function deleteCookie() {
	document.cookie =
		"email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/login;";
	document.cookie =
		"nombre=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/login;";
	document.cookie =
		"token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/login;";
	window.location.replace(
		"../dashboard/dashboard.html?id=" + user.id + "nombre=" + user.nombre
	);
}
