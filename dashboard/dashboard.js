function auto_grow(element) {
	element.style.height = "5px";
	element.style.height = element.scrollHeight - 4 + "px";
}
getData();
document.getElementById("add").addEventListener("click", addData);
function addData() {
	let taskValue = document.getElementById("task").value;
	let lenguageValue = document.getElementById("lenguage").value;
	let textareaValue = document.getElementById("textarea").value;
	console.log(getParam("name"));
	$.ajax({
		url: "./todoList.php",
		type: "POST",
		data: {
			api: "add",
			task: taskValue,
			lang: lenguageValue,
			textarea: textareaValue,
			name: getParam("name"),
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
			name: getParam("name"),
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
	tr.appendChild(tdDescripcion);
	let tdModify = document.createElement("td");
	tdModify.innerHTML = "MODIFY";
	tdModify.classList.add("modify_button");
	tr.appendChild(tdModify);

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
