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

  this.Then(/^I click the "([^"]*)", projects of estimates phase appears in WP$/, function (ids) {
    this.driver.findElement({ id: ids }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^I should see the mouse pointer changes to the hand pointer on hovering on Move To button \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (projNumber,tab) {
    this.driver.actions().mouseMove(this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') #pStatus' })).perform();
    this.driver.sleep(2000);
  });

  this.Then(/^tool tip appears on hovering on move to button \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (projNumber,tab) {
    this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') #pStatus' }).then(function(detailPlan){
      var checkToolTip=detailPlan.getAttribute('title').then(function(toolTip){
        console.log("Tooltip text is => "+toolTip);
      });
    });
    this.driver.sleep(2000);
  });

  this.Then(/^I click the Move to button \(Let us check this project "([^"]*)" and "([^"]*)"\)$/, function (projNumber,tab) {
    this.driver.findElement({ css:'#'+tab+' .wrap-project:nth-of-type('+projNumber+') #pStatus' }).then(function(moveTo){
      if(moveTo.isDisplayed()){
        console.log("Move to button is present");

        //After I click move to button, drop-down should appear denoting following options Live-Projects, Live-Ongoing and Completed
        moveTo.click();
      }
      else{
        console.log("Move to button is not present");
      }
    });
    this.driver.sleep(2000);
  });
};
