
////////////////RECUPERATIONS DE DONNES UTILISATEUR
// On stock d'où vient le client
var token_chat = "";
var referrer = parent.document.referrer;
var uri = parent.document.URL;
// On cherche le navigateur et la langue du client
var navigateur;
var navigateur_version = navigator.appVersion;
var sBrowser;
var sUsrAg = navigator.userAgent;
var langue = navigator.language;
var moteur = navigator.product;
var cookies_autorisees = navigator.cookieEnabled;
var geolocation = navigator.geolocation;
if(sUsrAg.indexOf("Chrome") > -1) {
	navigateur = "Google Chrome";
} else if (sUsrAg.indexOf("Safari") > -1) {
	navigateur = "Apple Safari";
} else if (sUsrAg.indexOf("Opera") > -1) {
	navigateur = "Opera";
} else if (sUsrAg.indexOf("Firefox") > -1) {
	navigateur = "Mozilla Firefox";
} else if (sUsrAg.indexOf("MSIE") > -1) {
	navigateur = "Microsoft Internet Explorer";
	langue = navigator.userLanguage;
}
// On cherche le support du client
var support;
var userAgent = window.navigator.userAgent;
var platform = window.navigator.platform;
var macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'];
var windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'];
var iosPlatforms = ['iPhone', 'iPad', 'iPod'];
if (macosPlatforms.indexOf(platform) !== -1) {
	support = 'Mac OS';
} else if (iosPlatforms.indexOf(platform) !== -1) {
	support = 'iOS';
} else if (windowsPlatforms.indexOf(platform) !== -1) {
	support = 'Windows';
} else if (/Android/.test(userAgent)) {
	support = 'Android';
} else if (!os && /Linux/.test(platform)) {
	support = 'Linux';
}
