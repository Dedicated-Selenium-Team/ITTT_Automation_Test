'use strict';

var assert=require('assert');

module.exports = function() {
	this.World = require('../../support/world.js').World;

  //open url in browser
  this.Given(/^Open browser and Start Application "(.*?)"$/, function(url){
  	this.driver.get(url);
  });

   //enter username and password
   this.When(/^I enter valid "(.*?)" and "(.*?)"$/, function(user,pass){
   	this.driver.findElement({ id: 'email' }).sendKeys(user);
   	this.driver.findElement({ id: 'password' }).sendKeys(pass);
   });

   //i click on sign in button
   this.Then(/^I click signin and home page open$/, function(){
    this.driver.findElement({ css: '.submit-btn' }).click();
    this.driver.sleep(1000);
  });

   this.Then(/^I see hover effect on next button$/, function(){
    this.driver.actions()
    .mouseMove(this.driver.findElement({ css: '.next' }))
    .perform();
    this.driver.sleep(1000);

    this.driver.findElement({ css: '.next' }).then(function(element){
      var css_property = element.getCssValue('opacity').then(function(css_value){
        if(css_value==0.4){
          console.log("On hover next button opacity is: "+ css_value);
        }else{
          console.log("On Hover next button opacity is not matching with actual");
        }
      });      
    });
    this.driver.sleep(1000);

  });


  //click on next cta
  this.When(/^I click on next cta$/, function(){
    this.driver.findElement({ css: '.next' }).click();
    this.driver.sleep(1000);
  });

   //next date
   this.Then(/^I see next date on header$/, function(){
    this.driver.findElement({ css:'.day-timesheet .border-style' }).then(function(date_value){
      var select_cta=date_value.getAttribute("value").then(function(selected_date){
        console.log("Result===>>> After click next button date is: "+ selected_date);
      });
    });
    this.driver.sleep(2000);
  });

   //hover on prev button
   this.Then(/^I see hover effect on prev button$/, function(){
    this.driver.actions()
    .mouseMove(this.driver.findElement({ css: '.previous' }))
    .perform();
    this.driver.sleep(1000);

    this.driver.findElement({ css: '.previous' }).then(function(element){
      var css_property = element.getCssValue('opacity').then(function(css_value){
        if(css_value==0.4){
          console.log("On hover Prev button opacity is: "+ css_value);
        }else{
          console.log("On Hover Prev button opacity is not matching with actual");
        }
      });      
    });
    this.driver.sleep(1000);
  });

  //click on prev button
  this.When(/^click prev button$/, function(){
    this.driver.findElement({ css: '.previous' }).click();
    this.driver.sleep(1000);
  });

  ////next next date date
  this.Then(/^I see the previous date on header$/,function(){
    this.driver.findElement({ css:'.day-timesheet .border-style' }).then(function(date_value){
      var select_cta=date_value.getAttribute("value").then(function(selected_date){
        console.log("Result===>>> After click prev button date is : "+ selected_date);
      });
    });
    this.driver.sleep(2000);
  });
};