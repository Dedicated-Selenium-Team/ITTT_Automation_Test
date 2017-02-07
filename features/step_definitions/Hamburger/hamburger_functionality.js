var expect = require('chai').expect;

module.exports = function() {

	this.World = require('../../support/world.js').World;

    //open the browser
    this.Given(/^Open browser and Start Application "(.*?)"$/, function(url){
    	this.driver.get(url);
    });

    //enter username and password
    this.When(/^I enter valid "([^"]*)" and "([^"]*)"$/, function(user,pass){
    	this.driver.findElement({ id: 'email' }).sendKeys(user);
    	this.driver.findElement({ id: 'password' }).sendKeys(pass);
    });

    //click on sign in button
    this.Then(/^User should be logged in and home page should be open$/,function(){
    	this.driver.findElement({ css: '.submit-btn'}).click();
    });

   //click on mouse hamburger
   this.Then(/^I click on mouse hamberger$/, function(){
    this.driver.findElement({ css: '.nav-hamber'}).click();
    this.driver.sleep(1000);

    this.driver.findElement({ css: '.hamb-cross' }).then(function(element){
        var check_close = element.getAttribute("style").then(function(closed){
            console.log();
            if(closed=="display: block;"){
                console.log("result==>> After clicked on hamburger icon, hamburger panel opened");
            }else{
                console.log("result==>> After clicked on hamburger icon, hamburger panel not opened");
            }
        });
    });
});

    //I should see the list
    this.Then(/^I should see list of tab$/, function() {
        this.driver.findElements({ css: '.navigation-menu li a' }).then(function(nav_list){
            console.log("Hamburger value list:");
            for(var i=0; i<nav_list.length; i++){
                var j =1;
                var nav_item = nav_list[i].getText().then(function(nav_value){
                    if(nav_value){
                        console.log(j++ + ": " +nav_value);
                    }else{
                        console.log("In hamburger list no value is persent");
                    }
                });
            }
        });
    });


    //close the hamburger
    this.When(/^I click on close icon hamburger$/, function() {
        this.driver.findElement({ css: '.hamb-cross' }).then(function(close){
            close.click();
        });
    });

    //close the hamburger
    this.Then(/^Hamburger should be closed$/, function() {
        this.driver.findElement({ css: '.hamb-cross' }).then(function(element){
            var check_close = element.getAttribute("style").then(function(closed){
                console.log();
                if(closed=="display: none;"){
                    console.log("result==>> After clicked on cross icon hamburger tab closed");
                }else{
                    console.log("result==>> After clicked on cross icon hamburger tab not closed");
                }
            });
        });
    });

    //click on mouse hamburger
    this.Then(/^I click on mouses hamberger$/, function(){
    	this.driver.findElement({ css: '.nav-hamber'}).click();
    	this.driver.sleep(1000);
    });

    //check hover effect
    this.Then(/^I should see hover effect in list "([^"]*)"$/, function(list_num) {
        this.driver.actions()
        .mouseMove(this.driver.findElement({ css:'.navigation-menu li:nth-of-type('+list_num+') a' }))
        .perform();
        this.driver.sleep(2000);
    });

    //click on selected item
    this.Then(/^I click on timesheet option in list "([^"]*)"$/, function(list_num) {
        console.log("list: 1 => Timesheet, 2=> Project, 3=>user");
        this.driver.findElement({ css:'.navigation-menu li:nth-of-type('+list_num+') a' }).then(function(element){
            element.click();
            console.log("");
            console.log("Clicked list number: "+list_num);
        });
        this.driver.sleep(2000);
    });

    //checking hamburger panel closed and clicked item page opened
    this.When(/^I should see Clicked item page open$/, function() {
        this.driver.findElement({ css: '.hamb-cross' }).then(function(element){
            var check_close = element.getAttribute("style").then(function(closed){
                if(closed=="display: none;"){
                    console.log("result==>> After clicked on list of hamburger, hamburger panel closed");
                }else{
                    console.log("result==>> After clicked on list of hamburger, hamburger panel closed");
                }
            });
        });

        //checking current page
        this.driver.getCurrentUrl().then(function(url){
            console.log("Result==>> After clicked of item "+url+ " page opened");
        });
    });

    //click on mouse hamburger
    this.When(/^Again I click on mouse hamberger$/, function(){
        this.driver.findElement({ css: '.nav-hamber'}).click();
        this.driver.sleep(1000);
    });

    //click on selected item
    this.Then(/^Again I click on timesheet option in list "([^"]*)"$/, function(list_num) {
        this.driver.findElement({ css:'.navigation-menu li:nth-of-type('+list_num+') a' }).then(function(element){
            element.click();
            console.log();
            console.log("Clicked list number: "+list_num);
        });
        this.driver.sleep(2000);
    });

    //checking hamburger panel closed and clicked item page opened
    this.Then(/^Again I should see Clicked item page open$/, function() {
        this.driver.findElement({ css: '.hamb-cross' }).then(function(element){
            var check_close = element.getAttribute("style").then(function(closed){
                if(closed=="display: none;"){
                    console.log("result==>> After clicked second time on list of hamburger, hamburger panel closed");
                }else{
                    console.log("result==>> After clicked second time on list of hamburger, hamburger panel closed");
                }
            });
        });
        
        //checking current page
        this.driver.getCurrentUrl().then(function(url){
            console.log("Result==>> After clicked second time of item "+url+ " page opened");
        });
    });

};