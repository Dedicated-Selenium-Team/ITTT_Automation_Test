var expect = require('chai').expect;
var assert = require('assert');

module.exports = function() {

	this.World = require('../../support/world.js').World;

    //open url in browser
    this.Given(/^I open site in browser"(.*?)"$/, function(url){
    	this.driver.get(url);
    }); 

    //enter username and password
    this.When(/^I have to enter "(.*?)" and "(.*?)"$/, function(user, pass){
    	this.driver.findElement({ css: '#email'}).sendKeys(user);
    	this.driver.findElement({ css: '#password'}).sendKeys(pass);
    	this.driver.sleep(1000);
    });

    //click on login 
    this.Then(/^I click button for login$/, function(){
    	this.driver.findElement({ css: '.submit-btn'}).click();
    });
    
    //click on mouse hamburger
    this.Then(/^I click on mouse hamberger$/, function(){
    	this.driver.findElement({ css: '.nav-hamber'}).click();
    	this.driver.sleep(1000);
    });
    
    //click on project in the list
    this.When(/^I click Project in list$/, function(){
    	this.driver.findElement({ css: '.all-projects'}).click();
    	this.driver.sleep(1000);
    });
    
    //checking hover and tooltip
    this.Then(/^I check hover and tooltip on edit option$/, function(){
    	// this.driver.actions()
    	// .mouseMove(this.driver.findElement({ css: 'ul.ui-tabs-nav li:nth-child(5)' }))
    	// .perform();
    	// this.driver.sleep(1000);

    	// var tool = 'Edit';
    	// this.driver.findElements({ css:'.edit-action' }).then(function(edit_tooltip){
    	// 	console.log("Tooptip list for edit are:");
    	// 	for(var i=0;i<edit_tooltip.length;i++){
    	// 		var values=edit_tooltip[i].getAttribute("title").then(function(tooltip_name){
    	// 			// assert.equal(tooltip_name,tool);
    	// 			if(tooltip_name==tool){
    	// 				console.log("Edit action's Tooltip Name: "+tooltip_name);
    	// 			}
    	// 		});
    	// 	}
    	// });
    });
    
    //click on edit icon
    this.When(/^I click on edit icon$/, function(){  	
        this.driver.findElement({ css: '#project_action' }).then(function(select){
            var data = select.click();
        });

        this.driver.findElement({ css: '.edit-action' }).click();
    });

    
    //print list of input name and type
    this.Then(/^I should be see client name and project name$/, function(){
    	this.driver.findElements({ css:'.modal-body .form-group input' }).then(function(input_list){
    		console.log(" ");
    		console.log("Input list are:");
    		for(var i=0;i<input_list.length;i++){
    			var values=input_list[i].getAttribute("name").then(function(input_name){
    				console.log("Input Name: "+input_name);
    			});
    			var values=input_list[i].getAttribute("type").then(function(input_type){
    				console.log("Input Type: "+input_type);
    			});
    		}
    	});
    });
    
    //update button displaying or not
    this.Then(/^I should see update button$/, function(){
    	this.driver.findElement({ css: '.save-project input'}).then(function(update){
    		if(update.isDisplayed()){
    			console.log("");
    			console.log("Result==>> Update button is displayed");
    		}
    		else{
    			console.log("Result==>> Update button is not displayed");
    		}

    	});
    });
};