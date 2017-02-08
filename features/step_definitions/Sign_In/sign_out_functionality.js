'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application again"([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter valid entry "([^"]*)" and "([^"]*)"$/, function (username,password) {
    this.driver.findElement({ id: 'email' }).sendKeys(username);
    this.driver.findElement({ id: 'password' }).sendKeys(password);
  });

  this.Then(/^Click on sign in button$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^User must successfully logged in to the site$/, function () {
    this.driver.getTitle().then(function(title){
      if(title=="ITTT | Timesheet") {
        console.log("User successfully logged in to the site.");
      }
      else{
        console.log("User not logged in to the site.");
      }
    });
  });

  this.When(/^I click on sign\-out button$/, function () {
    this.driver.findElement({ css:'.logout' }).click(); 
  });

  this.Then(/^User must successfully logged out "([^"]*)"$/, function (url) {
    this.driver.getCurrentUrl().then(function(currUrl){
      if(currUrl==url){
        console.log("User successfully logged out");
      }
      else{
        console.log("User not logged out from the site");
      }
    });
    this.driver.sleep(2000);
  });

  this.When(/^I click on back button$/, function () {
    this.driver.navigate().back();
    this.driver.sleep(2000);
  });

  this.Then(/^The login page must be redirect "([^"]*)"$/, function (url) {
    this.driver.getCurrentUrl().then(function(currUrl){
      if(currUrl==url){
        console.log("User redirected to the login page");
      }
      else{
        console.log("User is not redirected to the login page");
      }
    });
  });
};
