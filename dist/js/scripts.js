function triggerClick(e) {
  document.querySelector('#profileImage').click();
}
function displayImage(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}

function triggerClick2(e) {
  document.querySelector('#profileImage2').click();
}
function displayImage2(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay2').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}

function triggerClick3(e) {
  document.querySelector('#profileImage3').click();
}
function displayImage3(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay3').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}

function triggerClick4(e) {
  document.querySelector('#profileImage4').click();
}
function displayImage4(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay4').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}

function triggerClick5(e) {
  document.querySelector('#profileImage5').click();
}
function displayImage5(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay5').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}

var chatHistory = document.getElementById("#messageBody");
chatHistory.scrollTop = chatHistory.scrollHeight;