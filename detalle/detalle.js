document.getElementById("modify").addEventListener("click", modifyData);
document.getElementById("back").addEventListener("click", goBack);
const textareea = document.getElementById("textarea");
const taskInput = document.getElementById("task");
const lenguageInput = document.getElementById("lenguage");

getData();
function getData() {
	$.ajax({
		url: "detalle.php",
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
					printToModify(response.task, response.lenguage, response.descripcion);
					auto_grow(textareea);
					inputMaxLength(taskInput);
					inputMaxLength(lenguageInput);
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}
function modifyData() {
	$.ajax({
		url: "detalle.php",
		type: "POST",
		data: {
			api: "modify",
			id: getParam("id"),
			task: document.getElementById("task").value,
			lenguage: document.getElementById("lenguage").value,
			description: document.getElementById("textarea").value,
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
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}
function inputMaxLength(element) {
	if (element.value.length == element.getAttribute("maxlength")) {
		console.log("max");
		document.getElementsByClassName(element.id)[0].style.visibility = "visible";
	} else {
		console.log("min");
		document.getElementsByClassName(element.id)[0].style.visibility = "hidden";
	}
}
function auto_grow(element) {
	element.style.height = "5px";
	element.style.height = element.scrollHeight - 4 + "px";
}
function printToModify($task, $lenguage, $description) {
	document.getElementById("task").value = $task;
	document.getElementById("lenguage").value = $lenguage;
	document.getElementById("textarea").value = $description;
}
function getParam(paramName) {
	let queryString = window.location.search;
	let urlParams = new URLSearchParams(queryString);
	return urlParams.get(paramName);
}
function goBack() {
	window.location.href = "../dashboard/dashboard.html?id=" + getParam("idlist");
}
