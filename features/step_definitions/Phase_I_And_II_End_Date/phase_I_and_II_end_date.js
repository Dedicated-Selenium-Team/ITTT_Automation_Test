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

  this.Then(/^Click on the field of Phase I or Phase II End Date \(Let us put "([^"]*)"\)$/, function (phase) {
    this.driver.findElement({ id: phase }).then(function(projStart){
      var currDate=projStart.getAttribute('value').then(function(value){
        console.log("Current date is "+value);
      });
    });

    this.driver.findElement({ id: phase }).click();
    this.driver.sleep(2000);
  });

  this.Then(/^Then select "([^"]*)", "([^"]*)" and "([^"]*)"$/, function(date,month,year){
    //Select Month from dropdown
    var desiredMonth;
    var selectMonth=this.driver.findElement({css:'.ui-datepicker-month'});
    selectMonth.click();
    selectMonth.findElements({css:'option'}).then(function findMatchingOption(options){
      options.some(function(option){
        option.getText().then(function doesOptionMatch(text){
          if (month === text){
            desiredMonth = option;
            return true;
          }
        });
      });
    })
    .then(function clickOption(){
      if (desiredMonth){
        desiredMonth.click();
      }
    });
    this.driver.sleep(2000);

    //Select Year from dropdown
    var desiredYear;
    var selectYear=this.driver.findElement({css:'.ui-datepicker-year'});
    selectYear.click();
    selectYear.findElements({css:'option'}).then(function findMatchingOption(options){
      options.some(function(option){
        option.getText().then(function doesOptionMatch(text){
          if (year === text){
            desiredYear = option;
            return true;
          }
        });
      });
    })
    .then(function clickOption(){
      if (desiredYear){
        desiredYear.click();
      }
    });

    // Select date and click
    this.driver.findElements({ css:'.ui-datepicker-calendar td'}).then(function(cols){
      for(var i=0;i<cols.length;i++){
        if(i==date){
          cols[i+3].click();
        }
      }
    });

    this.driver.sleep(2000);
  });

  this.Then(/^The same selected month, year and date should reflect in the Phase I End Date and Phase II End Date field in the format of  mm\/dd\/yyyy$/, function () {

    // phase I end date
    this.driver.findElement({ id:'phase-I-end-date' }).then(function(projStart){
      var selectedDate=projStart.getAttribute('value').then(function(value){
        console.log("Selected Phase I date is "+value);
      });
    });

    // phase II end date
    this.driver.findElement({ id:'phase-II-end-date' }).then(function(projStart){
      var reflectedDate=projStart.getAttribute('value').then(function(value){
        console.log("Reflected Phase II date is "+value);
      });
    });
  });

};

