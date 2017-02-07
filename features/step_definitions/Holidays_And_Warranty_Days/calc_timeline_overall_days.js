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

  this.Then(/^User should be in project$/,function(){
    this.driver.findElement({ css: '.hamb' }).click();
    this.driver.findElement({ css: '.all-projects>a' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^I click on any link of Estimation project \(Let us check this project "([^"]*)"\)$/, function (projNumber) {

    this.driver.findElement({ css:'#tabs-1 .wrap-project:nth-of-type('+projNumber+') .estimate-span .detail-plan' }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^Enter valid data in the field of holidays or warranty \(Let put the number of "([^"]*)" and "([^"]*)"\)$/, function (days, ID) {
    this.driver.findElement({ id:'Warrenty-days' }).clear();
    this.driver.findElement({ id:'Warrenty-period-holiday' }).clear();
    this.driver.findElement({ id: ID }).sendKeys(days);
    this.driver.sleep(2000);
  });

  this.Then(/^Column of Timeline Overall \(Days\) should display zero$/, function () {
    this.driver.findElement({ id:'timelineDays' }).then(function(goLive){
      var checkVal=goLive.getAttribute('value').then(function(value){
        if(value==""){
          console.log("Passed => Field of timeline overall days are 0");
        }
        else{
          console.log("Failed => Field of timeline overall live days are "+value);
        }
      });
    });
  });

};

