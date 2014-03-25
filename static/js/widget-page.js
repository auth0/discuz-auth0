console.log("whaaat2");
var widget;
widget = new Auth0Widget(widgetOptions);
var loginButton = document.getElementById("auth0-login-form");
loginButton.addEventListener('click',function(){
	widget.signin();
	return false;
});

