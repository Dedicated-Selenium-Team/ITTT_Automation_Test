'use strict';

var fs = require('fs');
var webdriver = require('selenium-webdriver'),
username = "jpratikprdxn",
accessKey = "7a01ae9e-f246-400e-8610-fb6bb4be29e8",
driver;

var PLATFORMS = [{
	'browserName': 'chrome',
	'platform': 'Windows 10',
	'version': '54.0',
	'username': username,
	'accessKey': accessKey,
	'name': 'Tesing using Chrome in Windows 10'
},
{
	'browserName': 'firefox',
	'platform': 'Linux',
	'version': '45.0',
	'username': username,
	'accessKey': accessKey,
	'name': 'Tesing using Firfox in Linux' 
}];

for(var i=0; i<PLATFORMS.length; i++){
	console.log(PLATFORMS[i]);
	
	driver = new webdriver.Builder().
	withCapabilities(PLATFORMS[i]).
	usingServer("http://" + username + ":" + accessKey +
		"@ondemand.saucelabs.com:80/wd/hub").
	build();
}


// for android devices
// var buildAndroidDriver = function() {
// 	return new webdriver.Builder().
// 	withCapabilities({
// 		'browserName': 'chrome',
// 		'platformName': 'Android',
// 		'platformVersion': '5.0',
// 		'deviceName': 'Android Emulator',
// 		'username': username,
// 		'accessKey': accessKey
// 	}).
// 	usingServer("http://" + username + ":" + accessKey +
// 		"@ondemand.saucelabs.com:80/wd/hub").
// 	build();
// };

// for firefox browser on Linux
// var buildFirefoxDriver = function() {
// 	return new webdriver.Builder().
// 	withCapabilities({
// 		'browserName': 'firefox',
// 		'platform': 'Linux',
// 		'version': '45.0',
// 		'username': username,
// 		'accessKey': accessKey
// 	}).
// 	usingServer("http://" + username + ":" + accessKey +
// 		"@ondemand.saucelabs.com:80/wd/hub").
// 	build();
// };

// switch(platform) {
// 	case 'ANDROID':
// 	var driver = buildAndroidDriver();
// 	break;
// 	default:
// 	var driver = buildFirefoxDriver();
// }



// var buildAndroidDriver = function() {
// 	return new webdriver.Builder().
// 	usingServer('http://localhost:4444/wd/hub').
// 	withCapabilities({
// 		platformName: 'Android',
// 		platformVersion: '4.4',
// 		deviceName: 'Android Emulator',
// 		browserName: 'Chrome'
// 	}).
// 	build();
// };

//for saucelabs integration and selenium grid
// var capabilities = {
// 	browserName: process.env.SELENIUM_BROWSER,
// 	version: process.env.SELENIUM_VERSION,
// 	platform: process.env.SELENIUM_PLATFORM,
// 	username:process.env.SAUCE_USERNAME,
// 	accessKey:process.env.SAUCE_ACCESS_KEY
// };

// var driver = new webdriver.Builder().
// usingServer('http://@ondemand.saucelabs.com:80/wd/hub').
// withCapabilities(capabilities).
// build();
// capabilities.setBrowserName(System.getenv("SELENIUM_BROWSER"));
// capabilities.setVersion(System.getenv("SELENIUM_VERSION"));
// capabilities.setCapability(CapabilityType.PLATFORM, System.getenv("SELENIUM_PLATFORM"));

var getDriver = function() {
	return driver;
};

var World = function World() {

	var defaultTimeout = 20000;
	var screenshotPath = "screenshots";

	this.webdriver = webdriver;
	this.driver = driver;

	if(!fs.existsSync(screenshotPath)) {
		fs.mkdirSync(screenshotPath);
	}

	this.waitFor = function(cssLocator, timeout) {
		var waitTimeout = timeout || defaultTimeout;
		return driver.wait(function() {
			return driver.isElementPresent({ css: cssLocator });
		}, waitTimeout);
	};
};

module.exports.World = World;
module.exports.getDriver = getDriver;

