
function login() {
    var blur = document.getElementById("container");
    var blur2 = document.getElementById("header");
    blur.classList.toggle("modalActive");
    blur2.classList.toggle("modalActive");
    var login = document.getElementById("login");
    login.classList.toggle("modalActive");
    console.log('login');
}
function signup() {
    var blur = document.getElementById("container");
    var blur2 = document.getElementById("header");
    blur.classList.toggle("modalActive");
    blur2.classList.toggle("modalActive");
    var signup = document.getElementById("signup");
    signup.classList.toggle("modalActive");
    console.log('signup');
}