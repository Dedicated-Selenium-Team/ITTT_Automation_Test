'use strict';

var assert=require('assert');

module.exports = function() {
  this.World = require('../../support/world.js').World;

  this.Given(/^Open browser and Start Application "([^"]*)"$/, function (url) {
    this.driver.get(url);
  });

  this.When(/^I enter valid \"([^\"]*)\" and \"([^\"]*)\"$/, function (email,pass) {
    this.driver.findElement({ id: 'email' }).sendKeys(email);
    this.driver.findElement({ id: 'password' }).sendKeys(pass);
  });

  this.Then(/^User should be logged in and home page should be open$/, function () {
    this.driver.findElement({ css: '.submit-btn' }).click();
  });

  this.Then(/^Click on the Add To MySelf A Project  CTA$/, function () {
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.findElement({ css:'.assign-project' }).click();
  });

  this.Then(/^Detail Page get display and Breadcrumb also get display$/, function () {
    this.driver.getCurrentUrl().then(function(currUrl){
      console.log("Current url is "+currUrl);
    });

    this.driver.findElement({ css:'.current-page' }).then(function(breadCrumb){
      var currPage=breadCrumb.getText().then(function(text){
        console.log("Current Page is "+text);
      });
    });
  });

  this.Then(/^Now clik on the Breadcrumb link Projects$/, function () {
    this.driver.findElement({ css:'.bread-crumb a' }).click();
    this.driver.sleep(2000);

    this.driver.getCurrentUrl().then(function(currUrl){
      console.log("After click on link timesheet Current url is "+currUrl);
    });
  });
};
