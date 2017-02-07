var expect = require('chai').expect;

module.exports = function() {

	this.World = require('../../support/world.js').World;

	this.Given(/^Open browser and Start Application "([^"]*)"$/, function(url) {
		this.driver.get(url);
	});

	this.When(/^I enter valid "([^"]*)" and "([^"]*)"$/, function(user, pass) {
		this.driver.findElement({ id: 'email' }).sendKeys(user);
		this.driver.findElement({ id: 'password' }).sendKeys(pass);
	});

	this.Then(/^User should be logged in and home page should be open$/, function() {
		this.driver.findElement({ css: '.submit-btn'}).click();
	});

	this.When(/^I click on mouse hamberger$/, function() {
		this.driver.findElement({ css: '.nav-hamber'}).click();
		this.driver.sleep(1000);
	});

	this.Then(/^I see project option and click on project$/, function() {
		this.driver.findElement({ css:'.navigation-menu li:nth-of-type(2) a' }).then(function(element){
			element.click();
		});
		this.driver.sleep(1000);
	});

	this.Then(/^I should on estimation page$/, function() {
		this.driver.findElement({ css:'.estimate-span .detail-plan' }).then(function(element){
			element.click();
		});
	});

	this.When(/^I click on project start date option$/, function() {
		this.driver.findElement({ css:'#project-start-date' }).then(function(element){
			element.click();
			var value = element.getAttribute("value").then(function(date_value){
				console.log("Project start date is: "+ date_value);
			});
		});
	});

	this.Then(/^I should see same date highlited in calender$/, function() {
		this.driver.findElement({ css: '.ui-datepicker' }).then(function(calender){
			if(calender.isDisplayed()){
				console.log("Project start Calender is displayed");
				console.log();
			}
		});
		this.driver.sleep(1000);
	});

	this.When(/^I click on phase one end date$/, function() {
		this.driver.findElement({ css:'#phase-I-end-date' }).then(function(element){
			element.click();
			var value = element.getAttribute("value").then(function(date_value){
				console.log("Project Phase 1 end date is: "+ date_value);
			});
		});
	});

	this.Then(/^I should see same phase one date highlited in calender$/, function() {
		this.driver.findElement({ css: '.ui-datepicker' }).then(function(calender){
			if(calender.isDisplayed()){
				console.log("Phase 1 end date Calender is displayed");
				console.log();
			}
		});
		this.driver.sleep(1000);
	});

	this.When(/^I click on phase two end date$/, function() {
		this.driver.findElement({ css:'#phase-II-end-date' }).then(function(element){
			element.click();
			var value = element.getAttribute("value").then(function(date_value){
				console.log("Project Phase 2 end date is: "+ date_value);
			});
		});
	});

	this.Then(/^I should see same phase two date highlited in calender$/, function() {
		this.driver.findElement({ css: '.ui-datepicker' }).then(function(calender){
			if(calender.isDisplayed()){
				console.log("Phase 2 end date Calender is displayed");
				console.log();
			}
		});
		this.driver.sleep(1000);
	});
	this.When(/^I Enter valid day "([^"]*)" in Warranty Days field$/, function(day) {
		this.driver.findElement({ css: '#Warrenty-days' }).then(function(element){
			element.clear();
			element.sendKeys(day);
		});
	});

	this.Then(/^Day will be entered when day is numaric value$/, function () {
		this.driver.findElement({ css: '#Warrenty-days' }).then(function(element){
			var value = element.getAttribute("value").then(function(entered_value){
				if(entered_value){
					console.log(" days is entered");
				}else{
					console.log("Days not entered, value is wrong");
				}
			});
		});
	});

	this.Then(/^Day Will not entered if day is not numaric "([^"]*)" value$/, function (day) {
		this.driver.findElement({ css: '#Warrenty-days' }).then(function(element){
			element.clear();
			element.sendKeys(day);
		});

		this.driver.findElement({ css: '#Warrenty-days' }).then(function(element){
			var value = element.getAttribute("value").then(function(entered_value){
				if(entered_value){
					console.log(" days is entered");
				}else{
					console.log(" " +day +" Days not entered, value is wrong");
				}
			});
		});
	});
	
	this.When(/^I Enter valid day "([^"]*)" in holiday field$/, function (day) {
		this.driver.findElement({ css: '#Warrenty-period-holiday' }).then(function(element){
			element.clear();
			element.sendKeys(day);
		});
	});

	this.Then(/^Day will be entered when day is between I to XV numaric value$/, function () {
		this.driver.findElement({ css: '#Warrenty-period-holiday' }).then(function(element){
			var value = element.getAttribute("value").then(function(entered_value){
				if(entered_value){
					console.log(entered_value+" holiday is entered");
				}else{
					console.log("Holiday not entered, value is more then 15");
				}
			});
		});
	});

	this.Then(/^Day Will not entered if day is greater then XV "([^"]*)"$/, function (day) {
		this.driver.findElement({ css: '#Warrenty-period-holiday' }).then(function(element){
			element.clear();
			element.sendKeys(day);
		});

		this.driver.findElement({ css: '#Warrenty-period-holiday' }).then(function(element){
			var value = element.getAttribute("value").then(function(entered_value){
				if(entered_value){
					console.log(entered_value+" holiday is entered");
				}else{
					console.log(day+" Holiday not entered, value is more then 15");
				}
			});
		});
	});

};