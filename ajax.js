/*
Using AJAX to process the article feed
*/

function createRequest() {
    var xhr = false;  
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
}

var xhr = createRequest();
var xhrImages = createRequest(); 

function setArticleFeed(dataSource, target, dataSource2, target2) {
	if (xhr && xhrImages) {
		var obj = document.getElementById(target);
		xhr.open("POST", dataSource, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4 && xhr.status == 200 ) {
				obj.innerHTML = xhr.responseText;
			}
		}
		xhr.send();

		var obj2 = document.getElementById(target2); 
		xhrImages.open("POST", dataSource2, true); 
		xhrImages.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhrImages.onreadystatechange = function () {
			if (xhrImages.readyState == 4 && xhrImages.status == 200 ) {
				obj2.innerHTML = xhrImages.responseText;
				console.log('line37'); 
			}
		}
		xhrImages.send();
	}
}

function createThread(dataSource, target, threadTitle, threadContent) {
	if (xhr) {
		var obj = document.getElementById(target);
		var requestbody = "threadTitle=" + encodeURIComponent(threadTitle) + "&threadContent=" + encodeURIComponent(threadContent);
		xhr.open("POST", dataSource, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4 && xhr.status == 200) {
				obj.innerHTML = xhr.responseText;
			}
		}
		xhr.send(requestbody);
	}
	document.getElementById('thread-formform').reset();
}

function deleteThread(dataSource, threadID) {
	console.log("deleteThread() has been called");
	if (xhr) {
		var requestbody = "threadID=" + encodeURIComponent(threadID);
		xhr.open("POST", dataSource, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(requestbody);
	}
	location.replace("https://space-hub.azurewebsites.net/discussion.html");
}

function likeThread(btn, dataSource, threadID) {
	if (xhr) {
		var obj = document.getElementById("like-span");
		var requestbody = "threadID=" + encodeURIComponent(threadID)
		xhr.open("POST", dataSource, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4 && xhr.status == 200) {
				obj.innerHTML = xhr.responseText;
			}
		}
		xhr.send(requestbody);
	}
	console.log(btn);
	document.getElementById("fa fa-thumbs-up").className = "fa-thumbs-down";
}

function setCommentFeed(src, dst, thread_id) {
	if (xhr) {
		var obj = document.getElementById(dst);
		xhr.open("POST", src, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4 && xhr.status == 200) {
				obj.innerHTML = obj.innerHTML + xhr.responseText;
			}
		}

		body = "thread_id=" + thread_id;
		xhr.send(body);
	}
}

function deleteComment(src, thread_id, comment_id) {
	if (xhr) {
		var requestbody = "threadID=" + thread_id + "&commentID=" + comment_id;
		xhr.open("POST", src, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(requestbody);
                window.location.replace("https://space-hub.azurewebsites.net/viewdiscussion.php?thread_id=" + thread_id);
	}
}