function auto_grow(element) {
	element.style.height = "5px";
	element.style.height = element.scrollHeight - 4 + "px";
}
document.getElementById("add").addEventListener("click", getData);
function getData() {
	let taskValue = document.getElementById("task").value;
	let lenguageValue = document.getElementById("lenguage").value;
	let textareaValue = document.getElementById("textarea").value;
	console.log(taskValue, lenguageValue, textareaValue);

	$.ajax({
		url: "./todoList.php",
		type: "POST",
		data: {
			api: "add",
			task: taskValue,
			lang: lenguageValue,
			texarea: textareaValue,
		},
		dataType: "json",
		success: function (response) {
			if (response == 0) {
				console.warn(response);
			} else {
				console.log(response);
				if ("error" in response) {
					console.warn("ERROR");
					console.log(response);
				} else {
					console.warn("OK");
					response = JSON.parse(response);
				}
			}
		},
		error: function (error) {
			console.warn("ERROR: ");
			console.warn(error);
		},
	});
}
