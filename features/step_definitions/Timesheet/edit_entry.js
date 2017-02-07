'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application \(Edit\)"([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^Enter valid "([^"]*)" and "([^"]*)"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  this.Then(/^User should be logged in and home page should be open$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^Edit icon for project should be visible in Web Page$/, function () {
    this.driver.findElement({ id:'edit-day-time' }).then(function(edit){
      if(edit.isDisplayed()){
        console.log("Edit button is displayed");
      }
      else{
        console.log("Edit button is not displayed");
      }
    });
  });

  this.Then(/^After I click on the Edit icon pop up should get display$/, function () {
    this.driver.findElement({ id:'edit-day-time' }).then(function(edit){
      if(edit.isDisplayed()){
        edit.click();
      }
    });

    this.driver.findElement({ css:'.modal' }).then(function(modal){
      if(modal.isDisplayed()){
        console.log("Edit pop up is displayed");
      }
      else {
       console.log("Edit pop up is not displayed"); 
     }
   });
    this.driver.sleep(3000);
  });

  this.Then(/^After I click on the update entry button, hrs should get display\/ reflected on the page "([^"]*)"$/, function (hrs) {

    //current hours
    this.driver.findElement({ css:'.day-table tbody tr:nth-of-type(2) td:nth-of-type(2)' }).then(function(currentHrs){
      var currHrs=currentHrs.getText().then(function(text){
        console.log("Current Hours => "+text);
      });
    });


    // update hours
    this.driver.findElement({ id:'hrs_locked' }).clear();
    this.driver.findElement({ id:'hrs_locked' }).sendKeys(hrs);

    this.driver.sleep(2000);

    this.driver.findElement({ id:'save' }).then(function(update){
      update.click();
    });
    this.driver.sleep(2000);

     //current hours
     this.driver.findElement({ css:'.day-table tbody tr:nth-of-type(2) td:nth-of-type(2)' }).then(function(currentHrs){
      var currHrs=currentHrs.getText().then(function(text){
        console.log("Updated Hours => "+text);
      });
    });
   });

};
