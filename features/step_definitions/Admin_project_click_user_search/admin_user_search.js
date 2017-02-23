var expect = require('chai').expect;

module.exports = function() {

	this.World = require('../../support/world.js').World;

    //open the browser
    this.Given(/^Open browser Start Application "(.*?)"$/, function(url){
    	this.driver.get(url);
    });

    //enter username and password
    this.When(/^I enter valid Admin "(.*?)" and "(.*?)"$/, function(user,pass){
    	this.driver.findElement({ id: 'email' }).sendKeys(user);
    	this.driver.findElement({ id: 'password' }).sendKeys(pass);
    });

    //click on sign in button
    this.Then(/^User should be logged in and home page should open$/,function(){
    	this.driver.findElement({ css: '.submit-btn'}).click();
    });

    //click on mouse hamburger
    this.Then(/^I click on mouse hamberger$/, function(){
    	this.driver.findElement({ css: '.nav-hamber'}).click();
    	this.driver.sleep(1000);
    });

    //click on user in list
    this.Then(/^I click User in list$/, function(){
    	this.driver.findElement({ css: '.user'}).click();
    	this.driver.sleep(1000);
    });

    //enter some invalid data
    this.When(/^I enter some invalid "(.*?)"$/, function(data){
    	this.driver.findElement({ id: 'search'}).sendKeys(data);
    	this.driver.sleep(1000);
    });

    //checking out after entered invalid info
    this.Then(/^I should not see the result$/, function(){
    	this.driver.findElement({ css: '.dataTables_empty' }).then(function(element){
    		var value = element.getText().then(function(empty_value){
    			if(empty_value=="No matching records found"){
    				console.log("When search with wrong keyword: "+empty_value);
    			}
    		});
    	});
    });

    //enter valid data
    this.When(/^I enter some valid "(.*?)"$/, function(data){
    	this.driver.findElement({ id: 'search'}).clear();
    	this.driver.findElement({ id: 'search' }).sendKeys(data);
    	this.driver.sleep(1000);
    });

    //see the result related keyword
    this.Then(/^I should see the result on top$/, function(){

    });

};
